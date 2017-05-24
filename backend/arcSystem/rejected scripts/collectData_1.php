<?php
$servername = "localhost";
$dbusername = "root";
$dbpassword = "password";
$dbname = "angliaruskincollege";
$students = "students";

foreach($_POST as $key => $value){
    
    $$key = htmlentities( trim($value)); 
   
}

switch ( $__action)
{

    case 'register':
        
// if ($pass !== $pass_confirm) {
	//		header( 'Location: index.php?error=password_mismatch' );
	//		exit;
//		}
		
//		$pass = md5( $pass );

		// connection attributes, tells mysql we want UTF8 data
		$mysqlOptions	 = array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET CHARACTER SET utf8',
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
		);
		
		try {
		
			// initiate connection
			$mysqlConn		 = new PDO(
				'mysql:host=' . $servername . ';dbname=' . $dbname . ';charset=utf8', 
				$dbusername, 
				$dbpassword, 
				$mysqlOptions
			);
			// set some more attributes
			$mysqlConn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // error mode
			$mysqlConn->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC ); // fetch results as associative arrays

                        $query = 'INSERT INTO ' . $students . ' ( Username, Full Name, Address, Email, Password  ) VALUES ( :userName, :fullName, :address, :email, :userPassword )';
		//	$params = array(
		//		'Username' => $userName, 
                //		'Full Name' => $fullName,
                //              'Address' => $address,
                //                'Email' => $email,
                 //              'Password' => $userPassword
		//	);

                	$statement = $mysqlConn->prepare($query);
		//	$statement->execute($params);
			
		//	header('Location: index.php?success=account_created');
		
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



?> 