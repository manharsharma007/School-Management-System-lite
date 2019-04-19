<?php

class studentsController extends Controller {

    private $pagination_limit = 10;
    private $pagination_buttons = array('Prevoius', 'Next');
    
    function __construct() {
        session::check('user_id', SITE_URL);
        if(session::get('user_role') != 'A')
        {            
            session::clean_session(SITE_URL);
            die();
        }

        $this->data['institute_name'] = $this->model('settings')->get_settings()[0]->institute_name;
        $this->data['institute_address'] = $this->model('settings')->get_settings()[0]->address;
        $this->data['institute_logo'] = $this->model('settings')->get_settings()[0]->logo;
    }

    function actionMain() 
    {
        $modal = $this->model('students');
        $this->data['total_students'] = count($modal->get_students());
        $this->data['total_classes'] = count($this->model('classes')->get_classes());
        $this->data['fee_pending_total'] = count($this->model('fees')->get_fee_students());

        $this->data['class'] = $this->model('classes')->get_classes();

        $this->data['page_title'] = 'Dashboard Students | School Management System';

        $this->view('header');
        $this->view('dashboard','students');
        $this->view('footer');
    }

	function actionAddStudent()
	{
		$modal = $this->model('students');
        if(isset($_POST['submit'])) {

            $this->data = $_POST;

            if($_POST['security_token'] !== $_SESSION['token']) 
            {
                $this->error['message'] = 'Token Mismatch';
                $this->error['error_code'] = ERROR;
            }
            else
            {
                $result = $modal->process_student();
                $this->error['error_code'] = $modal->flag;
                $this->error['message'] = $modal->message;
            }
        }

        /**
         *
         *
         *
         * Generate security token to handle double form submissions
         *
         *
         *
         **/
        $this->data['token'] = md5(uniqid(rand(), TRUE).time());
        $_SESSION['token'] = $this->data['token'];

        $this->data['class'] = $this->model('classes')->get_classes();


        $this->data['page_title'] = 'Add Student | School Management System';

        $this->view('header');
        $this->view('addstudent','students');
        $this->view('footer');
	}

	function actionAddClass()
	{
		$modal = $this->model('classes');
        if(isset($_POST['submit'])) {

            if($_POST['security_token'] !== $_SESSION['token']) 
            {
                $this->error['message'] = 'Token Mismatch';
                $this->error['error_code'] = ERROR;
            }
            else
            {
                $result = $modal->process_class();
                $this->error['error_code'] = $modal->flag;
                $this->error['message'] = $modal->message;
            }
        }

        /**
         *
         *
         *
         * Generate security token to handle double form submissions
         *
         *
         *
         **/
        $this->data['token'] = md5(uniqid(rand(), TRUE).time());
        $_SESSION['token'] = $this->data['token'];



        $this->data['classes'] = $this->model('classes')->get_classes();

        $this->data['page_title'] = 'Add Class | School Management System';

        $this->view('header');
        $this->view('addclass','students');
        $this->view('classes','students');
        $this->view('footer');
	}


	function actionPromoteStudent()
    {
        $modal = $this->model('students');

        if(isset($_POST['promote']))
        {
            if($_POST['security_token'] !== $_SESSION['token']) 
            {
                $this->error['message'] = 'Token Mismatch';
                $this->error['error_code'] = ERROR;
            }
            else
            {
                $modal->promote_students();
                $this->error['error_code'] = $modal->flag;
                $this->error['message'] = $modal->message;
            }
        }

        if(isset($_POST['submit'])) {

            if($_POST['security_token'] !== $_SESSION['token']) 
            {
                $this->error['message'] = 'Token Mismatch';
                $this->error['error_code'] = ERROR;
            }
            else
                {
                    $this->data['students'] = $modal->fetch_by_class();
                    $this->error['error_code'] = $modal->flag;
                    $this->error['message'] = $modal->message;

                    if(count($this->data['students']) > 0 && $this->data['students'] != false)
                    {
                        $this->data['promote'] = true;
                        $this->data['fromclass'] = $_POST['fromclass'];
                        $this->data['toclass'] = $_POST['toclass'];
                    }
                }

            
        }
        /**
         *
         *
         *
         * Generate security token to handle double form submissions
         *
         *
         *
         **/
        $this->data['token'] = md5(uniqid(rand(), TRUE).time());
        $_SESSION['token'] = $this->data['token'];

        $this->data['class'] = $this->model('classes')->get_classes();


        $this->data['page_title'] = 'Promote Student | School Management System';

        $this->view('header');
        $this->view('promotestudent','students');
        $this->view('footer');
    }

