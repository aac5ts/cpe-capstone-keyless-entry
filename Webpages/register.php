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

  <title>Join</title>

  <link rel='stylesheet' href='http://codepen.io/assets/libs/fullpage/jquery-ui.css'>

    <link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />

<style>


input#pwd {
        width:274px;
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
        width: 250px;
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

</head>
<body>
	
  <div class="login-card">

    

    <h1>Register or Join a Group</h1><br>

       <p><center>Please select a group to join or create a group. </center>
        <UL id="example_tree">
        <span><h2> Create a Group </h2></span>
<span>        <p><FORM NAME ="form1" METHOD ="POST" ACTION ="signup.php">

Groupname: <INPUT TYPE = 'TEXT' Name ='username'  value="<?PHP print $uname;?>" maxlength="20"><br />

Imp ID: <INPUT TYPE = 'TEXT' Name ='impid'  value="<?PHP print $impid;?>" maxlength="20"><br />
<p><label style="float:left;margin-right:10px;">Group Password: </label><INPUT TYPE = 'password' id= "pwd" Name ='password'  value="<?PHP print $pword;?>" maxlength="16"> <br />

 <div id="pwd_strength_wrap">
            <div id="passwordDescription">Password not entered</div>
            <div id="passwordStrength" class="strength0"></div>
            <div id="pswd_info">
                    <strong>Strong Password Tips:</strong>
                    <ul>
                            <li class="invalid" id="length">At least 8 characters</li>
                            <li class="invalid" id="pnum">At least 1 number</li>
                            <li class="invalid" id="capital">At least 1 lowercase &amp; 1 uppercase letter</li>
                            <li class="invalid" id="spchar">At least 1 special character</li>
                    
            </div><!-- END pswd_info -->
    </div><!-- END pwd_strength_wrap -->






<br />

<P align="center">
<INPUT TYPE = "Submit" Name = "Submit1"  VALUE = "Register Group">
</span></UL>

</FORM>



<UL id="example_tree1">
        <span><h2> Join a Group </h2></span>
<span>  <p><FORM NAME ="form1" METHOD ="POST" ACTION ="signup.php">

Groupname: <INPUT TYPE = 'TEXT' Name ='username'  value="<?PHP print $uname;?>" maxlength="20"><br />

<p><label style="float:left;margin-right:10px;">Group Password: </label><INPUT TYPE = 'password' id= "pwd" Name ='password'  value="<?PHP print $pword;?>" maxlength="16"> <br />

<P align="center">
<INPUT TYPE = "Submit" Name = "Submit1"  VALUE = "Join Group">

</span>
</FORM>
</UL>
<p align="center"><a href='page1.php'>Main Page </a> | <a href='page2.php'>Logout</a></p>
</div>





<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>
$("input#pwd").on("focus keyup", function () {
        var score = 0;
        var a = $(this).val();
        var desc = new Array();
 
        // strength desc
        desc[0] = "Too short";
        desc[1] = "Weak";
        desc[2] = "Good";
        desc[3] = "Strong";
        desc[4] = "Best";
 
        $("#pwd_strength_wrap").fadeIn(400);
         
        // password length
        if (a.length >= 8) {
            $("#length").removeClass("invalid").addClass("valid");
            score++;
        } else {
            $("#length").removeClass("valid").addClass("invalid");
        }
 
        // at least 1 digit in password
        if (a.match(/\d/)) {
            $("#pnum").removeClass("invalid").addClass("valid");
            score++;
        } else {
            $("#pnum").removeClass("valid").addClass("invalid");
        }
 
        // at least 1 capital & lower letter in password
        if (a.match(/[A-Z]/) && a.match(/[a-z]/)) {
            $("#capital").removeClass("invalid").addClass("valid");
            score++;
        } else {
            $("#capital").removeClass("valid").addClass("invalid");
        }
 
        // at least 1 special character in password {
        if ( a.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) ) {
                $("#spchar").removeClass("invalid").addClass("valid");
                score++;
        } else {
                $("#spchar").removeClass("valid").addClass("invalid");
        }
 
 
        if(a.length > 0) {
                //show strength text
                $("#passwordDescription").text(desc[score]);
                // show indicator
                $("#passwordStrength").removeClass().addClass("strength"+score);
        } else {
                $("#passwordDescription").text("Password not entered");
                $("#passwordStrength").removeClass().addClass("strength"+score);
        }
});
 
$("input#pwd").blur(function () {
        $("#pwd_strength_wrap").fadeOut(400);
});
</script>

<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script type="text/javascript">
$(function(){
$('#example_tree').find('SPAN').click(function(e){
    $(this).parent().find('UL').toggle();
});
});
</script>

<script type="text/javascript">
$(function(){
$('#example_tree1').find('SPAN').click(function(e){
    $(this).parent().find('UL').toggle();
});
});
</script>

</body>
</html>
