<?php
        // STOPS LOGGED IN USER FROM ACCESSING THE DEFAULT HOMEPAGE
        if($user->is_loggedin()!=""){        
                include_once 'backend/arcSystem/functions/login&register/loggedIn.php'; // helps bring the userID
                
                   trim($userID = $userRow['user_id']); //stores the userID
                   $roleIDResult = $DB_con->prepare("SELECT role_id FROM user_role WHERE user_id = $userID  LIMIT 1"); // get the roleID from logged in user
                   $roleIDResult->execute();

                   $roleIDa = $roleIDResult->fetchColumn(0);  

                     if($roleIDa == "1"){
                         // redirects student user to their own HOMEPAGE
                         $user->redirect('../../../../../xampp/arc.ac.uk/index.php/studentProfile');
                         
                     } else  if($roleIDa == "2"){
                         // redirects lecturer user to their own HOMEPAGE
                         $user->redirect('../../../../../xampp/arc.ac.uk/index.php/lecturerHomePage');
                         
                     } else  if($roleIDa == "3"){
                         // redirects manager user to thier own HOMEPAGE
                         $user->redirect('../../../../../xampp/arc.ac.uk/index.php/managementHomePage');
                     }
        }else{

         // GUEST USER FINE HERE
        }
