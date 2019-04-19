<?php
/**
 * File contains necessary information that defines the bootstrap of your application
 * Source code pattern must not be modified
 * Files to be used with the comments.
 * @url : manharsharma.in
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

class login extends Model {
	private $crud;
    public $message;
    public $flag;

	function __construct() {
		$this->crud = new crud('users');
	}

	function process_login() {
		$this->values = $_POST;
		if(!$this->check_form($this->values, ['username'=>'Username','password'=>'Password'])) {
			$this->flag = ERROR;
			return false;
		}

		$this->values['password'] = sha1(AUTH_KEY.$this->values['password']);
		$this->login();
	}

	private function login() {
		$data = $this->crud->get_by( array('user_name' => $this->values['username'], 'user_pass' => $this->values['password']), "=", true );
		
		if(count($data) > 0)
		{
			session::set('user_id', $data->user_id);
			session::set('user_role', $data->user_role);
			session::set('user_name', $data->user_name);
		}
		else
		{
			$this->flag = ERROR;
			$this->message = "Incorrect username/password";
			return true;
		}
		
	}


	function process_forgot() {
		$this->values = $_POST;
			if(!$this->check_form($this->values, ['email'=>'Email'])) {
				$this->flag = WARNING;
				return false;
			}

			if(!$this->check_data($this->values['email'], 'email')) {
				$this->flag = WARNING;
				$this->message = 'Valid email is required';
				return false;
			}
			$this->reset();
	}


	private function reset() {
		
		$this->values['pass_mail'] = $this->pass_generator();
		$this->values['pass'] = sha1(AUTH_KEY.$this->values['pass_mail']);



		$query = "select * from users where user_email = :email";
		$data = $this->crud->exec_query($query, array(':email' => $this->values['email']))->fetch(PDO::FETCH_ASSOC);
		
		if($data)
		{
			$query2 ="update users set user_pass = :pass where user_email = :email";
			$result = $this->crud->exec_query($query2, array(':email' => $this->values['email'], ':pass' => $this->values['pass']));

			if($result) {
				if ($this->send_mail($this->values['email'], 'Password reset', 'Your new Password is : '.$this->values["pass_mail"])) 
					{
                        // when mail has been send successfully
                        $this->flag = SUCCESS;
						$this->message = 'New Password has been sent through mail';
						return true;
                    }
                    else {
                    	 
		                  $this->flag = ERROR;
		                  $this->message = "Could not send verification email. Your password is : $this->values['pass_mail']";
						  return false;
                    }
			}
		}
		else {
			$con = NULL;
			unset($data);
			unset($query);
			$this->flag = ERROR;
			$this->message = 'Wrong Email Address';
		}
				

	}

}

?>