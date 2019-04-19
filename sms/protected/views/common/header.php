<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= (isset($page_title)) ? $page_title : 'School Management System'; ?></title>
	<link rel="shortcut icon" href="<?php Loader::addAsset("images/favicon.ico"); ?>">
	<?php Loader::addStyle('style.css'); ?>
	<?php Loader::addStyle('css/font-awesome.min.css'); ?>
	<?php Loader::addStyle('jquery.datetimepicker.css'); ?>
	<?php Loader::addScript('jquery.js'); ?>
	<?php Loader::addScript('charts.js'); ?>
	<?php Loader::addScript('selectivizr-min.js'); ?>
	<?php Loader::addScript('superfish.js'); ?>


</head>
<body>

	<div class="container">
		<div class="main clearfix">
			<aside class="left-bar">
				<div class="row">
					<div class="col logo">
						<a href="<?= SITE_URL.'' ?>"><?= (isset($institute_logo) && $institute_logo != '') ? '<img src="'.SITE_URL.$institute_logo.'" width="90px">' : '<img src="'.SITE_URL.'public/images/lms_logo.png" width="90px">' ?></a>
					</div>
				</div>
				<div id="main-menu-wrapper" class="menu">
					<ul id="main-menu">
						<li><a href="<?= SITE_URL.'home/settings/' ?>"><i class="fa fa-cogs"></i><span>Settings</span><i class="fa fa-angle-right pull-right"></i></a></li>
						<li><a href="<?= SITE_URL.'home/' ?>"><i class="fa fa-dashboard"></i><span>Dashboard</span><i class="fa fa-angle-right pull-right"></i></a></li>
						<li><a href="<?= SITE_URL.'students/' ?>"><i class="fa fa-users"></i><span>Students</span><i class="fa fa-angle-right pull-right"></i></a></li>
						<li><a href="<?= SITE_URL.'attendance/' ?>"><i class="fa fa-book" aria-hidden="true"></i><span>Attendance</span><i class="fa fa-angle-right pull-right"></i></a></li>
						<li><a href="<?= SITE_URL.'fees/' ?>"><i class="fa fa-book" aria-hidden="true"></i><span>Fees</span><i class="fa fa-angle-right pull-right"></i></a></li>
						<li><a href="<?= SITE_URL.'certificate/' ?>"><i class="fa fa-book" aria-hidden="true"></i><span>Leaving Certificate</span><i class="fa fa-angle-right pull-right"></i></a></li>
						<li><a href="<?= SITE_URL.'notifications/' ?>"><i class="fa fa-bell"></i><span>Notifications</span><i class="fa fa-angle-right pull-right"></i></a></li>
					</ul>
				</div>
				<div class="footer">
					<p>SMS - <a href="http://www.manharsharma.in">MANHARSHARMA.IN</a></p>
				</div>
			</aside>

			<aside class="right-bar">