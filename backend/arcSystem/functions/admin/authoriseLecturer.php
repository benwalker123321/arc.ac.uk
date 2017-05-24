<?php

include_once 'backend/arcSystem/functions/login&register/loggedIn.php';

        // STOPS NON LECTURER OR MANAGER ACCOUNT FROM ACCESSING LECTURER PAGES
        if($user->is_loggedin()!=""){

                   trim($userID = $userRow['user_id']);

                   $roleIDResult = $DB_con->prepare("SELECT role_id FROM user_role WHERE user_id = $userID  LIMIT 1");
                   $roleIDResult->execute();
                   $roleIDa = $roleIDResult->fetchColumn(0);

                     if($roleIDa == "2" || $roleIDa == "3" ){
                     }else{
                         // if logged in user but not authorised for this page redirect to homepage
                         $user->redirect('../../../../../xampp/arc.ac.uk/index.php/home');
                     }

                     }else{
                         $user->redirect('../../../../../xampp/arc.ac.uk/index.php/signIn');
                }

