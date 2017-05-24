<?php

include_once 'backend/arcSystem/functions/login&register/loggedIn.php';

            // STOPS NON MANAGER USERS FROM ACCESSING MANAGER PAGES 
            if($user->is_loggedin()!=""){

  
                       trim($userID = $userRow['user_id']);
                       $roleIDResult = $DB_con->prepare("SELECT role_id FROM user_role WHERE user_id = $userID  LIMIT 1");
                       $roleIDResult->execute();
                       $roleIDa = $roleIDResult->fetchColumn();
                         if($roleIDa == "3"){

                         }else{

                             // if logged in user but not authorised for this page redirect to homepage
                             $user->redirect('../../../../../xampp/arc.ac.uk/index.php/error');

                         

                         }

            }else{
                 $user->redirect('../../../../../xampp/arc.ac.uk/index.php/home');
            }

