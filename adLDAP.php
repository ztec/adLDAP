<?
/*
LDAP FUNCTIONS FOR MANIPULATING ACTIVE DIRECTORY
Version 1.0 BETA

Written by Scott Barnett
email: scott@wiggumworld.com
http://adldap.sourceforge.net/

I'd appreciate any improvements or additions to be submitted back
to benefit the entire community :)

Written for PHP 4, should still work fine on PHP 5.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/

class adLDAP{

	// You will need to edit these variables to suit your installation
	var $_account_suffix="@mydomain.local";
	var $_base_dn = "DC=mydomain,DC=local"; 
	
	// An array of domain controllers. Specify multiple controllers if you 
	// would like the class to balance the LDAP queries amongst multiple servers
	var $_domain_controllers = array ("domaincontroller.mydomain.local");
	
	// specify account for searching
	/*
	There is a problem with Active Directory that some queries may cause
	it to crash (yahhh Microsoft!). It's a bug, I've informed them in detail
	of the bug, and I guess it's up to them to fix it. If your domain controller
	crashes, try a Domain Admin account for searches. Make sure you take
	acceptable security precautions if you choose to use this. DO NOT LEAVE
	THIS SCRIPT ON AN OPEN SAMBA SHARE IF YOU ENABLE THIS OPTION!!!
	
	NOTE: I personally would definately not recommend using a domain admin account
	in production. This is here to assist troubleshooting.
	
	You can also use this to specify another account with slightly more
	permissions to use for searches should the need arise.
	*/
	var $_ad_username=NULL;
	var $_ad_password=NULL;
	
	//other variables
	var $_user_dn;
	var $_user_pass;
	var $_conn;
	var $_bind; 
	
	//METHODS
	
	// authenticate($username,$password)
	//	Authenticate to the directory with a specific username and password
	//	Extremely useful for validating login credentials

	// user_info($user,$fields)
	//	Returns an array of information for a specific user
	
	// user_groups($user)
	//	Returns an array of groups that a user is a member off
	
	// user_ingroup($user,$group)
	//	Returns true if the user is a member of the group
	
	// rebind()
	//	Binds to the directory with the default search username and password
	//	specified above.
	

	//You should not need to edit anything below this line
	//This is an open source project, please submit your improvements :)
	//************************************************************************

	// default constructor
	function adLDAP(){
		//connect to the LDAP server as the username/password
		$this->_conn = ldap_connect($this->random_controller()); 
		ldap_set_option($this->_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
		return true;
	}

	// destructor not implemented until PHP5
	//function __destruct(){
	//	ldap_close ($_conn);
	//}

	function random_controller(){
		//select a random domain controller
		mt_srand(doubleval(microtime()) * 100000000);
		$rand=mt_rand(1,count($this->_domain_controllers));
		$rand--;
		return $this->_domain_controllers[$rand];
	}
	
	function authenticate($username,$password){
		//validate a users login credentials

		$returnval=false;
		
		if ($username!=NULL){ //prevent null bind
			$this->_user_dn=$username.$this->_account_suffix;
			$this->_user_pass=$password;
			
			$this->_bind = @ldap_bind($this->_conn,$this->_user_dn,$this->_user_pass);
			if ($this->_bind){ $returnval=true; }
		}
		return $returnval;
	}
	
	function rebind(){
		//connect with another account to search with if necessary
		$ad_dn=$this->_ad_username.$this->_account_suffix;
		$this->_bind = @ldap_bind($this->_conn,$ad_dn,$this->_ad_password);
		if ($this->_bind){
			return true; 
		} else {
			return false;
		}
	}

	function user_info($user,$fields){
		//search the directory for a user and return an array of user information

		if ($user!=NULL){
			//bind as a another account if necessary
			if ($this->_ad_username!=NULL){ $this->rebind(); }
			
			if ($this->_bind){
			
				//perform the search and grab all their details
				$filter="samaccountname=".$user;
				if ($fields==NULL){ $fields=array("samaccountname","mail","memberof","department","displayname","telephonenumber"); }
				//echo ($this->_conn.",".$this->_base_dn.",".$filter.",".$fields);
				$sr=ldap_search($this->_conn,$this->_base_dn,$filter,$fields);
				$entries = ldap_get_entries($this->_conn, $sr);
			
				return $entries;
			}
		}

		return false;
	}
	
	function user_groups($user){
		//return an array of the groups the user is in
		
		if ($this->_ad_username!=NULL){ $this->rebind(); }
		
		if ($this->_bind){
			//search the directory for their information
			$info=@$this->user_info($user,array("memberof"));
			
			//presuming the entry returned is our guy (unique usernames)
			$groups=$info[0][memberof];
			
			$group_array=array();
			for ($i=0; $i<$groups["count"]; $i++){ //for each group
				$line=$groups[$i];
				
				$group_name="";
				$line_length=strlen($line);
				//more presumptions, they're all prefixed with CN=
				//so we ditch the first three characters and the group
				//name goes up to the first comma
				for ($j=3; $j<$line_length; $j++){
					if ($line[$j]==","){
						$j=$line_length;
					} else {
						$group_name.=$line[$j];
					}
				}
				$group_array[$i]=$group_name;
			}
			return $group_array;
		} else {
			return false;	
		}
	}

	function user_ingroup($user,$group){
	
		if (($user!=NULL) && ($group!=NULL)){
			if ($this->_ad_username!=NULL){ $this->rebind(); }

			if ($this->_bind){
				$groups=$this->user_groups($user,array("memberof"));
				if (in_array($group,$groups)){ return true; }
			}
		}
		return false;
	}
}
?>
