<?php

class errorController extends Controller {

	function __construct()
	{

	}
	
	function actionMain()
	{
		$this->view('error');
	}
}