<?
//log them out
$lg=$_GET['logout'];
if ($lg=="yes"){ //destroy the session
	session_start();
	$_SESSION = array(); 
	session_destroy();
}

//force the browser to use ssl (STRONGLY RECOMMENDED!!!!!!!!)
if ($_SERVER["SERVER_PORT"]!=443){ header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']); exit(); }

$user=strtoupper($_POST["user"]); //remove case sensitivity on the username
$pass=$_POST["pass"];
$formage=$_POST["formage"];

if (($formage=="old") && ($user!=NULL)){ //prevent null bind

	//include the class and create a connection
	include ($_SERVER["DOCUMENT_ROOT"]."/includes/adLDAP.php");
	$adldap = new adLDAP();
	
	$failed=0;
	//authenticate the user
	if ($adldap -> authenticate($user,$pass)){
		session_start();
		$_SESSION['username']=$user;
		$redir="Location: https://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/menu.htm";
		header($redir);
		exit;
	} else {
		$failed=1;
	}
}

?>

<html>
<head>
<title>adLDAP example</title>
</head>

<body>

This area is restricted.<br>
Please login to continue.<br>

<form method='post' action='<? echo $_SERVER["PHP_SELF"]; ?>'>
<input type='hidden' name='formage' value='old'>

Username: <input type='text' name='user' value='<? echo $username; ?>'><br>
Password: <input type='password' name='pass'><br>
<br>

<input type='submit' name='submit' value='Submit'><br>
<? if ($failed){ echo ("<br>Login Failed!<br><br>\n"); } ?>
</table>
</td>
</tr>
</table>
</form>

<? if ($lg=="yes") { echo ("<br>You have successfully logged out."); } ?>


</body>

</html>

