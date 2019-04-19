<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login | LMS</title>
    <link rel="shortcut icon" href="../public/images/favicon.ico" />
	<?php Loader::addStyle('style.css'); ?>
	<?php Loader::addStyle('css/font-awesome.min.css'); ?>
</head>
<body>
	<div class="login-container container">

	<div class="login-box">
	<form action="#" method="post">

		<div class="login-window">
			<div class="row heading">
				<h4><i class="fa fa-sign-in" aria-hidden="true"></i> Login</h4>
			</div>

	<div class="row">
		<?php
			if(isset($error['error_code']) && isset($error['message'])) {

				if($error['error_code'] == SUCCESS)
					echo '<div class="msg success"><p>'.$error["message"].'</p>';
				elseif($error['error_code'] == WARNING)
					echo '<div class="msg warning"><p>'.$error["message"].'</p>';
				elseif($error['error_code'] == ERROR)
					echo '<div class="msg fail"><p>'.$error["message"].'</p>';

				echo'</div>';
			}
	?>
	</div>
			<div class="input-element clearfix">
				<input type="text" name="username"  required placeholder="Enter username"  value="">
				<i class="fa fa-envelope" aria-hidden="true"></i>
			</div>

			<div class="input-element clearfix">
				<input type="password" name="password" required placeholder="Enter password"   value="">
				<i class="fa fa-key" aria-hidden="true"></i>
			</div>

				<input type="submit" name="submit" value="Login" class="login_btn btn-red btn-green" />

			<div class="row clearfix">
				<p class="forgot"><a href="<?= SITE_URL.'login/forgot/' ?>">Forgot my password? <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a></p>
			</div>
			<div class="row clearfix">
				<p class="forgot"><a href="<?= SITE_URL.'' ?>"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Go home</a></p>
			</div>
		</div>
		
	</form>
</div>
	</div>