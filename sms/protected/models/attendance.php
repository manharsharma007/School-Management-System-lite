<?php
/**
 * File contains necessary information that defines the bootstrap of your application
 * Source code pattern must not be modified
 * Files to be used with the comments.
 * @Author : Operce Technologies
 * @Developer : Manhar Sharma
 * @Year : 2016
 *
 *
 **/


/**
 * class for login
 * pattern must not be modified
 * Files to be used with the comments.
 *
 *
 */

defined('_DONUT') or die('Error. Invalid Access');

class attendance extends Model {
    public $page_title;
    public $message;
    public $flag;
    public $values;
    private $crud;

    function __construct() {
        $this->crud = new crud('attendance');
    }

    function process_attendance() {
        $this->values = $_POST;
        if(!$this->check_form($this->values, ['class'=>'Class', 'is_holiday' => 'Holiday'], '{is_holiday}')) {
            $this->flag = ERROR;
            return false;
        }
        
        if(!empty($this->values['is_holiday']))
        {
            $this->process_holiday();
        }

        else
        {
            $this->save_attendance();
        }

    }

    function process_holiday() { 
        $dt = new DateTime();
        $date = $dt->format('Y-m-d H:i:s');

        $prev = $this->check_prev_attendance();

        if(count($prev) > 0)
        {
            $this->flag = WARNING;
            $this->message = "Attendance already recorded";
            return false;
        }

        $data = $this->crud->insert( array('class' => $this->values['class'], 'date' => $date, 'is_holiday' => 1) );
        
        if($data > 0)
        {
            $this->flag = SUCCESS;
            $this->message = ' Attendance Added';
            return true;
        }
        else
        {
            $this->flag = ERROR;
            $this->message = "Error adding attendance";
            return true;
        }
    }

    function save_attendance() {

        $dt = new DateTime();
        $date = $dt->format('Y-m-d H:i:s');

        $prev = $this->check_prev_attendance();

        if(count($prev) > 0)
        {
            $this->flag = WARNING;
            $this->message = "Attendance already recorded";
            return false;
        }
        
        $con = $this->crud->get_connection();
        $con->beginTransaction();

        try
        {
            $attendance_id = $this->crud->insert( array('class' => $this->values['class'], 'date' => $date, 'is_holiday' => 0) );

            foreach ($_POST['case'] as $key => $value) 
            {

                $this->crud->changeTable('attendance_history');
                $data = $this->crud->insert( array('attendance_id' => $attendance_id, 'student_id' => $key, 'status' => $value) );

                $con->commit();

                $this->flag = SUCCESS;
                $this->message = 'Attendance recorded';
            }
        }
        catch(Exception $e)
        {
            $con->rollBack();
            $this->flag = ERROR;
            $this->message = "Error saving attendance. Error : ". $e->getMessage();
        }
    }

    function check_prev_attendance() {

        $query = 'SELECT * FROM attendance WHERE class = :class and date >= CURDATE()';
        $flag = false;        
        
        $data = $this->crud->exec_query($query, array(':class' => $this->values['class']))->fetchAll(PDO::FETCH_CLASS);
        return $data[0];
    }

    function fetch_students() {

        $this->values = $_POST;
        if(!$this->check_form($this->values, ['class'=>'Class'])) {
            $this->flag = ERROR;
            return false;
        }

        $query = "select * from students inner join parents_info on students.stu_id = parents_info.student_id inner join student_details on student_details.student_id = students.stu_id inner join class on students.student_class = class.class_id where student_class = :class and students.student_status = 'STUDYING'";
        $data = $this->crud->exec_query($query, array(':class' => $this->values['class']))->fetchAll(PDO::FETCH_CLASS);
        
        if(count($data) > 0)
        {
            $this->flag = SUCCESS;
            $this->message = 'Details loaded sucessfully';
            return $data;
        }
        else
        {
            $this->flag = ERROR;
            $this->message = "Error loading students";
            return false;
        }
        
    }

    function fetch_attendance() {

        $this->values = $_POST;
        if(!$this->check_form($this->values, ['class'=>'Class', 'viewdate' => 'Date'])) {
            $this->flag = ERROR;
            return false;
        }

        $query = "select * from attendance inner join attendance_history on attendance_history.attendance_id = attendance.attendance_id where attendance.class = :class and attendance.date = :date";
        $data = $this->crud->exec_query($query, array(':class' => $this->values['class'], ':date' => $this->values['viewdate']))->fetchAll(PDO::FETCH_CLASS);
        
        if(count($data) > 0)
        {
            $this->flag = SUCCESS;
            $this->message = 'Details loaded sucessfully';
            return $data;
        }
        else
        {
            $this->flag = ERROR;
            $this->message = "Error loading students";
            return false;
        }
        
    }

