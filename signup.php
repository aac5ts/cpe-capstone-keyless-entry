<?php include('scripts/signup1.php'); ?>
<?php
include('config.php');?>
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
     
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- DW6 -->
<head>

  <meta charset="UTF-8">

  <title>Log-in</title>

  <link rel='stylesheet' href='http://codepen.io/assets/libs/fullpage/jquery-ui.css'>

    <link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />

</head>
<body>

  <div class="login-card">
    <h1>Register</h1><br>

       <p><center>Please enter a user name and password and click Register. </center>
        
        <p><FORM NAME ="form1" METHOD ="POST" ACTION ="signup.php">

Username: <INPUT TYPE = 'TEXT' Name ='username'  value="<?PHP print $uname;?>" maxlength="20"><br />
Password: <INPUT TYPE = 'password' Name ='password'  value="<?PHP print $pword;?>" maxlength="16"><br />



<!--<Input type = 'text' Name = 'accounttype' value=" PHP print $acctype;?>" maxlength = "200" /> -->




<br />

<P align="center">
<INPUT TYPE = "Submit" Name = "Submit1"  VALUE = "Register">


</FORM>

</div>

</body>
</html>
