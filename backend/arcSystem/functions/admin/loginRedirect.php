<?php
include_once 'backend/arcSystem/functions/login&register/loggedIn.php';
                            // REDIRECTS USER TO THEIR RESPECTIVE ACCOUNT TYPE HOMEPAGE
                         if($user->is_loggedin()!=""){

                             trim($userID = $userRow['user_id']);   
                             $roleIDResult = $DB_con->prepare("SELECT role_id FROM user_role WHERE user_id = $userID  LIMIT 1");
                             $roleIDResult->execute();
                             $roleIDa = $roleIDResult->fetchColumn(0);
                
                    if($roleIDa == "1"){
                
                        $user->redirect('../../../../../xampp/arc.ac.uk/index.php/studentProfile');
                            
                        }else if($roleIDa == "2"){
                
                            $user->redirect('../../../../../xampp/arc.ac.uk/index.php/lecturerHomePage');
                
                        } else if($roleIDa == "3"){
                
                               $user->redirect('../../../../../xampp/arc.ac.uk/index.php/managementHomePage');
                
                        } 
                }

