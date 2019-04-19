<?php

class attendanceController extends Controller {

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
        
        $this->data['today_attendance'] = $this->model('attendance')->get_today_attendance();

        $this->data['classes_model'] = $this->model('classes');
        $this->data['attendance_model'] = $this->model('attendance');

        $this->data['page_title'] = 'Dashboard attendance | Library Management System';

        $this->view('header');
        $this->view('dashboard','attendance');
        $this->view('footer');
    }

    function actionTakeAttendance()
    {
        $modal = $this->model('attendance');

        if(isset($_POST['save_attendance']) && isset($_POST['class']))
        {
            if($_POST['security_token'] !== $_SESSION['token']) 
            {
                $this->error['message'] = 'Token Mismatch';
                $this->error['error_code'] = ERROR;
            }
            else
            {
                $modal->process_attendance();
                $this->error['error_code'] = $modal->flag;
                $this->error['message'] = $modal->message;
            }
        }

        if(isset($_POST['proceed'])) {

            if($_POST['security_token'] !== $_SESSION['token']) 
            {
                $this->error['message'] = 'Token Mismatch';
                $this->error['error_code'] = ERROR;
            }
            else
                {
                    $this->data['students'] = $modal->fetch_students();
                    $this->error['error_code'] = $modal->flag;
                    $this->error['message'] = $modal->message;

                    if(count($this->data['students']) > 0 && $this->data['students'] != false)
                    {
                        $this->data['attendance'] = true;
                        $this->data['class_name'] = $_POST['class'];
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
        $this->view('takeattendance','attendance');
        $this->view('footer');
    }

    function actionViewAttendance()
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
                    $this->data['students'] = $modal->fetch_attendance();
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


        $this->data['page_title'] = 'View Attendance | School Management System';

        $this->view('header');
        $this->view('viewattendance','attendance');
        $this->view('footer');
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


        $this->data['page_title'] = 'Period Attendance | School Management System';

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


        $this->data['page_title'] = 'Delete Attendance | School Management System';

        $this->view('header');
        $this->view('deleteattendance','attendance');
        $this->view('footer');
    }

}

?>