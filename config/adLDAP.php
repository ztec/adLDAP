<?php

return array(
	
	/*
	|--------------------------------------------------------------------------
	| Account Suffix
	|--------------------------------------------------------------------------
	|
	| The full account suffix for your domain.
	|
	| Default: @mydomain.local
	| 
	*/
	
	'account_suffix' => '@wncd.wnc.edu',
	
	/*
	|--------------------------------------------------------------------------
	| Base DN
	|--------------------------------------------------------------------------
	|
	| The base dn for your domain. This is generally the same as your account 
	| suffix, but broken up and prefixed with DC=. Your base dn can be located 
	| in the extended attributes in Active Directory Users and Computers MMC.
	| 
	| Default: DC=mydomain,DC=local
	|
	*/
	
	'base_dn' => 'DC=wncd,DC=wnc,DC=edu',
	
	/*
	|--------------------------------------------------------------------------
	| Domain Controllers
	|--------------------------------------------------------------------------
	|
	| An array of Domain Controllers. If you would like your class to balance 
	| the queries over multiple controllers, you can specify multiple controllers 
	| in the array (or just specify the domain name, as it will resolve to any 
	| Domain Controller in the Active Directory Domain).
	|
	| Bear in mind when setting this option, requests will still be sent to 
	| offline domain controllers specified in this array. This array implements 
	| load balancing, not fault tolerance.
	| 
	| Default: array(“dc01.mydomain.local”)
	|
	*/
	
	'domain_controllers' => array(
		'wncd.wnc.edu',
	),
	
	
	'user_display' => '%<givenName> %<initials> %<sn>',
	
	/*
	|--------------------------------------------------------------------------
	| User Authentication
	|--------------------------------------------------------------------------
	|
	| By default, adLDAP will perform your searches with permissions of the 
	| user account you have called with authenticate(). You may wish to specify 
	| an account with higher privileges to perform privileged operations.
	| 
	| It is strongly recommended to do this, as a standard domain user account 
	| will not have many permissions to query over Active Directory.
	| 
	| Default: null
	|
	*/
	
	'admin_username' => 'cesar.vega',
	'admin_password' => 'Chispas7',
	
	/*
	|--------------------------------------------------------------------------
	| Real Primary Group
	|--------------------------------------------------------------------------
	|
	| AD does not always return the primary group. 
	|
	| http://support.microsoft.com/?kbid=321360 
	|
	| This tweak will resolve the real primary group, but may be resource intensive. 
	| Setting to false will fudge “Domain Users” and is much faster. Keep in mind 
	| though that if someone's primary group is NOT domain users, this is 
	| obviously going to mess up the results.
	| 
	| adLDAP >= 3.1 has a re-written function to reveal the true primary group and
	| should be much less intensive that versions prior to 3.1
	| 
	| Default: true
	|
	*/
	
	// 'real_primarygroup' => true,
	
	/*
	|--------------------------------------------------------------------------
	| SSL
	|--------------------------------------------------------------------------
	|
	| adLDAP can use LDAP over SSL to provide extra functionality such as 
	| password changes. Both your domain controller and your web server need 
	| to be configured to allow LDAP over SSL for this to happen, it cannot 
	| just be set to true. By default domain controllers do not have SSL enabled. 
	|
	| Please see the section on LDAP over SSL for more information.
	| 
	| Default: false
	|
	*/
	
	'use_ssl' => true,
	
	/*
	|--------------------------------------------------------------------------
	| TLS
	|--------------------------------------------------------------------------
	|
	| adLDAP can use LDAP over TLS connections rather than SSL to provide extra
	| functionality such as password changes. Both your domain controller and 
	| your web server need to be configured for this to happen, it cannot just
	| be set to true. Please see the section on LDAP over SSL for more 
	| information. If you enable TLS, you must disable SSL and vice-versa.
	| 
	| Default: false
	| 
	*/
	
	// 'use_tls' => false,
	
	/*
	|--------------------------------------------------------------------------
	| Recursive Groups
	|--------------------------------------------------------------------------
	|
	| When querying group membership, do it recursively, eg. User Fred is a 
	| member of group “Business Unit” “Business Unit” is a member of group 
	| “Department” “Department” is a member of group “Company”.
	| 
	| $adldap→user()→inGroup(“Fred”,”Company”) will returns true with this 
	| option turned on, false if turned off. 
	| 
	| Any function in adLDAP that involves checking group memberships of contacts, 
	| users, etc will use this property. In many of these functions you can 
	| enable this or disable it on a function by function basis as well..
	| 
	| Default: true
	| 
	*/
	
	// 'recursive_groups' => true,

	/*
	|--------------------------------------------------------------------------
	| Port Number
	|--------------------------------------------------------------------------
	|
	| Connection port.
	| 
	| Default: commented
	| 
	*/
	
//	'ad_port' => '',

	/*
	|--------------------------------------------------------------------------
	| ?
	|--------------------------------------------------------------------------
	|
	| This option is coded into constructor, but it isn't documented..
	| 
	| Default: ?
	| 
	*/
	
//	'sso' => '',
);