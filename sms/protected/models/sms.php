<?php

class sms extends Model {

	public $key;
	public $name;
	public $type;
	public $flag;
	public $message;

	public function __construct($key = '9b13d670-4d79-4597-b0b4-c3495ab0a76e', $name = 'NUTECH', $type = 'TRANS')
	{
		$this->key = $key;
		$this->name = $name;
		$this->type = $type;
	}
	
	
	public function send_sms($numbers = array(), $message = array())
	{
		$count = 0;
		foreach($numbers as $number)
		{
			$response = json_decode($this->send($number, $message[$count]));
			$response_code = $response[0]->responseCode;
		
			if($response_code == 'Message SuccessFully Submitted')
			{
				$this->flag = SUCCESS;
				$this->message = 'Message SuccessFully Submitted';
			}
			else
			{
				$this->flag = ERROR;
				$this->message = 'Message Not Submitted';
			}
			$count++;
		}
	}
	
	private function send($number,$message)
	{

		$url ='http://sms.bulksmsind.in/sendSMS?username=pratosh&message='.urlencode($message).'&sendername='.urlencode($this->name).'&smstype='.urlencode($this->type).'&numbers='.urlencode($number).'&apikey='.urlencode($this->key);

		$cSession = curl_init(); 
		curl_setopt($cSession,CURLOPT_URL,$url);
		curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($cSession,CURLOPT_HEADER, false); 
		$response=curl_exec($cSession);
		curl_close($cSession);

		return $response;
	}

}