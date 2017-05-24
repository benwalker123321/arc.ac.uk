<?php
 require_once '/../../core/dbConfig.php';
                
// if login button pressed post data to DB
    if(isset($_POST['loginBtn'])){
 
            trim($userName = filter_input(INPUT_POST,'username'));
            trim($password = filter_input(INPUT_POST, 'password'));
        echo "post called";
            if($user->login($userName,$password)){

             // taking to signingIn page where user type will be checked and then redirected to right account homepage
                 $user->redirect('../../../../../xampp/arc.ac.uk/index.php/signingIn');
                 
            // update student attendance table in case any changes havn't yet been updated
              $manager->updateStudentAttendance(); 
           
            }
               else  {
                      echo "<br>";  
                      echo "<p id='message'>Wrong Username or Password!</p>"; 
                   }
        }
        
       