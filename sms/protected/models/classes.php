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

class classes extends Model {
    public $page_title;
    public $message;
    public $flag;
    public $values;
    private $crud;

    function __construct() {
        $this->crud = new crud('class');
    }

    function process_class() {
        $this->values = $_POST;
        if(!$this->check_form($this->values, ['class_name'=>'Class', 'fees' => 'Fees'])) {
            $this->flag = ERROR;
            return false;
        }

        if(!$this->check_data($this->values['fees'], 'int')) {
            $this->flag = ERROR;
            $this->message = 'Valid Fees is required';
            return false;
        }
        if(empty($this->values['exclusion_months']))
            $this->values['exclusion_months'] = array();
        $this->values['exclusion_months'] = serialize($this->values['exclusion_months']);
        
        $this->add_class();
    }

    function get_classes() { 
        $data = $this->crud->get_all();
        return $data;
    }

    function get_class_by_id($id) { 
        $data =  $data = $this->crud->get_by( array('class_id' => $id), '=', true );
        return $data;
    }

    private function add_class() {
        $dt = new DateTime();
        $date = $dt->format('Y-m-d H:i:s');
        $data = $this->crud->insert( array('class_name' => $this->values['class_name'], 'fees' => $this->values['fees'], 'exclusion_months' => $this->values['exclusion_months'], 'date' => $date) );
        
        if($data > 0)
        {
            $this->flag = SUCCESS;
            $this->message = ' Class Added';
            return true;
        }
        else
        {
            $this->flag = ERROR;
            $this->message = "Error adding class";
            return true;
        }
        
    }

    function delete_class($id)
    {
        $con = $this->crud->get_connection();

        $con->beginTransaction();

        try
        {
            $this->crud->changeTable('students');

            $data = $this->crud->get_by( array('student_class' => $id) );
            
            if(count($data) > 0)
            {
                foreach ($dats as $key => $value) {
                    
                    $this->crud->changeTable('student_details');
                    $this->crud->delete( array('student_id' => $value->stu_id) );

                    $this->crud->changeTable('parents_info');
                    $this->crud->delete( array('student_id' => $value->stu_id) );

                    $this->crud->changeTable('fee_details');
                    $this->crud->delete( array('student_id' => $value->stu_id) );

                    $this->crud->changeTable('students');
                    $this->crud->delete( array('stu_id' => $value->stu_id) );
                }
            }


            $this->crud->changeTable('attendance');

            $att = $this->crud->get_by( array('class' => $id), '=', true );
            
            if(count($att) > 0)
            {
                foreach ($att as $key => $value) {
                    
                    $this->crud->changeTable('attendance_history');
                    $this->crud->delete( array('attendance_id' => $value->attendance_id) );

                    $this->crud->changeTable('attendance');
                    $this->crud->delete( array('attendance_id' => $value->attendance_id) );
                }
            }

            $this->crud->changeTable('class');

            $data = $this->crud->delete( array('class_id' => $id) );

            $con->commit();

            $this->flag = SUCCESS;
            $this->message = 'Data Deleted';
            return true;
        }
        catch(Exception $e)
        {
            $con->rollBack();
            $this->flag = ERROR;
            $this->message = "Error deleting details. Error : ". $e->getMessage();
            return true;
        }
    }



    function update_class($single = false)
    {
        $this->values = $_POST;

        if(!$this->check_form($this->values, ['id' => 'Class ID', 'class_name' => 'Class Name', 'fees' => 'Fees', 'exclusion_months' => 'exclusion_months'])) {
            $this->flag = ERROR;
            return false;
        }

        if(!$this->check_data($this->values['fees'], 'int')) {
            $this->flag = ERROR;
            $this->message = 'Valid Fees is required';
            return false;
        }

        $this->values['exclusion_months'] = serialize($this->values['exclusion_months']);

        $con = $this->crud->get_connection();

        $con->beginTransaction();

        try
        {
            $args = array('class_name' => $this->values['class_name'], 'fees' => $this->values['fees'], 'exclusion_months' => $this->values['exclusion_months']);
        
            $data = $this->crud->update( $args, array('class_id' => $this->values['id']) );
            
            $con->commit();

            $this->flag = SUCCESS;
            $this->message = 'Class Details updated';
            return true;
        }
        catch(Exception $e)
        {
            $con->rollBack();
            $this->flag = ERROR;
            $this->message = "Error updating class details. Error : ". $e->getMessage();
            return true;
        }
        
    }


}