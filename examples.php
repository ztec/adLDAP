<?php
//include the class
require_once("adLDAP.php");

//create the LDAP connection
$adldap = new adLDAP();

//variables, change these :)
$user="username";
$pass="password";

//some stuff to search for
$lookup_user  = "another_username"; //a user
$lookup_group = "group name"; //a group

//authenticate a user
if ($adldap -> authenticate($user,$pass)){

	echo ("Authenticated ok!<br><br>\n");

	// User Information
	$info=$adldap->user_info($lookup_user,$fields);
	echo "User Information:";
	echo ("<pre>"); print_r($info); echo ("</pre>\n");
	
	// Users's Groups
	$info=$adldap->user_groups($lookup_user);
	echo "User's Groups:";
	echo ("<pre>"); print_r($info); echo ("</pre>\n");

	// Group Information
	$info=$adldap->group_info($lookup_group);
	echo "Group Information for '".$lookup_group."':";
	echo "<pre>"; print_r($info); echo "</pre>\n";

	//check to see if they're a member of a group
	if ($adldap -> user_ingroup($lookup_user,$group)){
		echo ("SUCCESS! User is a member of group: ".$lookup_group."<br><br>\n");
	} else {
		echo ("FAILED! User is not a member of group: ".$lookup_group."<br><br>\n");
	}

	// All Users
	$info = $adldap->all_users(true);
	echo "All Users: (". count($info) .")";
	echo "<pre>"; print_r($info); echo "</pre>\n";
	
	// All Groups
	$info = $adldap->all_groups(true);
	echo "All Groups: (". count($info) ."):";
	echo "<pre>"; print_r($info); echo "</pre>\n";

} else {

	echo ("Authentication failed!");
}

?>