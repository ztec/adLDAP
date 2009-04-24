<?php
//include the class
require_once("adLDAP.php");

//create the LDAP connection
$adldap = new adLDAP();

//variables, change these :)
$user="username";
$pass="password";

$userlookup = "another_username";
$group="group_name";

//authenticate a user
if ($adldap -> authenticate($user,$pass)){

	echo ("Authenticated ok!<br><br>\n");
	
	// User Information
	$info=$adldap->user_info($userlookup,$fields);
	echo "User Information:";
	echo ("<pre>"); print_r($info); echo ("</pre>\n");
	
	// Users's Groups
	$info=$adldap->user_groups($userlookup);
	echo "User's Groups: (". count($info) ."):";
	echo ("<pre>"); print_r($info); echo ("</pre>\n");

	// All Users
	$info = $adldap->all_users(true);
	echo "All Users: (". count($info) .")";
	echo "<pre>"; print_r($info); echo "</pre>\n";
	
	// All Groups
	$info = $adldap->all_groups(true);
	echo "All Groups: (". count($info) ."):";
	echo "<pre>"; print_r($info); echo "</pre>\n";

	//check to see if they're a member of a group
	if ($adldap -> user_ingroup($userlookup,$group)){
		echo ("SUCCESS! User is a member of group: ".$group);
	} else {
		echo ("FAILED! User is not a member of group: ".$group);
	}

} else {

	echo ("Authentication failed!");
}

?>