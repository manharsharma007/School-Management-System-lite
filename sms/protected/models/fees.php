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

class fees extends Model {
    public $page_title;
    public $message;
    public $flag;
    public $values;
    private $crud;

    function __construct() {
        $this->crud = new crud('fee_details');
        $this->auto_generate_fees();
    }

    function check_student_fees($fee_id)
    {
        $query = 'select * from fee_details where fee_id = :fee_id AND (paid_status = \'PENDING\')';
        $student = $this->crud->exec_query($query, array(':fee_id' => $fee_id))->fetchAll(PDO::FETCH_CLASS);
        
        if(count($student) <= 0)
        {
            $this->flag = ERROR;
            $this->message = "Invalid access";
            return false;
        }
        return $student[0];
    }

    function check_paid_status($fee_id, $type = 'FEE')
    {
        if($type == 'STUDENT')
            $query = 'select fee_details.date as fee_date, fee_details.*, students.*, parents_info.*, class.*, student_details.* from students inner join parents_info on students.stu_id = parents_info.student_id inner join student_details on student_details.student_id = students.stu_id inner join class on students.student_class = class.class_id inner join fee_details on students.stu_id = fee_details.student_id where (fee_details.paid_status = \'PAID\' || fee_details.paid_status = \'PARTIAL\') AND fee_details.student_id = :fee_id';
        else

            $query = 'select fee_details.date as fee_date, fee_details.*, students.*, parents_info.*, class.*, student_details.* from students inner join parents_info on students.stu_id = parents_info.student_id inner join student_details on student_details.student_id = students.stu_id inner join class on students.student_class = class.class_id inner join fee_details on students.stu_id = fee_details.student_id where (fee_details.paid_status = \'PAID\' || fee_details.paid_status = \'PARTIAL\') AND fee_details.fee_id = :fee_id';
        $detail = $this->crud->exec_query($query, array(':fee_id' => $fee_id))->fetchAll(PDO::FETCH_CLASS);
        
        if(count($detail) <= 0)
        {
            $this->flag = ERROR;
            $this->message = "Invalid access";
            return false;
        }
        return $detail[0];
    }

    function get_fees_details($student_id)
    {
        $query = "select fee_details.date as fee_date, fee_details.*, students.*, parents_info.*, class.*, student_details.* from students inner join parents_info on students.stu_id = parents_info.student_id inner join student_details on student_details.student_id = students.stu_id inner join class on students.student_class = class.class_id inner join fee_details on students.stu_id = fee_details.student_id where (fee_details.paid_status = 'PENDING') AND fee_details.student_id = :student_id";

        $book = $this->crud->exec_query($query, array(':student_id' => $student_id))->fetchAll(PDO::FETCH_CLASS);
        
        if(count($book) <= 0)
        {
            $this->flag = ERROR;
            $this->message = "Invalid access";
            return false;
        }
        return $book[0];
    }

    function update_fees()
    {
        $this->values = $_POST;

        if(!$this->check_form($_GET, ['id'=>'ID'])) {
            $this->flag = ERROR;
            return false;
        }

        if(!$this->check_form($_POST, ['amount_paid' => 'Amount'])) {
            $this->flag = ERROR;
            return false;
        }

        $fee_id = $_GET['id'];
        $dt = new DateTime();
        $date = $dt->format('Y-m-d H:i:s');

        $prev_data = $this->crud->get_by( array('fee_id' => $fee_id, 'paid_status' => 'PENDING'), '=', true);

        $this->crud->changeTable('students');

        $check = $this->crud->get_by( array('student_status' => 'STUDYING', 'stu_id' => $prev_data->student_id), '=', true);

        $this->crud->changeTable('student_fees');

        $paid_till_date = $this->crud->get_col('total_paid_till_date' , array('student_id' => $prev_data->student_id), '=', true);

        $this->crud->changeTable('fee_details');

        if(count($check) <= 0)
        {
            $this->flag = ERROR;
            $this->message = 'Invalid student details.';
            return false;
        }

        $blc = $prev_data->prev_blc;
        $fees = $prev_data->fee_amount;

        $total_fees = $blc + $fees;

        if($this->values['amount_paid'] > $total_fees || $this->values['amount_paid'] <= 0)
        {
            $this->flag = ERROR;
            $this->message = 'Invalid paid amount';
            return false;
        }

        $blc = $total_fees - $this->values['amount_paid'];


        if($blc > 0)
            $query = 'update fee_details set paid_status = \'PARTIAL\', paid_date = :date, balance = '.$blc.', amount_paid = :amount_paid where fee_id = :fee_id and paid_status = \'PENDING\'';
        else
             $query = 'update fee_details set paid_status = \'PAID\', paid_date = :date, balance = 0, amount_paid = :amount_paid where fee_id = :fee_id and paid_status = \'PENDING\'';

        
        $paid_till_date = $paid_till_date->total_paid_till_date + $this->values['amount_paid'];

        $result = $this->crud->exec_query($query, array(':date' => $date, ':fee_id' => $fee_id, ':amount_paid' => $this->values['amount_paid']))->rowCount();
        


        if(count($result) <= 0)
        {
            $this->flag = ERROR;
            $this->message = "Invalid access";
            return false;
        }
        else
        {
            $this->crud->changeTable('student_fees');
            $this->crud->update( array('fee_status' => 'PAID', 'total_paid_till_date' => $paid_till_date), array('student_id' => $prev_data->student_id) );
            $this->flag = SUCCESS;
            $this->message = "Payment processed  successfully. <a href='#'  onclick=\"window.open('".SITE_URL."fees/printreceipt?id=".$prev_data->fee_id."','Print Receipt','width=650,height=800').print()\">Click here</a> to print the reciept.";
            return true;
        }
    }