    function actionViewStudent($page = 1)
    {
        $modal = $this->model('students');

        if(isset($_GET['export']))
        {
            $modal->process_export();
        }
        else
        {

            $this->prg('prg_data',SITE_URL.'students/viewstudent');
            $this->data['class'] = $this->model('classes')->get_classes();
            
            $filter = array();
            $limit = 'limit 0,'.$this->pagination_limit;
            $this->data['pagination_link'] = '';

            if(isset($_POST['pagination']))
            {
                $page = (int)$_POST['filter'];
            }
            
            if($page > 1)
            {
                $limit = 'limit '.(($page * $this->pagination_limit) - $this->pagination_limit).','.($this->pagination_limit);
            }


            if(isset($_POST['filter']))
            {

                if(isset($_POST['class_filter']) && $_POST['class_filter'] != '')
                {
                    $filter['class'] = $_POST['class_filter'];
                }
                if(isset($_POST['reg_filter']) && $_POST['reg_filter'] != '')
                {
                    $filter['reg_no'] = $_POST['reg_filter'];
                }
                if(isset($_POST['roll_no_filter']) && $_POST['roll_no_filter'] != '')
                {
                    $filter['roll_no'] = $_POST['roll_no_filter'];
                }
                if(isset($_POST['name_filter']) && $_POST['name_filter'] != '')
                {
                    $filter['name'] = $_POST['name_filter'];
                }
                $this->data['filter'] = $filter;
            }

            $this->data['students'] = $modal->get_students($filter,$limit);
            $this->data['modal'] = $modal;
            $count = count($modal->get_students($filter));

            if($page > 1)
            {
                $this->data['pagination_link'] .= '<button type="submit" name="filter" class="previous" value="'.($page - 1).'">Previous</button>';
            }
            if($count > count($this->data['students']) * $page && count($this->data['students']) > 0)
            {
                $this->data['pagination_link'] .= '<button type="submit" name="filter" class="next" value="'.($page + 1).'">Next</button>';
            }

            $this->data['page_title'] = 'View Students | School Management System';

            $this->view('header');
            $this->view('view_student','students');
            $this->view('footer');
        }
    }


    function actionLeftStudent($page = 1)
    {
        $modal = $this->model('students');
     
        $this->prg('prg_data',SITE_URL.'students/leftstudent');
        $this->data['class'] = $this->model('classes')->get_classes();
        
        $filter = array();
        $limit = 'limit 0,'.$this->pagination_limit;
        $this->data['pagination_link'] = '';

        if(isset($_POST['pagination']))
        {
            $page = (int)$_POST['filter'];
        }
        
        if($page > 1)
        {
            $limit = 'limit '.(($page * $this->pagination_limit) - $this->pagination_limit).','.($this->pagination_limit);
        }


        if(isset($_POST['filter']))
        {

            if(isset($_POST['class_filter']) && $_POST['class_filter'] != '')
            {
                $filter['class'] = $_POST['class_filter'];
            }
            if(isset($_POST['reg_filter']) && $_POST['reg_filter'] != '')
            {
                $filter['reg_no'] = $_POST['reg_filter'];
            }
            if(isset($_POST['roll_no_filter']) && $_POST['roll_no_filter'] != '')
            {
                $filter['roll_no'] = $_POST['roll_no_filter'];
            }
            if(isset($_POST['name_filter']) && $_POST['name_filter'] != '')
            {
                $filter['name'] = $_POST['name_filter'];
            }
            $this->data['filter'] = $filter;
        }

        $this->data['students'] = $modal->get_left_students($filter,$limit);
        $this->data['modal'] = $modal;
        $count = count($modal->get_left_students($filter));

        if($page > 1)
        {
            $this->data['pagination_link'] .= '<button type="submit" name="filter" class="previous" value="'.($page - 1).'">Previous</button>';
        }
        if($count > count($this->data['students']) * $page && count($this->data['students']) > 0)
        {
            $this->data['pagination_link'] .= '<button type="submit" name="filter" class="next" value="'.($page + 1).'">Next</button>';
        }

        $this->data['page_title'] = 'View Students | School Management System';

        $this->view('header');
        $this->view('left_student','students');
        $this->view('footer');
    }

    function actionDeleteStudent()
    {
         if(Helpers::isAjax())
        {
            $modal = $this->model('students');

            if(isset($_GET['id']))
            {
                    $modal->delete_student($_GET['id']);
            }

            $response = ($modal->flag == SUCCESS) ? '<div class="msg success"><p>'.$modal->message.'</p></div>' : '<div class="msg fail"><p>'.$modal->message.'</p></div>' ;
            $code = $modal->flag;

            echo json_encode(array('text'=>$response, 'code'=>$code));
        }
    }

