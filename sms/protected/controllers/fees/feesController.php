<?php

class feesController extends Controller {
    
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

    function actionMain()
    {
        $modal = $this->model('fees');
        $this->data['total_students'] = count($this->model('students')->get_students());
        $this->data['fee_paid_total'] = count($modal->get_paid_students());
        $this->data['fee_pending_total'] = count($modal->get_pending_students());
        $this->data['page_title'] = 'Dashboard Fees | School Management System';

        $this->view('header');
        $this->view('dashboard','fees');
        $this->view('footer');
    }

    function actionProcessFees($page = 1)
    {
        $modal = $this->model('fees');
        $this->prg('prg_data',SITE_URL.'fees/processfees/');
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

        $this->data['students'] = $modal->get_fee_students($filter,$limit);
        $this->data['modal'] = $modal;
        $count = count($modal->get_fee_students($filter));

        if($page > 1)
        {
            $this->data['pagination_link'] .= '<button type="submit" name="filter" class="previous" value="'.($page - 1).'">Previous</button>';
        }
        if($count > count($this->data['students']) * $page && count($this->data['students']) > 0)
        {
            $this->data['pagination_link'] .= '<button type="submit" name="filter" class="next" value="'.($page + 1).'">Next</button>';
        }

        $this->data['page_title'] = 'Process Fees | School Management System';

        $this->view('header');
        $this->view('processfees','fees');
        $this->view('footer');
    }

    function actionPaidFees($page = 1)
    {
        $modal = $this->model('students');
        $this->prg('prg_data',SITE_URL.'fees/paidfees/');
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

            $this->data['page_title'] = 'Fee History | School Management System';

        $this->view('header');
        $this->view('paidfees','fees');
        $this->view('footer');
    }



    function actionfeehistory($page = 1)
    {
        $modal = $this->model('fees');
        $this->prg('prg_data',SITE_URL.'fees/feehistory/');
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

            $this->data['students'] = $modal->fee_history_students($filter,$limit);
            $this->data['modal'] = $modal;
            $count = count($modal->fee_history_students($filter));

            if($page > 1)
            {
                $this->data['pagination_link'] .= '<button type="submit" name="filter" class="previous" value="'.($page - 1).'">Previous</button>';
            }
            if($count > count($this->data['students']) * $page && count($this->data['students']) > 0)
            {
                $this->data['pagination_link'] .= '<button type="submit" name="filter" class="next" value="'.($page + 1).'">Next</button>';
            }

            $this->data['page_title'] = 'Fee History | School Management System';

        $this->view('header');
        $this->view('feehistory','fees');
        $this->view('footer');
    }

    function actionPayFee()
    {

        $modal = $this->model('fees');
        if(isset($_GET['id']) && is_numeric($_GET['id']))
        {
            $student_details = $modal->check_student_fees($_GET['id']);
            if (count($student_details) > 0 && $student_details != false) 
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
                        $modal->update_fees();

                        $this->error['message'] = $modal->message;
                        $this->error['error_code'] = $modal->flag;
                    }

                    if( $this->error['error_code'] == SUCCESS)
                    {
                        $this->data['fee_paid'] = true;
                        $student_details = $modal->check_paid_status($_GET['id'], 'FEES');
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
                if(!isset($this->data['fee_paid']) || $this->data['fee_paid'] != true)
                    $student_details = $modal->get_fees_details($student_details->student_id);

                $this->data['class'] = $this->model('classes')->get_classes();

                $this->data['name'] = $student_details->student_name;
                $this->data['class'] = $student_details->class_name;
                $this->data['balance'] = $student_details->prev_blc;
                $this->data['fees'] =  $student_details->fee_amount;
                $this->data['amount_paid'] =  $student_details->amount_paid;
                $this->data['total'] = $student_details->fee_amount + $student_details->prev_blc;
                $this->data['father_name'] = $student_details->father_name;
                
                $dt = new DateTime();
                $this->data['date'] = $dt->format('Y-m-d');
                $this->data['ref'] = strtotime($student_details->fee_date);
                $this->data['ref'] = date('M, Y', $this->data['ref']);

                $this->view('header');
                $this->view('payfees','fees');
                $this->view('footer');
            }
            else
            {
                header('HTTP/1.1 405 Requested Method Not Allowed');
                echo 'Invalid access! Go <a href="'.SITE_URL.'fees/processfees">Go Back</a>';
                die();
            }
        }
        else
        {
            header('HTTP/1.1 405 Requested Method Not Allowed');
            echo 'Invalid access! Go <a href="'.SITE_URL.'fees/processfees">Go Back</a>';
            die();
        }
    }

    function actionPrintReceipt()
    {
        $modal = $this->model('fees');
        if(isset($_GET['id']) && is_numeric($_GET['id']))
        {
            $student_details = $modal->check_paid_status($_GET['id'], 'FEE');
            if (count($student_details) > 0 && $student_details != false) 
            {
                $student_details = $modal->check_paid_status($_GET['id'], 'FEE');

                $this->data['class'] = $this->model('classes')->get_classes();

                $this->data['name'] = $student_details->student_name;
                $this->data['class'] = $student_details->class_name;
                $this->data['balance'] = $student_details->balance;
                $this->data['prev_blc'] = $student_details->prev_blc;
                $this->data['fees'] =  $student_details->fee_amount;
                $this->data['amount_paid'] =  $student_details->amount_paid;
                $this->data['total'] = $student_details->fee_amount + $student_details->prev_blc;
                $this->data['father_name'] = $student_details->father_name;
                
                $dt = new DateTime();
                $this->data['date'] = $dt->format('Y-m-d');
                $this->data['ref'] = strtotime($student_details->fee_date);
                $this->data['ref'] = date('M, Y', $this->data['ref']);

                $this->data['paiddate'] = strtotime($student_details->paid_date);
                $this->data['paiddate'] = date('M, Y', $this->data['paiddate']);

                $this->view('header');
                $this->view('printreceipt','fees');
                $this->view('footer');
            }
            else
            {
                header('HTTP/1.1 405 Requested Method Not Allowed');
                echo 'Invalid access! Go <a href="'.SITE_URL.'fees/processfees">Go Back</a>';
                die();
            }
        }
        else
        {
            header('HTTP/1.1 405 Requested Method Not Allowed');
            echo 'Invalid access! Go <a href="'.SITE_URL.'fees/processfees">Go Back</a>';
            die();
        }
    }

}
?>