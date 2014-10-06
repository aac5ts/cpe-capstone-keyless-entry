<?PHP

$uname = "";
$pword = "";
$errorMessage = "";
$num_rows = 0;

//==========================================
//	ESCAPE DANGEROUS SQL CHARACTERS
//==========================================
function quote_smart($value, $handle) {

   if (get_magic_quotes_gpc()) {
       $value = stripslashes($value);
   }

   if (!is_numeric($value)) {
       $value = "'" . mysql_real_escape_string($value, $handle) . "'";
   }
   return $value;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$uname = $_POST['username'];
	$pword = $_POST['password'];
	$salt = sha1($uname); 
	$password_hash = sha1($salt . sha1($pword . $salt)); 

	$uname = htmlspecialchars($uname);
	$pword = htmlspecialchars($pword);

	//==========================================
	//	CONNECT TO THE LOCAL DATABASE
	//==========================================
$user_name = "ac8wv";
	$pass_word = "Budail_246";
	$database = "ecomtest";
	$server =  "dbm2.itc.virginia.edu"; //"localhost";

	$db_handle = mysql_connect($server, $user_name, $pass_word);
	$db_found = mysql_select_db($database, $db_handle);

	if ($db_found) {

		$uname = quote_smart($uname, $db_handle);
		$pword = quote_smart($pword, $db_handle);

		$SQL = "SELECT * FROM login WHERE L1 = $uname AND L2 = '$password_hash' ";
		$result = mysql_query($SQL)  or die(mysql_error());
		$num_rows = mysql_num_rows($result);

	//====================================================
	//	CHECK TO SEE IF THE $result VARIABLE IS TRUE
	//====================================================

		//if ($result) {
			if ($num_rows > 0) {
				while($row = mysql_fetch_array( $result ))	
{
$user_id = $row["L1"];
	
}
				session_start();
				$_SESSION['login'] = "1";
				 {
$_SESSION["login"] = array(0=>array("user_id"	=>$user_id));
foreach($_SESSION["login"] as $each_user) {
	
		$user_id=$each_user['user_id'];
	//echo $user_id;
	}
	
}
			header ("Location: page1.php");
			}
			else {
				//$errorMessage = "Invalid Login";
				//session_start();
				//$_SESSION['login'] = '';

				session_start();
				$_SESSION['login'] = "";
				header ("Location: page1.php");
			}	
			
		//}
		//else {
		//	$errorMessage = "Error logging on";
		//} */

	mysql_close($db_handle);

	}

	else {
		$errorMessage = "Error logging on";
	}

}


?>