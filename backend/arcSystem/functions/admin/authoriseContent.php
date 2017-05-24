<?php

            // STOPS UNAUTHORISED USERS FROM VIEWING CERTAIN CONTENT ON PAGE INCLUDING PUBLIC PAGES
        if($user->is_loggedin()!=""){

            include_once 'backend/arcSystem/functions/login&register/loggedIn.php';
         
            if(isset($_SESSION['user_session'])){

                   $userID = $userRow['user_id'];
                   $roleIDResult = $DB_con->prepare("SELECT role_id FROM user_role WHERE user_id = $userID  LIMIT 1");
                   $roleIDResult->execute();                    
                   $roleIDa = $roleIDResult->fetchColumn(0);  
         }

         }else{

        }