    function get_delayed($filter = array(), $limit = false)
    {
        if(count($filter) <= 0 && $limit == false)
        {
            $query = 'select fee_details.date as fee_date, fee_details.*, students.*, parents_info.*, class.*, student_details.* from students inner join parents_info on students.stu_id = parents_info.student_id inner join student_details on student_details.student_id = students.stu_id inner join class on students.student_class = class.class_id inner join fee_details on students.stu_id = fee_details.student_id where fee_details.paid_status = \'PENDING\' and students.student_status = \'STUDYING\'';

            $data = $this->crud->exec_query($query)->fetchAll(PDO::FETCH_CLASS);
            return $data;
        }

        else
        {
            $query = 'select fee_details.date as fee_date, fee_details.*, students.*, parents_info.*, class.*, student_details.* from students inner join parents_info on students.stu_id = parents_info.student_id inner join student_details on student_details.student_id = students.stu_id inner join class on students.student_class = class.class_id inner join fee_details on students.stu_id = fee_details.student_id where fee_details.paid_status = \'PENDING\' and students.student_status = \'STUDYING\'';
            $flag = false;

            if(isset($filter['from']) && isset($filter['to']))
            {
                $filter['from'] =  date("Y-m-d", strtotime($filter['from']));
                $filter['to'] =  date("Y-m-d", strtotime($filter['to']));

                $query =  $query . " where fee_details.date between '".$filter['from']."' AND '".$filter['to']."'" ;
                if($flag == false) $flag = true;
            }

            if($limit != false)
            {
                $query = $query.' '.$limit;
            }

            $data = $this->crud->exec_query($query)->fetchAll(PDO::FETCH_CLASS);
            return $data;
        }
    }


    function process_notify()
    {
        $query = 'select fee_details.date as fee_date, fee_details.*, students.*, parents_info.*, class.*, student_details.* from students inner join parents_info on students.stu_id = parents_info.student_id inner join student_details on student_details.student_id = students.stu_id inner join class on students.student_class = class.class_id inner join fee_details on students.stu_id = fee_details.student_id where fee_details.paid_status = \'PENDING\' and students.student_status = \'STUDYING\'';
        $flag = false;

        if(isset($filter['from']) && isset($filter['to']))
        {
            $filter['from'] =  date("Y-m-d", strtotime($filter['from']));
            $filter['to'] =  date("Y-m-d", strtotime($filter['to']));

            $query =  $query . " where fee_details.date between '".$filter['from']."' AND '".$filter['to']."'" ;
            if($flag == false) $flag = true;
        }
        
        $data = $this->crud->exec_query($query)->fetchAll(PDO::FETCH_CLASS);
        
        if(count($data) > 0)
        {
            return $data;
        }

        else
        {
            $this->flag = ERROR;
            $this->message = "No record found";
            return false;
        }

    }

    function get_pending_students($args = false) {
        if($args == 'today')
        {
            $query = 'SELECT * FROM student_fees inner join students on students.stu_id = student_fees.student_id WHERE fee_status = \'PENDING\' and student_fees.date >= CURDATE() and students.student_status = \'STUDYING\'';
            $flag = false;
        }
        elseif($args == 'month')
        {
            $query = 'SELECT * FROM student_fees inner join students on students.stu_id = student_fees.student_id WHERE fee_status = \'PENDING\' and MONTH(student_fees.date) = MONTH(CURDATE()) and students.student_status = \'STUDYING\'';
            $flag = false;
        }
        elseif($args == 'year')
        {
            $query = 'SELECT * FROM student_fees inner join students on students.stu_id = student_fees.student_id WHERE fee_status = \'PENDING\' and YEAR(student_fees.date) = YEAR(CURDATE()) and students.student_status = \'STUDYING\'';
            $flag = false;
        }
        else
        {
            $query = 'SELECT * FROM student_fees inner join students on students.stu_id = student_fees.student_id WHERE fee_status = \'PENDING\' and students.student_status = \'STUDYING\'';
            $flag = false;
        }
        
        $data = $this->crud->exec_query($query)->fetchAll(PDO::FETCH_CLASS);
        return $data;
    }

