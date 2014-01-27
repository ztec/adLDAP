<?php

function __autoload($classname) {
	$classname = str_replace('\\', DIRECTORY_SEPARATOR, $classname);
	include 'lib/' . $classname . '.php';
}

$config = include 'config/adLDAP.php';
$adldap = new adLDAP\adLDAP($config);

//$attributes = array(
//	'firstname' => 'Ted',
//	'surname' => 'Turner',
//);
//
//$result = $adldap->user()->modify('1000212342', $attributes);
//
//var_dump($result);
//if ($result == false) {
//	echo $adldap->getLastError();
//}


$attributes = array(
	"username"=>"hello",
	"logon_name"=>"freds@mydomain.local",
	"firstname"=>"Freddy",
	"surname"=>"Smithers",
	//"company"=>"My Company",
	//"department"=>"My Department",
	//"email"=>"freds@mydomain.local",
	"container"=>array("students"),
	"enabled"=>1,
	"password"=>"Password123",
);

try {
	$result = $adldap->user()->create($attributes);
	var_dump($result);
}
catch (adLDAPException $e) {
	echo $e;
	exit();   
}