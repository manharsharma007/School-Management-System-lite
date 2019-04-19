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

class students extends Model {
    public $page_title;
    public $message;
    public $flag;
    public $values;
    private $crud;

    function __construct() {
        $this->crud = new crud('students');
    }

    function process_student() {
        $this->values = $_POST;
        if(!$this->check_form($this->values, ['student_name'=>'Student name', 'dob'=>'DOB', 'lang' => 'Language', 'religion' => 'Religion', 'address' => 'Address', 'class' => 'Class', 'reg_no' => 'Registration number', 'roll_no' => 'Roll number', 'srn' => 'SRN', 'fee_mode' => 'Fee mode', 'discount_percent' => 'Discount Percent', 'father_working' => 'Father Working', 'mother_working' => 'Mother Working','father_name' => 'Father\'s name', 'mother_name' => 'Mother\'s name'], '{father_working},{mother_working},{reg_no},{roll_no},{srn}')) {
            $this->flag = ERROR;
            return false;
        }
        
        if(isset($this->values['father_working']))
        {
            if(!$this->check_form($this->values, ['father_occupation' => 'Father\'s occupation', 'father_income' => 'Father\'s income', 'father_phone' => 'Father\'s phone', 'father_email' => 'Father\'s email', 'father_work_address' => 'Father\'s work address'],'{father_email},{father_income},{father_work_address}')) {
                $this->flag = ERROR;
                return false;
            }

            if(!empty($this->values['father_email']) && $this->check_data($this->values['father_email'], 'email') == false)
            {
                $this->message = 'Please enter valid father email';
                $this->flag = ERROR;
                return false;
            }
            if($this->values['father_phone'] != '' && $this->check_data($this->values['father_phone'], 'int') == false)
            {
                $this->message = 'Please enter valid father phone number';
                $this->flag = ERROR;
                return false;
            }
        }
        if(isset($this->values['mother_working']))
        {
            if(!$this->check_form($this->values, ['mother_occupation' => 'Mother\'s occupation', 'mother_income' => 'Mother\'s income', 'mother_phone' => 'Mother\'s phone', 'mother_email' => 'Mother\'s email', 'mother_work_address' => 'Mother\'s work address'],'{mother_income},{mother_email},{mother_phone},{mother_work_address}')) {
                $this->flag = ERROR;
                return false;
            }

            if($this->check_data($this->values['mother_email'], 'email') == false)
            {
                $this->message = 'Please enter valid mother email';
                $this->flag = ERROR;
                return false;
            }
            if($this->values['mother_phone'] != '' && $this->check_data($this->values['mother_phone'], 'int') == false)
            {
                $this->message = 'Please enter valid mother phone number';
                $this->flag = ERROR;
                return false;
            }
        }

        $this->add_student();
    }

