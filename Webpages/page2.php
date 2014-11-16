<?PHP
	session_start();
	//session_destroy();
unset($_SESSION["login"]);
//header("location:index.php");
?>	

	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- DW6 -->
<head>

  <meta charset="UTF-8">

  <title>Log Out</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <link rel='stylesheet' href='http://codepen.io/assets/libs/fullpage/jquery-ui.css'>

    <link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />
    <link rel="stylesheet" href="css/base.css"media="screen" type="text/css"/>
  <link rel="stylesheet" href="css/skeleton.css"media="screen" type="text/css"/>
  <link rel="stylesheet" href="css/layout.css"media="screen" type="text/css"/>
</head>
<body>

  <div class="login-card">
    <h1>User Logged Out</h1><br>

       <p><center><p><a href="login.php">Click here to login again.</a></center>
        


</div>

</body>
</html>