    function fetch_attendance_by_period() {

        $this->values = $_POST;
        if(!$this->check_form($this->values, ['class'=>'Class', 'fromdate' => 'From Date',  'todate' => 'To Date'])) {
            $this->flag = ERROR;
            return false;
        }

        $query = "select * from attendance where attendance.class = :class AND (attendance.date BETWEEN :fromdate AND :todate) ORDER BY attendance.date DESC";
        $data = $this->crud->exec_query($query, array(':class' => $this->values['class'], ':fromdate' => $this->values['fromdate'], ':todate' => $this->values['todate']))->fetchAll(PDO::FETCH_CLASS);
        
        if(count($data) > 0)
        {
            $this->flag = SUCCESS;
            $this->message = 'Details loaded sucessfully';
            return $data;
        }
        else
        {
            $this->flag = ERROR;
            $this->message = "Error loading students";
            return false;
        }
        
    }


    function fetch_attendance_details($id)
    {
        $query = "select * from attendance_history where attendance_history.attendance_id = :id";
        $data = $this->crud->exec_query($query, array(':id' => $id))->fetchAll(PDO::FETCH_CLASS);

        if(count($data) > 0)
        {
            $this->flag = SUCCESS;
            $this->message = 'Details loaded sucessfully';
            return $data;
        }
        else
        {
            $this->flag = ERROR;
            $this->message = "Error loading students";
            return false;
        }
        
    }

    function delete_attendance() {

        $this->values = $_POST;
        if(!$this->check_form($this->values, ['class'=>'Class', 'fromdate' => 'From Date',  'todate' => 'To Date'])) {
            $this->flag = ERROR;
            return false;
        }

        $con = $this->crud->get_connection();

        $con->beginTransaction();

        $query = "select * from attendance where (attendance.date BETWEEN :fromdate AND :todate) AND class = :class";
        $data = $this->crud->exec_query($query, array(':class' => $this->values['class'], ':fromdate' => $this->values['fromdate'], ':todate' => $this->values['todate']))->fetchAll(PDO::FETCH_CLASS);
        
        if(!empty($data))
        {
            try
            {            
                
                $this->crud->changeTable('attendance_history');
                foreach ($data as $key => $value) {
                     $this->crud->delete( array('attendance_id' => $value->attendance_id) );
                }

                $query = "delete from attendance where (attendance.date BETWEEN :fromdate AND :todate) AND class = :class";
                $data = $this->crud->exec_query($query, array(':class' => $this->values['class'], ':fromdate' => $this->values['fromdate'], ':todate' => $this->values['todate']))->rowCount();

                $con->commit();

                $this->flag = SUCCESS;
                $this->message = 'Data Deleted';
                return true;
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->flag = ERROR;
                $this->message = "Error deleting student. Error : ". $e->getMessage();
                return true;
            }
        }
        
    }

    function fetch_student_byid($id)
    {
        $query = "select * from students inner join parents_info on students.stu_id = parents_info.student_id inner join student_details on student_details.student_id = students.stu_id inner join class on students.student_class = class.class_id where students.stu_id = :id";
        $data = $this->crud->exec_query($query, array(':id' => $id))->fetchAll(PDO::FETCH_CLASS);
        
        if(count($data) > 0)
        {
            $this->flag = SUCCESS;
            $this->message = 'Details loaded sucessfully';
            return $data[0];
        }
        else
        {
            $this->flag = ERROR;
            $this->message = "Error loading students";
            return false;
        }
    }

    function get_today_attendance() {

        $query = 'SELECT * FROM attendance WHERE date >= CURDATE()';
        $flag = true;
        
        $data = $this->crud->exec_query($query)->fetchAll(PDO::FETCH_CLASS);
        return $data;
    }

    function get_today_attendance_history($att_id) {

        $query = 'SELECT * FROM attendance_history inner join students on students.stu_id = attendance_history.student_id inner join student_details on attendance_history.student_id = student_details.student_id WHERE attendance_id = :att_id';            
        $data = $this->crud->exec_query($query, array(':att_id' => $att_id))->fetchAll(PDO::FETCH_CLASS);
        return $data;
    }

}