    private function add_student() {
        $con = $this->crud->get_connection();

        $con->beginTransaction();

        try
        {

            $dt = new DateTime();
            $date = $dt->format('Y-m-d H:i:s');
            $data = $this->crud->insert( array('student_name'=>$this->values['student_name'], 'dob'=>$this->values['dob'], 'student_class'=>$this->values['class'], 'language' => $this->values['lang'], 'religion' => $this->values['religion'], 'residential_address'=>$this->values['address'], 'student_status' => $this->values['student_status'], 'date' => $date) );

            $parent_detail_id = false;

            if(isset($this->values['father_working']))
            {
                $this->crud->changeTable('parents_info');
                if($parent_detail_id === false)
                {
                    $parent_detail_id = $this->crud->insert( array('student_id'=>$data, 'father_working'=>1, 'father_name'=>$this->values['father_name'], 'father_income' => $this->values['father_income'], 'father_occupation' => $this->values['father_occupation'], 'father_phone' => $this->values['father_phone'], 'father_email' => $this->values['father_email'], 'father_work_address' => $this->values['father_work_address'], 'date' => $date) );
                
                }
                else
                {
                    $this->crud->update( array('father_working'=>$this->values['father_working'], 'father_name'=>$this->values['father_name'], 'father_income' => $this->values['father_income'], 'father_occupation' => $this->values['father_occupation'], 'father_phone' => $this->values['father_phone'], 'father_email' => $this->values['father_email'], 'father_work_address' => $this->values['father_work_address'], 'date' => $date), array('student_id'=>$data) );
                }
            }
            else
            {
                $this->crud->changeTable('parents_info');
                if($parent_detail_id === false)
                {
                    $parent_detail_id = $this->crud->insert( array('student_id'=>$data, 'father_working'=>0, 'father_name'=>$this->values['father_name'], 'father_income' => '', 'father_occupation' => '', 'father_phone' =>  '', 'father_email' => '', 'father_work_address' => '', 'date' => $date) );
                }
                else
                {
                    $this->crud->insert( array('father_working'=>0, 'father_name'=>$this->values['father_name'], 'father_income' => '', 'father_occupation' => '', 'father_phone' =>  '', 'father_email' => '', 'father_work_address' => '', 'date' => $date), array('student_id'=>$data) );
                }
            }


            if(isset($this->values['mother_working']))
            {
                $this->crud->changeTable('parents_info');
                if($parent_detail_id === false)
                {
                    $parent_detail_id = $this->crud->insert( array('student_id'=>$data, 'mother_working'=>1, 'mother_name'=>$this->values['mother_name'], 'mother_income' => $this->values['mother_income'], 'mother_occupation' => $this->values['mother_occupation'], 'mother_phone' => $this->values['mother_phone'], 'mother_email' => $this->values['mother_email'], 'mother_work_address' => $this->values['mother_work_address'], 'date' => $date) );
                }
                else
                {
                    $this->crud->update( array('mother_working'=>$this->values['mother_working'], 'mother_name'=>$this->values['mother_name'], 'mother_income' => $this->values['mother_income'], 'mother_occupation' => $this->values['mother_occupation'], 'mother_phone' => $this->values['mother_phone'], 'mother_email' => $this->values['mother_email'], 'mother_work_address' => $this->values['mother_work_address'], 'date' => $date), array('student_id'=>$data) );
                }
            }
            else
            {
                $this->crud->changeTable('parents_info');
                if($parent_detail_id === false)
                {
                    $parent_detail_id = $this->crud->insert( array('student_id'=>$data, 'mother_working'=>0, 'mother_name'=>$this->values['mother_name'], 'mother_income' => '', 'mother_occupation' => '', 'mother_phone' =>  '', 'mother_email' => '', 'mother_work_address' => '', 'date' => $date) );
                }
                else
                {
                    $this->crud->update( array('mother_working'=>0, 'mother_name'=>$this->values['mother_name'], 'mother_income' => '', 'mother_occupation' => '', 'mother_phone' =>  '', 'mother_email' => '', 'mother_work_address' => '', 'date' => $date), array('student_id'=>$data) );
                }
            }
            
            $this->crud->changeTable('student_details');
            $this->crud->insert( array('student_id'=>$data, 'reg_no'=>$this->values['reg_no'], 'roll_no'=>$this->values['roll_no'], 'srn' => $this->values['srn'], 'date' => $date) );


            $this->crud->changeTable('student_fees');
            $this->crud->insert(array('student_id' => $data, 'fee_status' => 'PENDING', 'fee_mode' => $this->values['fee_mode'], 'discount_percent' => $this->values['discount_percent'], 'from_period' => FROM_PERIOD, 'to_period' => TO_PERIOD, 'previous_balance' => 0, 'total_paid_till_date' => 0, 'date' => $date));


            $con->commit();

            $this->flag = SUCCESS;
            $this->message = ' Student Added';
            return true;
        }
        catch(Exception $e)
        {
            $con->rollBack();
            $this->flag = ERROR;
            $this->message = "Error adding student. Error : ". $e->getMessage();
            return true;
        }
        
    }

    function promote_students()
    {
        $this->values = $_POST;
        if(!$this->check_form($this->values, ['fromclass' => 'From Class', 'toclass' => 'To Class'])) {
            $this->flag = ERROR;
            return false;
        }

        foreach ($_POST['item'] as $key => $value) {

            $con = $this->crud->get_connection();

            $con->beginTransaction();

            try
            {
                $data = $this->crud->update( array('student_class' => $_POST['toclass']), array('stu_id' => $value, 'student_class'=> $_POST['fromclass'], 'student_status' => 'STUDYING') );

                $con->commit();

                $this->flag = SUCCESS;
                $this->message = 'Student/Students Promoted';
            }
            catch(Exception $e)
            {
                $con->rollBack();
                $this->flag = ERROR;
                $this->message = "Error promoting Students. Error : ". $e->getMessage();
            }
        }
    }


