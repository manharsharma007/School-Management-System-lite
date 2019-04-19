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

class settings extends Model {
    public $page_title;
    public $message;
    public $flag;
    public $values;
    private $crud;

    function __construct() {
        $this->crud = new crud('settings');
    }

    function process_setting() {
        
        $this->values = $_POST;
        if(!$this->check_form($this->values, ['school_name'=>'Name', 'school_code'=>'School Code', 'address' => 'Address', 'email' => 'Email', 'phone' => 'Phone', 'from_period' => 'From Period', 'to_period' => 'To Period'])) {
            $this->flag = ERROR;
            return false;
        }

        if(!$this->check_data($this->values['email'], 'email')) {
            $this->flag = ERROR;
            $this->message = 'Valid Email is required';
            return false;
        }

        if(!$this->check_data($this->values['phone'], 'int')) {
            $this->flag = ERROR;
            $this->message = 'Valid phone is required';
            return false;
        }

        if(!$this->check_data($this->values['from_period'], 'date')) {
            $this->flag = ERROR;
            $this->message = 'Valid From date is required';
            return false;
        }

        if(!$this->check_data($this->values['to_period'], 'date')) {
            $this->flag = ERROR;
            $this->message = 'Valid To date is required';
            return false;
        }

        if($this->processaddfile() == false) {
            return false;
        }
        
        $this->change_setting();
    }

    function get_settings() { 
        $data = $this->crud->get_all();
        return $data;
    }

    private function change_setting() {
        $data_prev = $this->get_settings();
        if(count($data_prev) > 0)
        {
            $args = array();
            if(isset($this->values['school_name']))
                $args['institute_name'] = $this->values['school_name'];

            if(isset($this->values['school_code']))
                $args['school_code'] = $this->values['school_code'];

            if(isset($this->values['download_file']))
                $args['logo'] = $this->values['download_file'];

            if(isset($this->values['address']))
                $args['address'] = $this->values['address'];

            if(isset($this->values['phone']))
                $args['phone'] = $this->values['phone'];

            if(isset($this->values['from_period'])&& isset($this->values['to_period']))
            {
                $args['from_period'] = $this->values['from_period'];
                $args['to_period'] = $this->values['to_period'];

                $query = 'update student_fees set from_period = :from_date, to_period = :to_date';
                $result = $this->crud->exec_query($query, array(':from_date' => $this->values['from_period'], ':to_date' => $this->values['to_period']))->rowCount();

                if($result > 0)
                {
                    $query = 'delete from fee_details where date not between :from_date AND :to_date';
                    $result = $this->crud->exec_query($query, array(':from_date' => $this->values['from_period'], ':to_date' => $this->values['to_period']))->rowCount();


                    $query = 'select * from attendance where date between :from_date AND :to_date';
                    $result = $this->crud->exec_query($query, array(':from_date' => $this->values['from_period'], ':to_date' => $this->values['to_period']))->fetchAll(PDO::FETCH_CLASS);

                    foreach ($result as $student) {
                        $query = 'delete from attendance_history where attendance_id = :id';
                        $result = $this->crud->exec_query($query, array(':id' => $student->attendance_id))->rowCount();

                    }

                    $query = 'delete from attendance where date not between :from_date AND :to_date';
                    $result = $this->crud->exec_query($query, array(':from_date' => $this->values['from_period'], ':to_date' => $this->values['to_period']))->rowCount();


                }

                $args['from_period'] = $this->values['from_period'];
                $args['to_period'] = $this->values['to_period'];
                $pre_email = $this->crud->get_all()[0];

                $my_file = ROOT.DS.'protected/config/config.php';
                $data = file_get_contents($my_file);
                 
                $data = str_replace($pre_email->from_period,$args['from_period'],$data);
                $data = str_replace($pre_email->to_period,$args['to_period'],$data);

                $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
                fwrite($handle, $data);
                fclose($handle);


            }

            else if(isset($this->values['from_period']))
            {
                $args['from_period'] = $this->values['from_period'];

                $query = 'update student_fees set from_period = :from_date';
                $result = $this->crud->exec_query($query, array(':from_date' => $this->values['from_period']))->rowCount();

                if($result > 0)
                {
                    $query = 'delete from fee_details where date < :from_date';
                    $result = $this->crud->exec_query($query, array(':from_date' => $this->values['from_period']))->rowCount();

                    $query = 'select * from attendance where date < :from_date';
                    $result = $this->crud->exec_query($query, array(':from_date' => $this->values['from_period']))->fetchAll(PDO::FETCH_CLASS);

                    foreach ($result as $student) {
                        $query = 'delete from attendance_history where attendance_id = :id';
                        $result = $this->crud->exec_query($query, array(':id' => $student->attendance_id))->rowCount();

                    }

                    $query = 'delete from attendance where date < :from_date';
                    $result = $this->crud->exec_query($query, array(':from_date' => $this->values['from_period']))->rowCount();

                }

                $args['from_period'] = $this->values['from_period'];
                $pre_email = $this->crud->get_all()[0];

                $my_file = ROOT.DS.'protected/config/config.php';
                $data = file_get_contents($my_file);
                 
                $data = str_replace($pre_email->from_period,$args['from_period'],$data);

                $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
                fwrite($handle, $data);
                fclose($handle);
            }
            else if(isset($this->values['to_period']))
            {
                $args['to_period'] = $this->values['to_period'];

                $query = 'update student_fees set to_period = :to_date';
                $result = $this->crud->exec_query($query, array(':to_date' => $this->values['to_period']))->rowCount();

                if($result > 0)
                {
                    $query = 'delete from fee_details where date > :to_date';
                    $result = $this->crud->exec_query($query, array(':to_date' => $this->values['to_period']))->rowCount();

                    $query = 'select * from attendance where date > :to_date';
                    $result = $this->crud->exec_query($query, array(':to_date' => $this->values['to_period']))->fetchAll(PDO::FETCH_CLASS);

                    foreach ($result as $student) {
                        $query = 'delete from attendance_history where attendance_id = :id';
                        $result = $this->crud->exec_query($query, array(':id' => $student->attendance_id))->rowCount();

                    }

                    $query = 'delete from attendance where date > :to_date';
                    $result = $this->crud->exec_query($query, array(':to_date' => $this->values['to_period']))->rowCount();
                }

                $args['to_period'] = $this->values['to_period'];
                $pre_email = $this->crud->get_all()[0];

                $my_file = ROOT.DS.'protected/config/config.php';
                $data = file_get_contents($my_file);
                 
                $data = str_replace($pre_email->to_period,$args['to_period'],$data);

                $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
                fwrite($handle, $data);
                fclose($handle);                
            }

            if(isset($this->values['email']))
            {
                $args['email'] = $this->values['email'];
                $pre_email = $this->crud->get_all()[0];

                $my_file = ROOT.DS.'protected/config/config.php';
                $data = file_get_contents($my_file);
                 
                $data = str_replace($pre_email->email,$args['email'],$data);

                $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
                fwrite($handle, $data);
                fclose($handle);
            }

            $data = $this->crud->update( $args, array( 'id' => $data_prev[0]->id ));
            
            if($data > 0)
            {
                $this->flag = SUCCESS;
                $this->message = ' settings updated';
                return true;
            }
            else
            {
                $this->flag = WARNING;
                $this->message = "Setting weren't updated";
                return true;
            }
        }
        else
        {
            $data = $this->crud->insert( array('institute_name' => $this->values['school_name'], 'school_code' => $this->values['school_code'], 'logo' => $this->values['download_file'], 'address' => $this->values['address'], 'phone' => $this->values['phone'], 'email' => $this->values['email']) );
            
            if($data > 0)
            {
                $this->flag = SUCCESS;
                $this->message = ' settings updated';
                return true;
            }
            else
            {
                $this->flag = ERROR;
                $this->message = "Cannot update settings";
                return true;
            }
        }
        
    }


