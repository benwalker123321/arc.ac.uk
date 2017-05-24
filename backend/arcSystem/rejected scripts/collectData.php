    <?php
        
        
        // function to insert data in the students table 
        function insertInDB($db) {
   
            // get the data from the front end
            $SID = "";
            $staffID =0;
            $userID= "";
            $userName = $_POST['userName'];
            $fullName = $_POST['fullName'];
            $address = $_POST['address'];
            $email = $_POST['email'];
            $userPassword = $_POST['userPassword'];
            $confirmUserPassword = $_POST['confirmUserPassword'];
            $accountType ="Student";
            
            // check that boxes have been filled in 
            if( !$userName || !$fullName || !$address ||!$email ||!$userPassword ||!$confirmUserPassword ) {
                echo 'One or more fields are empty.';
                return;
            }
            
            if( $userPassword != $confirmUserPassword){ // check password match
                
                echo 'Passwords do not match!';
                
                return; 
            }
            else {
                // escape special characters in a string for use in the SQL statement 
                $userPassword = md5($userPassword);
           }
            
           
           
           $addUserQuery = "INSERT INTO users VALUES ('". $userID ."', '". $SID ."', '". $StaffID ."', '". $userName ."', '". $userPassword ."', '". $accountType ."' )";
           
           $addUserResult = $db->query($addUserQuery);
           
           if($addUserResult){
           
            // inserting a new student user into the students table. 

            $link = mysqli_connect('localhost','root','password','angliaruskincollege');

            $query= "SELECT user_id FROM users ORDER BY user_id DESC Limit 1";
            $result = mysqli_query($link,$query);
            
            
            $userIDnew = "";

            while ($row = mysqli_fetch_array($result)){
                
                $userIDnew .= $row['user_id'] . ", ";
                
            }
            
            $userIDnew = substr($userIDnew, 0, -2);
            
            
            echo $userIDnew;
            
            $addStudentQuery = "INSERT INTO students VALUES ( '". $SID ."' , '". $userIDnew ."' , '" .$fullName . "', '" . $address . "', '" . $email . "')";
            $addStudentResult = $db->query($addStudentQuery);
            
            $SIDquery= "SELECT student_id FROM students ORDER BY student_id DESC Limit 1";
            $SIDresult = mysqli_query($link,$SIDquery);
            
            
            $SIDnew = "";

            while ($row = mysqli_fetch_array($SIDresult)){
                
                $SIDnew .= $row['student_id'] . ", ";
                
            }
            
            $SIDnew = substr($SIDnew, 0, -2);    
            
            $userUpdate = "UPDATE users SET student_id=$SIDnew WHERE user_id=$userIDnew";
            $userUpdateResult = $db->prepare($userUpdate);
            $userUpdateResult->execute();
            
           } else{
               
               echo "Could not add user!";
           }
 
            // check if the student was successfully inserted in the database
            if ($addStudentResult) {
                echo 'The student was inserted in the database';
              header("Location: ../../../../../xampp/arc.ac.uk/index.php");
            
            }
            else {
                // print the error generated
                echo "The student was not inserted in the database:" . $db->error;
            }
            
        }
        /* Main body */
        //connect to the DB
    $dsn = 'mysql:host=localhost;dbname=angliaruskincollege';
        $user = 'root';
        $password = 'password';
        
        try {
            $db = new PDO($dsn, $user, $password);
        } catch (PDOException $e) {
            //           echo 'Connection failed: ' . $e->getMessage();
            die('Sorry, there is a problem with connecting to the Database.');
        }
        insertInDB($db);
                //Enter Validation
                //Enter Redirect
    ?>



                