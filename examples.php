<?
//include the class
include ($_SERVER["DOCUMENT_ROOT"]."/includes/adLDAP.php");

//create the LDAP connection
$adldap = new adLDAP();

//variables, change these :)
$user="username";
$pass="password";

//authenticate a user
if ($adldap -> authenticate($user,$pass)){
	echo "authenticated!";
	
	//display their user information
	echo ("<pre>");
	print_r($adldap -> user_info($user,$fields));
	echo ("</pre>");
	
	//display their groups
	echo ("<pre>");
	print_r($adldap -> user_groups($user));
	echo ("</pre>");
	
	//check to see if they're a member of a group
	$group="mygroup";
	if ($adldap -> user_ingroup($user,$group)){
		echo ("SUCCESS! User is a member of group: ".$group);
	} else {
		echo ("FAILED! User is not a member of group: ".$group);
	}
	
} else {
	echo ("Authentication failed!");
}

?>