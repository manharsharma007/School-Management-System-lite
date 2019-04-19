<?php

class certificateController extends Controller {

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

    function actionMain($page = 1)
    {
        
        $modal = $this->model('students');
        $this->prg('prg_data',SITE_URL.'certificate/detailsform');

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

        $this->data['students'] = $modal->get_cert_students($filter,$limit);
        $this->data['modal'] = $modal;
        $count = count($modal->get_cert_students($filter));

        if($page > 1)
        {
            $this->data['pagination_link'] .= '<button type="submit" name="filter" class="previous" value="'.($page - 1).'">Previous</button>';
        }
        if($count > count($this->data['students']) * $page && count($this->data['students']) > 0)
        {
            $this->data['pagination_link'] .= '<button type="submit" name="filter" class="next" value="'.($page + 1).'">Next</button>';
        }

        $this->data['page_title'] = 'View Students | Library Management System';

        $this->view('header');
        $this->view('leavingcertificate','students');
        $this->view('footer');
    }

    function actionIssueCert()
    {        
        $modal = $this->model('students');
        if(isset($_GET['id']) && is_numeric($_GET['id']))
        {
            $student_details = $modal->check_student($_GET['id']);
            if (count($student_details) > 0 && $student_details != false) 
            {
                $modal->issue_cert($_GET['id']);
                $this->error['error_code'] = $modal->flag;
                $this->error['message'] = $modal->message;

                if($modal->flag == SUCCESS)
                {
                    $this->data['issue_status'] = true;
                }

                $this->data['name'] = $student_details->student_name;
                $this->data['class'] = $student_details->class_name;
                $this->data['dob'] = $student_details->dob;
                $this->data['srn'] = $student_details->srn;
                $this->data['reg_no'] = $student_details->reg_no;
                $this->data['father_name'] = $student_details->father_name;
                $this->data['mother_name'] = $student_details->mother_name;

                $this->data['school_name'] = $this->model('settings')->get_settings()[0]->institute_name;
                $this->data['school_address'] = $this->model('settings')->get_settings()[0]->address;
                $this->data['school_code'] = $this->model('settings')->get_settings()[0]->school_code;
                
                $this->data['dateofissue'] = strtotime($student_details->issue_date);
                $this->data['dateofissue'] = date('M, Y', $this->data['dateofissue']);

                $this->view('header');
                $this->view('print_cert','students');
                $this->view('footer');
            }
            else
            {
                header('HTTP/1.1 405 Requested Method Not Allowed');
                echo 'Invalid access! Go <a href="'.SITE_URL.'books/viewbooks">Home</a>';
                die();
            }
        }
        else
        {
            header('HTTP/1.1 405 Requested Method Not Allowed');
            echo 'Invalid access! Go <a href="'.SITE_URL.'books/viewbooks">Home</a>';
            die();
        }
    }

    function actionPrintCert()
    {        
        $modal = $this->model('students');
        if(isset($_GET['id']) && is_numeric($_GET['id']))
        {
            $student_details = $modal->check_cert($_GET['id']);
            if (count($student_details) > 0 && $student_details != false) 
            {

                $this->data['issue_status'] = true;

                $this->data['name'] = $student_details->student_name;
                $this->data['class'] = $student_details->class_name;
                $this->data['dob'] = $student_details->dob;
                $this->data['srn'] = $student_details->srn;
                $this->data['reg_no'] = $student_details->reg_no;
                $this->data['father_name'] = $student_details->father_name;
                $this->data['mother_name'] = $student_details->mother_name;

                $this->data['school_name'] = $this->model('settings')->get_settings()[0]->institute_name;
                $this->data['school_address'] = $this->model('settings')->get_settings()[0]->address;
                $this->data['school_code'] = $this->model('settings')->get_settings()[0]->school_code;
                
                $this->data['dateofissue'] = strtotime($student_details->issue_date);
                $this->data['dateofissue'] = date('M, Y', $this->data['dateofissue']);

                $this->view('header');
                $this->view('print_cert','students');
                $this->view('footer');
            }
            else
            {
                header('HTTP/1.1 405 Requested Method Not Allowed');
                echo 'Invalid access! Go <a href="'.SITE_URL.'books/viewbooks">Home</a>';
                die();
            }
        }
        else
        {
            header('HTTP/1.1 405 Requested Method Not Allowed');
            echo 'Invalid access! Go <a href="'.SITE_URL.'books/viewbooks">Home</a>';
            die();
        }
    }

    function actionPeriodAttendance()
    {
        $modal = $this->model('attendance');

        if(isset($_POST['submit'])) {

            if($_POST['security_token'] !== $_SESSION['token']) 
            {
                $this->error['message'] = 'Token Mismatch';
                $this->error['error_code'] = ERROR;
            }
            else
                {
                    $this->data['students'] = $modal->fetch_attendance_by_period();
                    $this->error['error_code'] = $modal->flag;
                    $this->error['message'] = $modal->message;

                    if(count($this->data['students']) > 0 && $this->data['students'] != false)
                    {
                        $this->data['attendance'] = true;
                        $this->data['fetch_students'] = $modal;
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


        $this->data['page_title'] = 'Take Attendance | School Management System';

        $this->view('header');
        $this->view('viewperiodattendance','attendance');
        $this->view('footer');
    }

    function actionDeleteAttendance()
    {
        $modal = $this->model('attendance');

        if(isset($_POST['submit'])) {

            if($_POST['security_token'] !== $_SESSION['token']) 
            {
                $this->error['message'] = 'Token Mismatch';
                $this->error['error_code'] = ERROR;
            }
            else
                {
                    $this->data['students'] = $modal->delete_attendance();
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


        $this->data['page_title'] = 'Take Attendance | School Management System';

        $this->view('header');
        $this->view('deleteattendance','attendance');
        $this->view('footer');
    }

}

?>