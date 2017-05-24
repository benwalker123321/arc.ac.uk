<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'angliaruskincollege');
define('DB_USER', 'root');
define('DB_PASS', 'password');
// Security works!
define('STUDENTS_TABLE', 'students');


// echo STUDENTS_TABLE; student is read

foreach ( $_POST as $key => $value )
{
	$$key = htmlentities( trim( $value ) );
}

switch ( $__action )
{
/*	case 'login':
		
		$pass = md5( $pass );

		// connection attributes, tells mysql we want UTF8 data
		$mysqlOptions	 = array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET CHARACTER SET utf8',
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
		);
		
		try {
		
			// initiate connection
			$mysqlConn		 = new PDO(
				'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', 
				DB_USER, 
				DB_PASS, 
				$mysqlOptions
			);
			// set some more attributes
			$mysqlConn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // error mode
			$mysqlConn->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC ); // fetch results as associative arrays

			$query = 'SELECT * FROM ' . USERS_TABLE . ' WHERE email=:email and password=:password';
			$params = array(
				'email' => $email,
				'password' => $pass
			);

			$statement = $mysqlConn->prepare($query);
			$statement->execute($params);
			
			$user = $statement->fetch();
			var_dump($user);
		
		} 
		catch (PDOException $e) 
		{
			echo $e->getMessage();
		}
		
		break;
            
            */
	case 'register':
		
		if ($userPassword !== $confirmUserPassword) {
                        // This works!
			header( 'Location: index.php?error=password_mismatch' );
			exit;
		}
		
		$userPassword = md5( $userPassword );

		// connection attributes, tells mysql we want UTF8 data
		$mysqlOptions	 = array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET CHARACTER SET utf8',
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
		);
		
		try {
		
			// initiate connection
			$mysqlConn = new PDO( 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS, 
				$mysqlOptions
			);
                        if(!$mysqlConn){
                            echo "error";
                            
                        }else{
                            
                            echo "connected";
                        }
                        
			// set some more attributes
			$mysqlConn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // error mode
			$mysqlConn->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC ); // fetch results as associative arrays

                        
                       
                        
			$query = 'INSERT INTO ' . STUDENTS_TABLE . ' ( SID, Username, Full Name, Address, Email, Password ) VALUES ( :SID, :userName, :fullName, :address, :email, :password )';
                            // invalid parameters
                	$params = array(
                                'SID' => $SID,    
				'userName' => $userName, 
                		'fullName' => $fullName,
                              'address' => $address,
                                'email' => $email,
                              'userPassword' => $userPassword  
			);

			$statement = $mysqlConn->prepare($query);
			$statement->execute($params);
			
			header('Location: index.php?success=account_created');
		
		} 
		catch (PDOException $e) 
		{
			echo $e->getMessage();
		}
		
		break;
	default:
		echo 'Unrecognised action!';
		break;
}

exit;