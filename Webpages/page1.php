<?php 
session_start();
$LG ="";
if(!isset($_SESSION["login"]))  
	 {
		 $LG = "<a href='login.php'>Login</a>"; }
	 else
	 {
		$LG = "<a href='page2.php'>Logout</a>"; 
	}
	 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 

"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- DW6 -->
<head>

  <meta charset="UTF-8">

  <title>Welcome</title>

  <link rel='stylesheet' href='http://codepen.io/assets/libs/fullpage/jquery-ui.css'>

    <link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />

</head>
<body>

  <div class="login-card">
    <h1>Welcome</h1><br>

       <p><center>Welcome to our Capstone Project. Select your option below </center>



<UL id="example_tree">
	<LI><span>Turn LED ON/OFF</span>
	
		<UL>
			<LI><span><a href="https://agent.electricimp.com/YNDvfcWn8MYH?

led=1">ON</a></span></LI>
			<LI><span><a href="https://agent.electricimp.com/YNDvfcWn8MYH?

led=0">OFF</a></span></LI>	
		</UL>
	</LI>
	<LI><span>Check Lock Status</span></LI>
	<LI><span>Lock Door</span></LI>
	<LI><span>Unlock Door</span></LI>
</UL>

<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script type="text/javascript">
$(function(){
$('#example_tree').find('SPAN').click(function(e){
	$(this).parent().find('UL').toggle();
});
});
</script>


        
<br />   
<P align="center">

<a href='page2.php'>Logout</a>

</div>

</body>
</html>