    function process_password()
    {
     
        $this->values = $_POST;
        if(!$this->check_form($this->values, ['email' => 'Email', 'old'=>'Old Password', 'new' => 'New Password', 'confirm' => 'Confirm Password'])) {
            $this->flag = ERROR;
            return false;
        }

        if($this->values['new'] != $this->values['confirm'])
        {
            $this->flag = ERROR;
            $this->message = 'Passwords donot match';
            return false;
        }

        $this->crud->changeTable('lms_users');

        $this->values['old'] = sha1(AUTH_KEY.$this->values['old']);
        $this->values['new'] = sha1(AUTH_KEY.$this->values['new']);


        $data = $this->crud->update( array('password' => $this->values['new']), array('email' => $this->values['email'], 'password' => $this->values['old'], 'user_id' => session::get('user_id')) );
            
        if($data > 0)
        {
            $this->flag = SUCCESS;
            $this->message = 'Password updated';
            return true;
        }
        else
        {
            $this->flag = ERROR;
            $this->message = "Wrong password";
            return true;
        }
    }

    function process_username()
    {
     
        $this->values = $_POST;
        if(!$this->check_form($this->values, ['email'=>'Email', 'old'=>'Old Username', 'new' => 'New Username'])) {
            $this->flag = ERROR;
            return false;
        }

        $this->crud->changeTable('lms_users');


        $data = $this->crud->update( array('username' => $this->values['new']), array('username' => $this->values['old'], 'email' => $this->values['email'], 'user_id' => session::get('user_id')) );
            
        if($data > 0)
        {
            $this->flag = SUCCESS;
            $this->message = 'Username updated';
            return true;
        }
        else
        {
            $this->flag = ERROR;
            $this->message = "Wrong Username/Email";
            return true;
        }
    }




    function processaddfile()
    {
        $name = $this->name_generator();
        if(isset($_FILES['files']) && $_FILES['files']['name'] != '') {
            $this->values['download_file'] = $_FILES['files'];
            $target_file = basename($this->values["download_file"]["name"]);
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            if ($this->values["download_file"]["size"] > 2010000) {
                    $this->flag = ERROR;
                    $this->message = "File is too large";
                    return false;
                }
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                    $this->flag = ERROR;
                    $this->message = "Valid file is required";
                    return false;
                }



            $target_dir = "public/uploads/";
            $temp = explode(".", $this->values["download_file"]["name"]);
            $filenoext = $this->name_generator();
            $newfilename1 = $filenoext . '.' . end($temp);

            if (move_uploaded_file($this->values["download_file"]["tmp_name"], $target_dir.$newfilename1)) {
                $this->values['download_file'] = $target_dir.$newfilename1;
                return true;

            }
            else {
                $this->flag = ERROR;
                $this->message = "Files could not be uploaded";
                return false;
            }
        }
        else
            return true;
    }

    function get_currency()
    {
        $data = $this->get_settings();
        return $data[0];
    }

}