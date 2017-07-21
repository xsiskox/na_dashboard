<!DOCTYPE html>
<html lang="it">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="La libera professione infermieristica">
	<meta name="nurse advisor" content="Infermiere libero porfessionista">
	<title>nurse advisor</title>
	<?php $this->load->view('templates/header');?>
</head>

<body>
	<?php custom_login();?>
	<?php $this->load->view('templates/footer');?>
</body>

</html>
<?php
function custom_login() {
	$creds = array();
	$creds['user_login'] = 'example';
	$creds['user_password'] = 'plaintextpw';
	$creds['remember'] = true;
	$user = wp_signon( $creds, false );
	if ( is_wp_error($user) )
		echo $user->get_error_message();
}
?>