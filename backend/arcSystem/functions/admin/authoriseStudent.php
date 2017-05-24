<?php

include_once 'backend/arcSystem/functions/login&register/loggedIn.php'; // helps bring the userID
        // STOPS NON STUDENT OR MANAGERS ACCOUNTS FROM ACCESSING STUDENT PAGES 
        if($user->is_loggedin()!=""){
         

                   trim($userID = $userRow['user_id']); //stores the userID

                   $roleIDResult = $DB_con->prepare("SELECT role_id FROM user_role WHERE user_id = $userID  LIMIT 1"); // get the roleID from logged in user
                   $roleIDResult->execute();

                   $roleIDa = $roleIDResult->fetchColumn(0);  

                     if($roleIDa == "1" || $roleIDa == "3"){

                     }else{

                         // if logged in user but not authorised for this page redirect to homepage
                         $user->redirect('../../../../../xampp/arc.ac.uk/index.php/error');
                     }

        }else{

             $user->redirect('../../../../../xampp/arc.ac.uk/index.php/home');
        }
