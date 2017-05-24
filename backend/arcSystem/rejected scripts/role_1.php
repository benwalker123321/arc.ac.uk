<?php

class Role{
	
	protected $permissions;
	private static $db;	

	
	protected function  __construct(){
		
		$this->permissionList = array();
		
	}	
	
	public static function setDatabase($db){
		
		self::$db = $db;
	}
	
	
	
	
	public static function getRole($role_id){
		
		// create a role
		$role = new Role();
		
			$stm = self::$db->prepare("SELECT permission_description FROM role_permissions  
					JOIN permissions ON role_permissions.permission_id	= permissions.permission_id
					WHERE role_permissions.role_id = :role_id");
			
			$stm->execute(array(":role_id" => $role_id));

				while($row = $stm->fetch(PDO::FETCH_ASSOC)){
					
					$role->permissionList[$row["permission_description"]] = true;
					
				}	
				return $role; 
		
	}
	
					public function verifyPermission($permission){
						
						return isset($this->permissions[$permission]);
						
					}
	
}

