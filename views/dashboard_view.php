<!DOCTYPE html>
<html lang="it">
<!-- header -->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="La libera professione infermieristica">
	<meta name="nurse advisor" content="Infermiere libero porfessionista">
	<title>nurse advisor - dashboard</title>
	<style>
		#popup-form
		{
			display: none;
			position: fixed;
			background: rgb(255, 250, 250);
			height: auto;
			top: 25%;
			left: 50%;
			width: auto;
			font-size: 12px;
		}
		.input-group
		{
		color: #3c763d;
		background-color: #2ecc40;
		border-color: #3c763d;
	}
	</style>
	
	<?php $this->load->view('templates/header');?>
</head>

<body>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-74378790-2', 'auto');
  ga('send', 'pageview');

</script>
	<!-- navigation bars -->
	<?php	$this->load->view('templates/mainnavbar');?>
	<!-- page content -->
	<div id="page-wrapper">
		<?php
		if(isset($myHTML))
		{
		echo $myHTML;
		}
	?>
	</div>
	<!-- footer -->
	
	<?php $this->load->view('templates/footer');?>
	
</body>

</html>