    function get_paid_students($args = false) {
        if($args == 'today')
        {
            $query = 'SELECT * FROM student_fees inner join students on students.stu_id = student_fees.student_id WHERE fee_status = \'PAID\' and student_fees.date >= CURDATE() and students.student_status = \'STUDYING\'';
            $flag = false;
        }
        elseif($args == 'month')
        {
            $query = 'SELECT * FROM student_fees inner join students on students.stu_id = student_fees.student_id WHERE fee_status = \'PAID\' and MONTH(student_fees.date) = MONTH(CURDATE()) and students.student_status = \'STUDYING\'';
            $flag = false;
        }
        elseif($args == 'year')
        {
            $query = 'SELECT * FROM student_fees inner join students on students.stu_id = student_fees.student_id WHERE fee_status = \'PAID\' and YEAR(student_fees.date) = YEAR(CURDATE()) and students.student_status = \'STUDYING\'';
            $flag = false;
        }
        else
        {
            $query = 'SELECT * FROM student_fees inner join students on students.stu_id = student_fees.student_id WHERE fee_status = \'PAID\' and students.student_status = \'STUDYING\'';
            $flag = false;
        }
        
        $data = $this->crud->exec_query($query)->fetchAll(PDO::FETCH_CLASS);
        return $data;
    }