    function actionEditStudent()
    {
        $modal = $this->model('students');
        if(isset($_GET['id']) && is_numeric($_GET['id']))
        {
            $user = $modal->check_student($_GET['id']);
            if (count($user) > 0 && $user != false) 
            {
                if(isset($_POST['submit']))
                {
                    if($_POST['security_token'] !== $_SESSION['token']) 
                    {
                        $this->error['message'] = 'Token Mismatch';
                        $this->error['error_code'] = ERROR;
                    }
                    else
                    {
                        $modal->update_student();

                        $this->error['message'] = $modal->message;
                        $this->error['error_code'] = $modal->flag;
                    }
                   
                }
        /**
         *
         *
         *
         * Generate security token to handle double form submissions
         *
         *
         *
         **/
                $this->data['token'] = md5(uniqid(rand(), TRUE).time());
                $_SESSION['token'] = $this->data['token'];

                // update form after submit
                $student = $modal->check_student($_GET['id']);

                $this->data['class'] = $this->model('classes')->get_classes();

                $this->data['student_name'] = $student->student_name;

                $this->data['student_status'] = $student->student_status;

                $this->data['fee_mode'] = $student->fee_mode;

                $this->data['dob'] = $student->dob;

                $this->data['reg_no'] = $student->reg_no;

                $this->data['roll_no'] = $student->roll_no;

                $this->data['srn'] = $student->srn;

                $this->data['lang'] = $student->language;

                $this->data['religion'] = $student->religion;

                $this->data['address'] = $student->residential_address;

                $this->data['father_name'] = $student->father_name;

                $this->data['mother_name'] = $student->mother_name;

                $this->data['father_occupation'] = $student->father_occupation;

                $this->data['mother_occupation'] = $student->mother_occupation;

                $this->data['father_income'] = $student->father_income;

                $this->data['mother_income'] = $student->mother_income;

                $this->data['father_phone'] = $student->father_phone;

                $this->data['mother_phone'] = $student->mother_phone;

                $this->data['father_email'] = $student->father_email;

                $this->data['mother_email'] = $student->mother_email;

                $this->data['father_working'] = $student->father_working;

                $this->data['mother_working'] = $student->mother_working;

                $this->data['father_work_address'] = $student->father_work_address;

                $this->data['mother_work_address'] = $student->mother_work_address;

                $this->data['class_id'] = $student->student_class;

                $this->view('header');
                $this->view('edit_student','students');
                $this->view('footer');
            }
            else
            {
                header('HTTP/1.1 405 Requested Method Not Allowed');
                echo 'Invalid access! Go <a href="'.SITE_URL.'students">Home</a>';
                die();
            }
        }
        else
        {
            header('HTTP/1.1 405 Requested Method Not Allowed');
            echo 'Invalid access! Go <a href="'.SITE_URL.'students">Home</a>';
            die();
        }
    }

    function actionDeleteclass()
    {
         if(Helpers::isAjax())
        {
            $modal = $this->model('classes');

            if(isset($_GET['id']))
            {
                    $modal->delete_class($_GET['id']);
            }

            $response = ($modal->flag == SUCCESS) ? '<div class="msg success"><p>'.$modal->message.'</p></div>' : '<div class="msg fail"><p>'.$modal->message.'</p></div>' ;
            $code = $modal->flag;

            echo json_encode(array('text'=>$response, 'code'=>$code));
        }
    }


    
    function actionUpdateclass()
    {
        if(Helpers::isAjax())
        {
            $modal = $this->model('classes');

            $modal->update_class();

            $response = ($modal->flag == SUCCESS) ? '<div class="msg success"><p>'.$modal->message.'</p></div>' : '<div class="msg fail"><p>'.$modal->message.'</p></div>' ;
            $code = $modal->flag;

            echo json_encode(array('text'=>$response, 'code'=>$code));
        }
    }



    function actionImport()
    {
        if(Helpers::isAjax())
        {
            $modal = $this->model('students');

            $modal->process_import();

            $response = ($modal->flag == SUCCESS) ? '<div class="msg success"><p>'.$modal->message.'</p></div>' : '<div class="msg fail"><p>'.$modal->message.'</p></div>' ;
            $code = $modal->flag;

            echo json_encode(array('text'=>$response, 'code'=>$code));
        }
    }
}

?>