    function delete_student($id)
    {
        $con = $this->crud->get_connection();

        $con->beginTransaction();

        try
        {
            $data = $this->crud->delete( array('stu_id' => $id) );
            
            $this->crud->changeTable('parents_info');
            $data = $this->crud->delete( array('student_id'=>$id) );
            
            $this->crud->changeTable('student_details');
            $data = $this->crud->delete( array('student_id'=>$id) );

            $this->crud->changeTable('fee_details');
            $data = $this->crud->delete( array('student_id'=>$id) );

            $this->crud->changeTable('student_fees');
            $data = $this->crud->delete( array('student_id'=>$id) );

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

    function fetch_by_class() {

        $this->values = $_POST;
        if(!$this->check_form($this->values, ['fromclass' => 'From Class'])) {
            $this->flag = ERROR;
            return false;
        }

        $query = "select * from students inner join parents_info on students.stu_id = parents_info.student_id inner join student_details on student_details.student_id = students.stu_id inner join class on students.student_class = class.class_id where students.student_class = :class and students.student_status = 'STUDYING'";
         
        $data = $this->crud->exec_query($query, array(':class' => $this->values['fromclass']))->fetchAll(PDO::FETCH_CLASS);

        if(count($data) <= 0)
        {
            $this->flag = ERROR;
            $this->message = "No Students found";
            return false;
        }

        return $data;
    }


    function get_students($filter = array(), $limit = false) {
        $query = "select * from students inner join parents_info on students.stu_id = parents_info.student_id inner join student_details on student_details.student_id = students.stu_id inner join class on students.student_class = class.class_id where students.student_status = 'STUDYING'";
        $flag = true;

        if(isset($filter['name']))
        {
            if(!$this->check_form($filter, ['name'=>'Name'])) {
                $this->flag = ERROR;
                return false;
            }
            $query = ($flag == true) ? $query . " AND students.student_name like '%".$filter['name']."%'" : $query . " where students.student_name like '%".$filter['name']."%'" ;
            if($flag == false) $flag = true;
        }
        if(isset($filter['reg_no']))
        {
            if(!$this->check_form($filter, ['reg_no'=>'Registration no'])) {
                $this->flag = ERROR;
                return false;
            }
            $query = ($flag == true) ? $query . " AND student_details.reg_no = '".$filter['reg_no']."'" : $query . " where student_details.reg_no = '".$filter['reg_no']."'";
            if($flag == false) $flag = true;
        }
        if(isset($filter['class']))
        {
            if(!$this->check_form($filter, ['class'=>'Class'])) {
                $this->flag = ERROR;
                return false;
            }
            $query = ($flag == true) ? $query . " AND students.student_class = '".$filter['class']."'" : $query . " where students.student_class = '".$filter['class']."'";
            if($flag == false) $flag = true;
        }
        if(isset($filter['roll_no']))
        {
            if(!$this->check_form($filter, ['roll_no'=>'Roll no'])) {
                $this->flag = ERROR;
                return false;
            }
            $query = ($flag == true) ? $query . " AND student_details.roll_no = '".$filter['roll_no']."'" : $query . " where student_details.roll_no = '".$filter['roll_no']."'";
            if($flag == false) $flag = true;
        }
        
        if($limit != false)
        {
            $query = $query.' '.$limit;
        }
        
        $data = $this->crud->exec_query($query)->fetchAll(PDO::FETCH_CLASS);
        return $data;
    }

    function get_cert_students($filter = array(), $limit = false) {
        $query = "select * from students inner join parents_info on students.stu_id = parents_info.student_id inner join student_details on student_details.student_id = students.stu_id inner join class on students.student_class = class.class_id";
        $flag = true;

        if(isset($filter['name']))
        {
            if(!$this->check_form($filter, ['name'=>'Name'])) {
                $this->flag = ERROR;
                return false;
            }
            $query = ($flag == true) ? $query . " AND students.student_name like '%".$filter['name']."%'" : $query . " where students.student_name like '%".$filter['name']."%'" ;
            if($flag == false) $flag = true;
        }
        if(isset($filter['reg_no']))
        {
            if(!$this->check_form($filter, ['reg_no'=>'Registration no'])) {
                $this->flag = ERROR;
                return false;
            }
            $query = ($flag == true) ? $query . " AND student_details.reg_no = '".$filter['reg_no']."'" : $query . " where student_details.reg_no = '".$filter['reg_no']."'";
            if($flag == false) $flag = true;
        }
        if(isset($filter['class']))
        {
            if(!$this->check_form($filter, ['class'=>'Class'])) {
                $this->flag = ERROR;
                return false;
            }
            $query = ($flag == true) ? $query . " AND students.student_class = '".$filter['class']."'" : $query . " where students.student_class = '".$filter['class']."'";
            if($flag == false) $flag = true;
        }
        if(isset($filter['roll_no']))
        {
            if(!$this->check_form($filter, ['roll_no'=>'Roll no'])) {
                $this->flag = ERROR;
                return false;
            }
            $query = ($flag == true) ? $query . " AND student_details.roll_no = '".$filter['roll_no']."'" : $query . " where student_details.roll_no = '".$filter['roll_no']."'";
            if($flag == false) $flag = true;
        }
        
        if($limit != false)
        {
            $query = $query.' '.$limit;
        }
        
        $data = $this->crud->exec_query($query)->fetchAll(PDO::FETCH_CLASS);
        return $data;
    }



    function get_left_students($filter = array(), $limit = false) {
        $query = "select * from students inner join parents_info on students.stu_id = parents_info.student_id inner join student_details on student_details.student_id = students.stu_id inner join class on students.student_class = class.class_id where students.student_status = 'LEFT'";
        $flag = true;

        if(isset($filter['name']))
        {
            if(!$this->check_form($filter, ['name'=>'Name'])) {
                $this->flag = ERROR;
                return false;
            }
            $query = ($flag == true) ? $query . " AND students.student_name like '%".$filter['name']."%'" : $query . " where students.student_name like '%".$filter['name']."%'" ;
            if($flag == false) $flag = true;
        }
        if(isset($filter['reg_no']))
        {
            if(!$this->check_form($filter, ['reg_no'=>'Registration no'])) {
                $this->flag = ERROR;
                return false;
            }
            $query = ($flag == true) ? $query . " AND student_details.reg_no = '".$filter['reg_no']."'" : $query . " where student_details.reg_no = '".$filter['reg_no']."'";
            if($flag == false) $flag = true;
        }
        if(isset($filter['class']))
        {
            if(!$this->check_form($filter, ['class'=>'Class'])) {
                $this->flag = ERROR;
                return false;
            }
            $query = ($flag == true) ? $query . " AND students.student_class = '".$filter['class']."'" : $query . " where students.student_class = '".$filter['class']."'";
            if($flag == false) $flag = true;
        }
        if(isset($filter['roll_no']))
        {
            if(!$this->check_form($filter, ['roll_no'=>'Roll no'])) {
                $this->flag = ERROR;
                return false;
            }
            $query = ($flag == true) ? $query . " AND student_details.roll_no = '".$filter['roll_no']."'" : $query . " where student_details.roll_no = '".$filter['roll_no']."'";
            if($flag == false) $flag = true;
        }
        
        if($limit != false)
        {
            $query = $query.' '.$limit;
        }
        
        $data = $this->crud->exec_query($query)->fetchAll(PDO::FETCH_CLASS);
        return $data;
    }



    function get_studying_students() {

        $filter = $_POST;

        $query = "select * from students inner join parents_info on students.stu_id = parents_info.student_id inner join student_details on student_details.student_id = students.stu_id inner join class on students.student_class = class.class_id where students.student_status = 'STUDYING'";
        $flag = true;

        if(isset($filter['reg_no']))
        {
            if(!$this->check_form($filter, ['reg_no'=>'Registration no'])) {
                $this->flag = ERROR;
                return false;
            }
            $query = ($flag == true) ? $query . " AND student_details.reg_no = '".$filter['reg_no']."'" : $query . " where student_details.reg_no = '".$filter['reg_no']."'";
            if($flag == false) $flag = true;
        }
        if(isset($filter['class']))
        {
            if(!$this->check_form($filter, ['class'=>'Class'])) {
                $this->flag = ERROR;
                return false;
            }
            $query = ($flag == true) ? $query . " AND students.student_class = '".$filter['class']."'" : $query . " where students.student_class = '".$filter['class']."'";
            if($flag == false) $flag = true;
        }
        if(isset($filter['roll_no']))
        {
            if(!$this->check_form($filter, ['roll_no'=>'Roll no'])) {
                $this->flag = ERROR;
                return false;
            }
            $query = ($flag == true) ? $query . " AND student_details.roll_no = '".$filter['roll_no']."'" : $query . " where student_details.roll_no = '".$filter['roll_no']."'";
            if($flag == false) $flag = true;
        }
        
        $data = $this->crud->exec_query($query)->fetchAll(PDO::FETCH_CLASS);

        if(count($data) <= 0)
        {
            $this->flag = WARNING;
            $this->message = "No student record found";
            return false;
        }

        return $data;
    }


    function update_student()
    {
        $this->values = $_POST;
        if(!$this->check_form($this->values, ['student_name'=>'Student name', 'dob'=>'DOB', 'lang' => 'Language', 'religion' => 'Religion', 'address' => 'Address', 'class' => 'Class', 'reg_no' => 'Registration number', 'roll_no' => 'Roll number', 'srn' => 'SRN', 'fee_mode' => 'Fee mode', 'discount_percent' => 'Discount Percent', 'father_working' => 'Father Working', 'mother_working' => 'Mother Working','father_name' => 'Father\'s name', 'mother_name' => 'Mother\'s name'], '{father_working},{mother_working}')) {
            $this->flag = ERROR;
            return false;
        }
        
        if(isset($this->values['father_working']))
        {
            if(!$this->check_form($this->values, ['father_occupation' => 'Father\'s occupation', 'father_income' => 'Father\'s income', 'father_phone' => 'Father\'s phone', 'father_email' => 'Father\'s email', 'father_work_address' => 'Father\'s work address'], '{father_email},{father_income},{father_work_address}')) {
                $this->flag = ERROR;
                return false;
            }

            if($this->check_data($this->values['father_email'], 'email') == false)
            {
                $this->message = 'Please enter valid father email';
                $this->flag = ERROR;
                return false;
            }
            if($this->values['father_phone'] != '' && $this->check_data($this->values['father_phone'], 'int') == false)
            {
                $this->message = 'Please enter valid father phone number';
                $this->flag = ERROR;
                return false;
            }
        }
        if(isset($this->values['mother_working']))
        {
            if(!$this->check_form($this->values, ['mother_occupation' => 'Mother\'s occupation', 'mother_income' => 'Mother\'s income', 'mother_phone' => 'Mother\'s phone', 'mother_email' => 'Mother\'s email', 'mother_work_address' => 'Mother\'s work address'], '{mother_email},{mother_phone},{mother_income},{mother_work_address}')) {
                $this->flag = ERROR;
                return false;
            }

            if($this->check_data($this->values['mother_email'], 'email') == false)
            {
                $this->message = 'Please enter valid mother email';
                $this->flag = ERROR;
                return false;
            }
            if($this->values['mother_phone'] != '' && $this->check_data($this->values['mother_phone'], 'int') == false)
            {
                $this->message = 'Please enter valid mother phone number';
                $this->flag = ERROR;
                return false;
            }
        }            

        
        $con = $this->crud->get_connection();

        $con->beginTransaction();

        try
        {

            $data = $this->crud->update( array('student_name'=>$this->values['student_name'], 'dob'=>$this->values['dob'], 'student_class'=>$this->values['class'], 'language' => $this->values['lang'], 'religion' => $this->values['religion'], 'residential_address'=>$this->values['address'], 'student_status' => $this->values['student_status']), array('stu_id' => $this->values['id']) );

            if(isset($this->values['father_working']))
            {
                $this->crud->changeTable('parents_info');
                $this->crud->update( array('student_id' => $this->values['id'], 'father_working'=>1, 'father_name'=>$this->values['father_name'], 'father_income' => $this->values['father_income'], 'father_occupation' => $this->values['father_occupation'], 'father_phone' => $this->values['father_phone'], 'father_email' => $this->values['father_email'], 'father_work_address' => $this->values['father_work_address']), array('student_id' => $this->values['id']) );
            }
            else
            {
                $this->crud->changeTable('parents_info');
                $this->crud->update( array('student_id' => $this->values['id'], 'father_working'=>0, 'father_name'=>$this->values['father_name'], 'father_income' => '', 'father_occupation' => '', 'father_phone' =>  '', 'father_email' => '', 'father_work_address' => ''), array('student_id' => $this->values['id']) );
            }


            if(isset($this->values['mother_working']))
            {
                $this->crud->changeTable('parents_info');
                $this->crud->update( array('student_id' => $this->values['id'], 'mother_working'=>1, 'mother_name'=>$this->values['mother_name'], 'mother_income' => $this->values['mother_income'], 'mother_occupation' => $this->values['mother_occupation'], 'mother_phone' => $this->values['mother_phone'], 'mother_email' => $this->values['mother_email'], 'mother_work_address' => $this->values['mother_work_address']), array('student_id' => $this->values['id']) );
            }
            else
            {
                $this->crud->changeTable('parents_info');
                $this->crud->update( array('student_id' => $this->values['id'], 'mother_working'=>0, 'mother_name'=>$this->values['mother_name'], 'mother_income' => '', 'mother_occupation' => '', 'mother_phone' =>  '', 'mother_email' => '', 'mother_work_address' => ''), array('student_id' => $this->values['id']) );
            }


            $this->crud->changeTable('student_details');
            $this->crud->update( array('reg_no'=>$this->values['reg_no'], 'roll_no'=>$this->values['roll_no'], 'srn' => $this->values['srn']), array('student_id' => $this->values['id']) );
           



            $this->crud->changeTable('student_fees');
            $this->crud->update( array('fee_mode' => $this->values['fee_mode'], 'discount_percent' => $this->values['discount_percent']), array('student_id' => $this->values['id']));


            
            $con->commit();

            $this->flag = SUCCESS;
            $this->message = ' Student updated';
            return true;
        }
        catch(Exception $e)
        {
            $con->rollBack();
            $this->flag = ERROR;
            $this->message = "Error updating student. Error : ". $e->getMessage();
            return true;
        }
        
    }

    function issue_cert($id)
    {
        $con = $this->crud->get_connection();

        $con->beginTransaction();

        try
        {
            $this->crud->changeTable('students');
            $prev_check = $this->crud->get_by( array('stu_id'=>$id), '=', 'true' );

            if(count($prev_check) > 0)
            {
                $dt = new DateTime();
                $date = $dt->format('Y-m-d H:i:s');
                $data = $this->crud->update(array('student_status' => 'LEFT', 'issue_date' => $date), array('stu_id' => $id));
            }
            
            $con->commit();

            $this->flag = SUCCESS;
            $this->message = "Certificate Generated. <a href='#'  onclick=\"window.open('".SITE_URL."certificate/printcert?id=".$id."','Print Certificate','width=1000,height=800').print()\">Click here</a> to print the Certificate.";
            return true;
        }
        catch(Exception $e)
        {
            $con->rollBack();
            $this->flag = ERROR;
            $this->message = "Error updating student. Error : ". $e->getMessage();
            return true;
        }
    }

    function check_student($student_id)
    {
        $query = 'select * from students inner join student_details on students.stu_id = student_details.student_id inner join class on class.class_id = students.student_class inner join parents_info on students.stu_id = parents_info.student_id inner join student_fees on student_fees.student_id = students.stu_id where students.stu_id = :student_id';
        $book = $this->crud->exec_query($query, array(':student_id' => $student_id))->fetchAll(PDO::FETCH_CLASS);
        
        if(count($book) <= 0)
        {
            $this->flag = ERROR;
            $this->message = "Invalid access";
            return false;
        }
        return $book[0];
    }



    function check_cert($student_id)
    {
        $query = 'select * from students inner join student_details on students.stu_id = student_details.student_id inner join class on class.class_id = students.student_class inner join parents_info on students.stu_id = parents_info.student_id where students.stu_id = :student_id and students.student_status = \'LEFT\'';
        $book = $this->crud->exec_query($query, array(':student_id' => $student_id))->fetchAll(PDO::FETCH_CLASS);
        
        if(count($book) <= 0)
        {
            $this->flag = ERROR;
            $this->message = "Invalid access";
            return false;
        }
        return $book[0];
    }

    

    function process_import()
    {
        if(isset($_FILES['csv_file']))
        {
            $imageFileType = pathinfo(basename($_FILES["csv_file"]["name"]),PATHINFO_EXTENSION);

            if($imageFileType != "CSV" && $imageFileType != "csv") {
                $this->flag = ERROR;
                $this->message = "Valid CSV is required";
                return false;
            }
                $flag = true;
                $filename =  $_FILES['csv_file']['tmp_name'];
                $file = fopen($filename, "r");
                $count = 0;
                while (($getData = fgetcsv($file)) !== FALSE)
                 {
                    if($count <= 0)
                    {
                        $count++;
                        continue;
                    }
                    if(count($getData) < 11)
                    {

                        $this->flag = ERROR;
                        $flag = false;
                        if(isset($this->message))
                             $this->message .= "Invalid CSV data at line : ".($count+1).'<br>';
                        else
                            $this->message = "Invalid CSV data at line : ".($count+1).'<br>';

                        $count++;
                        continue;
                    }
                    $student_name = $getData[0];
                    $student_class = $getData[1];
                    $dob = $getData[2];
                    $language = $getData[3];
                    $religion = $getData[4];
                    $residential_address = $getData[5];
                    $reg_no = $getData[6];
                    $srn = $getData[7];
                    $roll_no = $getData[8];
                    $father_working = $getData[9];
                    $mother_working = $getData[10];
                    $father_name = $getData[11];
                    $mother_name = $getData[12];
                    $father_occupation = $getData[13];
                    $father_income = $getData[14];
                    $father_work_address = $getData[15];
                    $father_email = $getData[16];
                    $father_phone = $getData[17];
                    $mother_occupation = $getData[18];
                    $mother_income = $getData[19];
                    $mother_work_address = $getData[20];
                    $mother_email = $getData[21];
                    $mother_phone = $getData[22];
                    $fee_mode = $getData[23];
                    $discount_percent = $getData[24];

                    $this->crud->changeTable('class');

                    $class = $this->crud->get_by(array('class_name' => $student_class), '=', true);

                    if(count($class) <= 0)
                    {
                        $this->flag = ERROR;
                        $flag = false;
                        if(isset($this->message))
                             $this->message .= "Invalid class data at line : ".($count+1).'<br>';
                        else
                            $this->message = "Invalid class data at line : ".($count+1).'<br>';


                        $count++;
                        continue;
                    }

                    $this->crud->changeTable('students');
                   
                    $con = $this->crud->get_connection();

                    $con->beginTransaction();

                    try
                    {

                        $dt = new DateTime();
                        $date = $dt->format('Y-m-d H:i:s');
                        $data = $this->crud->insert( array('student_name'=>$student_name, 'dob'=>$dob, 'student_class'=>$class->class_id, 'language' => $language, 'religion' => $religion, 'residential_address'=>$residential_address, 'student_status' => 'STUDYING', 'date' => $date) );

                        $parent_detail_id = false;

                        
                        $this->crud->changeTable('parents_info');
                        $parent_detail_id = $this->crud->insert( array('student_id'=>$data, 'father_working'=>$father_working, 'father_name'=>$father_name, 'father_income' => $father_income, 'father_occupation' => $father_occupation, 'father_phone' => $father_phone, 'father_email' => $father_email, 'father_work_address' => $father_work_address,
                            'mother_working'=>$mother_working, 'mother_name'=>$mother_name, 'mother_income' => $mother_income, 'mother_occupation' => $mother_occupation, 'mother_phone' =>  $mother_phone, 'mother_email' => $mother_email, 'mother_work_address' => $mother_work_address, 'date' => $date) );
                         
                        $this->crud->changeTable('student_details');
                        $this->crud->insert( array('student_id'=>$data, 'reg_no'=>$reg_no, 'roll_no'=>$roll_no, 'srn' => $srn, 'date' => $date) );



                        $this->crud->changeTable('student_fees');
                        $this->crud->insert(array('student_id' => $data, 'fee_status' => 'PENDING', 'fee_mode' => $fee_mode, 'discount_percent' => $discount_percent, 'from_period' => FROM_PERIOD, 'to_period' => TO_PERIOD, 'previous_balance' => 0));



                        $con->commit();

                        if($data > 0)
                        {
                            $this->flag = SUCCESS;
                        }
                        else
                        {
                            $this->flag = ERROR;
                            $flag = false;
                            if(isset($this->message))
                                 $this->message .= "Error Inserting student. Line : ". ($count+1).'<br>';
                            else
                                $this->message = "Error Inserting student. Line : ". ($count+1).'<br>';
                        }

                        $count++;
                    }
                    catch(Exception $e)
                    {
                        $con->rollBack();
                        $this->flag = ERROR;
                        $this->message = "Error adding student. Error : ". $e->getMessage();
                        return true;
                    }

                }
                
                fclose($file); 
                if($flag == true)
                { 
                    $this->message = "Students imported successfully";
                    return true;
                }
                else return false;
        }

        return true;

    }

    function process_export()
    {
            header('Content-Type: text/csv; charset=utf-8');  
            header('Content-Disposition: attachment; filename=data.csv');  
            $output = fopen("php://output", "w+");  
            fputcsv($output, array('student_name', 'student_class', 'dob', 'language', 'religion', 'residential_address', 'reg_no', 'srn', 'roll_no', 'father_working', 'mother_working', 'father_name', 'mother_name','father_occupation','father_income','father_work_address','father_email','father_phone','mother_occupation','mother_income','mother_work_address','mother_email','mother_phone', 'fee_mode', 'discount_percent'));  
            $query = "SELECT student_name,class.class_name,dob,language,religion,residential_address,reg_no,srn,roll_no,father_working,mother_working,father_name,mother_name,father_occupation,father_income,father_work_address,father_email,father_phone,mother_occupation,mother_income,mother_work_address,mother_email,mother_phone,fee_mode,discount_percent from students inner join student_details on student_details.student_id = students.stu_id inner join parents_info on parents_info.student_id = students.stu_id inner join class on class.class_id = students.student_class inner join student_fees on student_fees.student_id = students.stu_id where students.student_status = 'STUDYING'";

            $flag = true;

            if(isset($filter['name']))
            {
                if(!$this->check_form($filter, ['name'=>'Name'])) {
                    $this->flag = ERROR;
                    return false;
                }
                $query = ($flag == true) ? $query . " AND students.student_name like '%".$filter['name']."%'" : $query . " where students.student_name like '%".$filter['name']."%'" ;
                if($flag == false) $flag = true;
            }
            if(isset($filter['reg_no']))
            {
                if(!$this->check_form($filter, ['reg_no'=>'Registration no'])) {
                    $this->flag = ERROR;
                    return false;
                }
                $query = ($flag == true) ? $query . " AND student_details.reg_no = '".$filter['reg_no']."'" : $query . " where student_details.reg_no = '".$filter['reg_no']."'";
                if($flag == false) $flag = true;
            }
            if(isset($filter['class']))
            {
                if(!$this->check_form($filter, ['class'=>'Class'])) {
                    $this->flag = ERROR;
                    return false;
                }
                $query = ($flag == true) ? $query . " AND students.student_class = '".$filter['class']."'" : $query . " where students.student_class = '".$filter['class']."'";
                if($flag == false) $flag = true;
            }
            if(isset($filter['roll_no']))
            {
                if(!$this->check_form($filter, ['roll_no'=>'Roll no'])) {
                    $this->flag = ERROR;
                    return false;
                }
                $query = ($flag == true) ? $query . " AND student_details.roll_no = '".$filter['roll_no']."'" : $query . " where student_details.roll_no = '".$filter['roll_no']."'";
                if($flag == false) $flag = true;
            }
        

            $smt = $this->crud->get_connection()->prepare($query);
            $smt->execute();

            while($row = $smt->fetch(PDO::FETCH_ASSOC))  
            {  
               fputcsv($output, $row);  
            }  
            fclose($output);  
    }

}