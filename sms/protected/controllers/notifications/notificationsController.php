<?php

class notificationsController extends Controller {
    
    private $model;
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
        $modal = $this->model('fees');

        if(isset($_GET['export']))
        {
            $modal->process_export('delayed');
        }
        else
        {
            $this->prg('prg_data',SITE_URL.'notifications/');
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

                if(isset($_POST['from_filter']) && $_POST['from_filter'] != '')
                {
                    $filter['from'] = $_POST['from_filter'];
                }
                if(isset($_POST['to_filter']) && $_POST['to_filter'] != '')
                {
                    $filter['to'] = $_POST['to_filter'];
                }
                $this->data['filter'] = $filter;
            }

            $this->data['books'] = $modal->get_delayed($filter, $limit);
            $count = count( $modal->get_delayed($filter));

            if($page > 1)
            {
                $this->data['pagination_link'] .= '<button type="submit" name="filter" class="previous" value="'.($page - 1).'">Previous</button>';
            }
            if($count > count($this->data['books']) * $page && count($this->data['books']) > 0)
            {
                $this->data['pagination_link'] .= '<button type="submit" name="filter" class="next" value="'.($page + 1).'">Next</button>';
            }

            $this->data['page_title'] = 'Notifications | School Management System';

            $this->view('header');
            $this->view('notify','notifications');
            $this->view('footer');
        }
    }

    function actionNotify()
    {
        if(Helpers::isAjax())
        {
            $modal = $this->model('fees');

            $this->values = $_POST;

            if(!$this->check_form($this->values, ['message'=>'Message'])) {
                
                $response = '<div class="msg fail"><p>'.$this->message.'</p></div>' ;
                $code = ERROR;

                echo json_encode(array('text'=>$response, 'code'=>$code));

                die();
            }

            $students = $modal->process_notify();

            if(count($students) > 0)
            {
                $modal = $this->model('sms');
                $numbers = array();
                $messages = array();

                foreach($students as $student)
                {
                    array_push($numbers, $student->father_phone);

                    $this->values['message'] = "Dear Parents, Please note that there is a sum of fees pending for your child \"".$student->student_name."\". Please clear all the fees at the earliest to avoid any inconveniences.".$this->values['message'];

                    array_push($messages, $this->values['message']);                
                }

                $modal->send_sms($numbers, $messages);
            }



            $response = ($modal->flag == SUCCESS) ? '<div class="msg success"><p>'.$modal->message.'</p></div>' : '<div class="msg fail"><p>'.$modal->message.'</p></div>' ;
            $code = $modal->flag;

            echo json_encode(array('text'=>$response, 'code'=>$code));
        }
    }
}
?>