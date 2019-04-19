<?php

class homeController extends Controller {
	private $model;

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


	function actionLogout() {
		session::clean_session(SITE_URL);
	}

	function actionMain() {

		$modal = $this->model('students');

        $this->data['internet'] = $this->is_connected();

        $this->data['total_students'] = count($modal->get_students());
        $this->data['total_paid'] = count($this->model('fees')->get_paid_students());
        $this->data['total_pending'] = count($this->model('fees')->get_pending_students());
        $this->data['total_classes'] = count($this->model('classes')->get_classes());

        $this->data['today_paid'] = count($this->model('fees')->get_paid_students('today'));
        $this->data['today_pending'] = count($this->model('fees')->get_pending_students('today'));

        $this->data['month_paid'] = count($this->model('fees')->get_paid_students('month'));
        $this->data['month_pending'] = count($this->model('fees')->get_pending_students('month'));

        $this->data['today_attendance'] = $this->model('attendance')->get_today_attendance();

        $this->data['classes_model'] = $this->model('classes');
        $this->data['attendance_model'] = $this->model('attendance');

        $this->data['page_title'] = 'Home | School Management System';

        $this->view('header');
        $this->view('dashboard','home');
        $this->view('footer');
	}

	function actionSettings() {

		$model = $this->model('settings');
		if(isset($_POST['submit']))
        {
            if($_POST['security_token'] !== $_SESSION['token']) 
            {
                $this->error['message'] = 'Token Mismatch';
                $this->error['error_code'] = ERROR;
            }
            else
            {
                $result = $model->process_setting();

				$this->error['error_code'] = $model->flag;
				$this->error['message'] = $model->message;
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

		$this->data['settings'] = $model->get_settings();

        $this->data['page_title'] = 'Setting | School Management System';

		$this->view('header');
		$this->view('settings','home');
		$this->view('footer');
	}

    function actionChangePassword() {

        if(Helpers::isAjax())
        {
            $modal = $this->model('settings');

            $modal->process_password();

            $response = ($modal->flag == SUCCESS) ? '<div class="msg success"><p>'.$modal->message.'</p></div>' : '<div class="msg fail"><p>'.$modal->message.'</p></div>' ;
            $code = $modal->flag;

            echo json_encode(array('text'=>$response, 'code'=>$code));
        }
    }

    function actionChangeUsername() {

        if(Helpers::isAjax())
        {
            $modal = $this->model('settings');

            $modal->process_username();

            $response = ($modal->flag == SUCCESS) ? '<div class="msg success"><p>'.$modal->message.'</p></div>' : '<div class="msg fail"><p>'.$modal->message.'</p></div>' ;
            $code = $modal->flag;

            echo json_encode(array('text'=>$response, 'code'=>$code));
        }
    }
    private function is_connected()
    {
        $connected = @fsockopen("www.operce.com", 80); 
                                            //website, port  (try 80 or 443)
        if ($connected){
            $is_conn = true; //action when connected
            fclose($connected);
        }else{
            $is_conn = false; //action in connection failure
        }
        return $is_conn;

    }

}



?>