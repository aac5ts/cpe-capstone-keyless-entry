<?php include('scripts/signup.php'); ?>
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

</head>
<body>
	<style>
input#pwd {
        width:180px; 
        padding:3px;
        color: #000;
        float:left;
        margin-right:10px;
}
#pwd_strength_wrap {
        border: 1px solid #D5CEC8;
        display: none;
        float: left;
        padding: 10px;
        position: relative;
        width: 320px;
}
#pwd_strength_wrap:before, #pwd_strength_wrap:after {
        content: ' ';
        height: 0;
        position: absolute;
        width: 0;
        border: 10px solid transparent; /* arrow size */
}
#pwd_strength_wrap:before {
    border-bottom: 7px solid rgba(0, 0, 0, 0);
    border-right: 7px solid rgba(0, 0, 0, 0.1);
    border-top: 7px solid rgba(0, 0, 0, 0);
    content: "";
    display: inline-block;
    left: -18px;
    position: absolute;
    top: 10px;
}
#pwd_strength_wrap:after {
        border-bottom: 6px solid rgba(0, 0, 0, 0);
    border-right: 6px solid #fff;
    border-top: 6px solid rgba(0, 0, 0, 0);
    content: "";
    display: inline-block;
    left: -16px;
    position: absolute;
    top: 11px;
}
#pswd_info ul {
        list-style-type: none;
        margin: 5px 0 0;
        padding: 0;
}
#pswd_info ul li {
        background: url(icon_pwd_strength.png) no-repeat left 2px;
        padding: 0 0 0 20px;
}
#pswd_info ul li.valid {
        background-position: left -42px;
        color: green;
}
#passwordStrength {
    display: block;
    height: 5px;
    margin-bottom: 10px;
    transition: all 0.4s ease;
}
.strength0 {
    background: none; /* too short */
    width: 0px;
}
.strength1 {
    background: none repeat scroll 0 0 #FF4545;/* weak */
    width: 25px;
}
.strength2 {
    background: none repeat scroll 0 0 #FFC824;/* good */
    width: 75px;
}
.strength3 {
        background: none repeat scroll 0 0 #6699CC;/* strong */
    width: 100px;
}
 
.strength4 {
        background: none repeat scroll 0 0 #008000;/* best */
    width: 150px;
}
</style>
  <div class="login-card">
    <h1>Register</h1><br>

       <p><center>Please enter a user name and password and click Register. </center>
        
        <p><FORM NAME ="form1" METHOD ="POST" ACTION ="signup.php">

Username: <INPUT TYPE = 'TEXT' Name ='username'  value="<?PHP print $uname;?>" maxlength="20"><br />
Password: <INPUT TYPE = 'password' Name ='password'  value="<?PHP print $pword;?>" maxlength="16"><br /> 

 <div id="pwd_strength_wrap">
                <div id="passwordDescription">Password not entered</div>
                <div id="passwordStrength" class="strength0"></div>
                <div id="pswd_info">
                        <strong>Strong Password Tips:</strong>
                        <ul>
                                <li class="invalid" id="length">At least 6 characters</li>
                                <li class="invalid" id="pnum">At least one number</li>
                                <li class="invalid" id="capital">At least one lowercase &amp; one uppercase letter</li>
                                <li class="invalid" id="spchar">At least one special character</li>
                        </ul>
                </div><!-- END pswd_info -->
        </div><!-- END pwd_strength_wrap -->



<!--<Input type = 'text' Name = 'accounttype' value=" PHP print $acctype;?>" maxlength = "200" /> -->




<br />

<P align="center">
<INPUT TYPE = "Submit" Name = "Submit1"  VALUE = "Register">


</FORM>

</div>

</body>
</html>
