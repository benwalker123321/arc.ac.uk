<?php

class userPre{

    private static $db;
    private $userRoles = array();
   
			
			public  function setDB($db){
				
				self::$db = $db;
			
			}
    
	public function __construct($user_id){
		
		
		$getUser = $this->db->prepare("SELECT * FROM users WHERE user_id = userid");
		$getUser->execute(array(":userid" => $userid));
		
		if($getUser->rowCount() == 1){
			
			$userData = $getUser->fetch(PDO::FETCH_ASSOC);
			$this->user_id = $user_id;
			$this->username = ucfirst($userData['username']);
	//		$this->email = $userData['email'];
			
			self::loadRoles();
			
		}
		
	}

	
			protected static function loadRoles(){
				
				$fetchRoles = $this->db->prepare("SELECT user_role.role_id, roles.role_name FROM user_role
				JOIN roles ON user_role.role_id = roles.role_id WHERE user_role.user_id = :user_id");
				$fetchRoles->execute(array(":user_id" => $this->user_id));
				
				while($row = $fetchRoles->fetch(PDO::FETCH_ASSOC)){
					
					$this->userRoles[$row["role_name"]] = Role::getRolePermissions($row["role_id"]);
					
				}
				
				
			}
			
			public function hasPermission($permission){
				
				foreach($this->userRoles as $role){
					
					if($role->hasPermission($permission)){
						
						return true;
					}
					
				}
				
				return false;
				
			}
   
                   
                    }