    function get_fee_students($filter = array(), $limit = false) {
        $query = "select * from fee_details INNER JOIN students ON students .stu_id = fee_details.student_id INNER JOIN student_details ON student_details.student_id = fee_details.student_id INNER JOIN class ON class.class_id = students.student_class where fee_details.paid_status = 'PENDING' AND students.student_status = 'STUDYING'";
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

    function fee_history_students($filter = array(), $limit = false) {
        $query = "select fee_details.date as fee_date, fee_details.*, students.*, student_details.*, class.* from fee_details INNER JOIN students ON students .stu_id = fee_details.student_id INNER JOIN student_details ON student_details.student_id = fee_details.student_id INNER JOIN class ON class.class_id = students.student_class where (fee_details.paid_status = 'PAID' OR fee_details.paid_status = 'PARTIAL') AND fee_details.student_id = :id order by fee_id DESC";
        $flag = true;
        
        if($limit != false)
        {
            $query = $query.' '.$limit;
        }
        
        $data = $this->crud->exec_query($query, array(':id' => $_GET['id']))->fetchAll(PDO::FETCH_CLASS);
        return $data;
    }


    function auto_generate_fees()
    {
        $dt = new DateTime();
        $curdate = $dt->format('Y-m-d H:i:s');

        $query = 'SELECT * FROM fee_details WHERE (paid_status = \'PENDING\' || paid_status = \'PAID\' || paid_status = \'PARTIAL\') and date >= CURDATE()';
        $data = $this->crud->exec_query($query)->fetchAll(PDO::FETCH_CLASS);

        if(count($data) > 0)
        {
            return false;
        }

        if(date('Y-m-d') == date('Y-m-01')) 
        {
            $this->crud->changeTable('student_fees');

            $details = $this->crud->get_all();

            foreach ($details as $key => $value) 
            {
                
                $from_date = $value->from_period;
                $to_date = $value->to_period;
                $from_date = new DateTime(date('Y/m/d', strtotime($from_date)));
                $to_date = new DateTime(date('Y/m/d', strtotime($to_date)));

                $curr_date = new DateTime(date('Y/m/d'));

                if (
                  $curr_date->getTimestamp() > $from_date->getTimestamp() && 
                  $curr_date->getTimestamp() < $to_date->getTimestamp())
                {
                        $this->crud->changeTable('students');
                        $student = $this->crud->get_col('student_class' , array('stu_id' => $value->student_id, 'student_status' => 'STUDYING'), '=', true);

                        if(count($student) <= 0)
                            return false;

                        $this->crud->changeTable('class');
                        $fees = $this->crud->get_by( array('class_id' => $student->student_class), '=', true);

                        $exclusion_months = unserialize($fees->exclusion_months);
                        $fees = $fees->fees;


                        $student_fees = ($fees - ($fees * ($value->discount_percent / 100)));
                        $prev_balance = $value->previous_balance;

                        $total_months_fee = $this->nb_mois($value->from_period, $value->to_period);

                        if(is_array($exclusion_months) && in_array(date('n'), $exclusion_months))
                        {
                            continue;
                        }

                        else
                        {
                            $this->crud->changeTable('fee_details');
                            
                            if($value->fee_mode == 'MONTHLY')
                            {
                                $query = 'SELECT * FROM fee_details Where student_id = :student_id AND (paid_status = \'PARTIAL\' || paid_status = \'PENDING\')';
                                $prev_fees = $this->crud->exec_query($query, array(':student_id' => $value->student_id))->fetchAll(PDO::FETCH_CLASS);
                                $tmp_blc = 0;

                                if(count($prev_fees) > 0)
                                {
                                    
                                    foreach ($prev_fees as $balance) {
                                        $tmp_blc += $balance->balance;
                                        if($balance->paid_status == 'PENDING')
                                            $tmp_blc += $balance->fee_amount;

                                    }

                                }

                                $this->crud->update( array('paid_status' => 'PAID'), array( 'student_id' => $value->student_id, 'paid_status' => 'PENDING') );

                                $this->crud->insert( array('student_id' => $value->student_id, 'balance' => 0, 'prev_blc' => $tmp_blc, 'amount_paid' => 0, 'fee_amount' => $student_fees, 'paid_status' => 'PENDING', 'date' => $curdate) );
                                
                                $this->crud->update( array('paid_status' => 'PAID'), array( 'student_id' => $value->student_id, 'paid_status' => 'PARTIAL') );

                                $this->crud->changeTable('student_fees');
                                $this->crud->update( array('fee_status' => 'PENDING', 'previous_balance' => $tmp_blc), array('student_id' => $value->student_id) );
                            }
                            elseif($value->fee_mode == 'ANNUALLY')
                            {
                                $query = 'SELECT * FROM fee_details Where student_id = :student_id AND (paid_status = \'PARTIAL\' || paid_status = \'PENDING\')';
                                $prev_fees = $this->crud->exec_query($query, array(':student_id' => $value->student_id))->fetchAll(PDO::FETCH_CLASS);
                                $tmp_blc = 0;
                                $student_fees = ($student_fees * $total_months_fee) - $value->total_paid_till_date;

                                if($student_fees == 0)
                                {
                                    $this->crud->update( array('paid_status' => 'PAID'), array( 'student_id' => $value->student_id, 'paid_status' => 'PENDING') );

                                    $this->crud->insert( array('student_id' => $value->student_id, 'balance' => 0, 'prev_blc' => $tmp_blc, 'amount_paid' => 0, 'fee_amount' => $student_fees, 'paid_status' => 'PAID', 'paid_date' => $curdate, 'date' => $curdate) );
                                    
                                    $this->crud->update( array('paid_status' => 'PAID'), array( 'student_id' => $value->student_id, 'paid_status' => 'PARTIAL') );

                                    $this->crud->changeTable('student_fees');
                                    $this->crud->update( array('fee_status' => 'PAID', 'previous_balance' => $tmp_blc), array('student_id' => $value->student_id) );

                                    continue;
                                }

                                if(count($prev_fees) > 0)
                                {
                                    
                                    foreach ($prev_fees as $balance) {
                                        $tmp_blc += $balance->balance;
                                        if($balance->paid_status == 'PENDING')
                                            $tmp_blc += $balance->fee_amount;
                                    }

                                }
                                
                                $this->crud->update( array('paid_status' => 'PAID'), array( 'student_id' => $value->student_id, 'paid_status' => 'PENDING') );
                                
                                if($value->total_paid_till_date == 0)
                                {
                                    $this->crud->insert( array('student_id' => $value->student_id, 'balance' => 0, 'prev_blc' => $tmp_blc, 'amount_paid' => 0, 'fee_amount' => $student_fees, 'paid_status' => 'PENDING', 'date' => $curdate) );
                                }
                                else
                                {
                                    $this->crud->insert( array('student_id' => $value->student_id, 'balance' => 0, 'prev_blc' => $tmp_blc, 'amount_paid' => 0, 'fee_amount' => 0, 'paid_status' => 'PENDING', 'date' => $curdate) );
                                }
                                    
                                $this->crud->update( array('paid_status' => 'PAID'), array( 'student_id' => $value->student_id, 'paid_status' => 'PARTIAL') );

                                $this->crud->changeTable('student_fees');
                                $this->crud->update( array('fee_status' => 'PENDING', 'previous_balance' => $tmp_blc), array('student_id' => $value->student_id) );
                            }
                        }
                }

            }
        }
    }


    private function nb_mois($date1, $date2)
    {
        $begin = new DateTime( $date1 );
        $end = new DateTime( $date2 );

        $interval = DateInterval::createFromDateString('1 month');

        $period = new DatePeriod($begin, $interval, $end);
        $counter = 0;
        foreach($period as $dt) {
            $counter++;
        }

        return $counter;
    }


}