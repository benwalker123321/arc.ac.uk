<?php
            //CREATE SESSION
        if(isset($_POST['createSession'])){
                         echo  "<style> form#createAClassSessionForm{                 
                                             display:inline;
                                       }</style> "; 
                        trim($sessionID="");
                        $groupID = trim(filter_input(INPUT_POST,'groupID'));
                        $staffID = trim(filter_input(INPUT_POST,'staffID'));
                        $roomID = trim(filter_input(INPUT_POST,'roomID'));
                        $moduleID = trim(filter_input(INPUT_POST,'moduleID'));
                        $sessionDate = trim(filter_input(INPUT_POST,'sessionDate'));
                        $sessionStartTime = trim(filter_input(INPUT_POST,'sessionStartTime'));
                        $sessionEndTime = trim(filter_input(INPUT_POST,'sessionEndTime'));
                        $classID = trim(filter_input(INPUT_POST,'classID'));
                        trim($status = "");
                        trim($sessionAttendance = "");
                        trim($info = "");
                        
                            if(!$groupID || !$staffID || !$roomID || !$moduleID || !$sessionDate || !$sessionStartTime || !$sessionEndTime || !$classID ){
                                echo "<br>";                              
                                echo "<p id='message'>Enter All required fields</p>";
                                
                            }else{
                                
                                     if($manager->createClassSession($sessionID,$groupID,$staffID,$roomID,$moduleID,$sessionDate,$sessionStartTime,$sessionEndTime,$classID,$status,$sessionAttendance,$info)){
                           
                                             $manager->updateStudentAttendance(); 
                            
                              }else{
                            
                            echo "Session Was not Created ";
                            
                        }
                                    $manager->updateStudentAttendance(); 
                            }
            
                        }
            //CREATE CLASS GROUP
          if(isset($_POST['createClassGroup'])){
              echo  "<style> form#createGroupForm{                 
                                             display:inline;
                                       }</style>";
              trim($groupID = "");
              $groupName = trim(filter_input(INPUT_POST,'groupName'));
              $moduleID = trim(filter_input(INPUT_POST,'moduleID'));
              $staffID = trim(filter_input(INPUT_POST,'staffID'));
              
                if(!$groupName || !$moduleID){
                                echo "<br>";
                                echo "<p id='message'>Enter All Fields!</p>";
                    }else if($groupName || $moduleID || $staffID){
                                   
                        try{
                     
                    $checkModuleIDQuery = $DB_con->prepare("SELECT module_id FROM modules WHERE module_id=:moduleID");
                    $checkModuleIDQuery->execute(array(':moduleID'=> $moduleID));
                    $MIDrow=$checkModuleIDQuery->fetch(PDO::FETCH_ASSOC);
                    
                    if($MIDrow['module_id'] != $moduleID){
                        
                         echo "<br>";
                           echo "<p id='message'>The Module ID you Entered is invalid Please enter a valid ID</p>";
                        
                    }else if($MIDrow['module_id'] == $moduleID) { 
                        
                        if($manager->createClassGroup($groupID,$groupName,$moduleID,$staffID)){
                         
                            $manager->createClassGroup();  
                        }
                        
                        
                    }
                    
                }  
                catch(PDOException $e){
                    
                    echo $e->getMessage();
                    
                }

                }
          }
                                                     
                        //SEARCH GROUPS
                         if(isset($_POST['searchGroups'])){
                            echo  "<style> form#viewGroupsForm{                 
                                             display:inline;
                                       }</style>";    
                            $numResults = trim(filter_input(INPUT_POST,'numResults'));
                                    
                                    if(!$numResults){
                                        echo"<br>";
                                        echo "<p id='message'> You need to enter a number</p>";
                                        
                                    } else{
                                        
                                        if($manager->searchGroups($numResults)){}
                                        
                                    }
                                

                             }
                             
                                // VIEW MODULE CLASS SESSIONS 
                             
                                   if(isset($_POST['viewModuleClassSessions'])){
                                                echo  "<style> form#findModuleClassSessionsForm{                 
                                             display:inline;
                                       }</style>";
                                    $moduleID = trim(filter_input(INPUT_POST,'moduleID'));
                                    $classType = trim(filter_input(INPUT_POST,'choice'));

                                    if(!$moduleID || !$classType ){
                                        
                                         echo "<br>";
                                         echo "<p id='message'>Fill in all fields</p>";
                                    }else{

                                 try{

                                    $checkModuleExistsQuery = $DB_con->prepare("SELECT module_id FROM modules WHERE module_id=:moduleID");
                                    $checkModuleExistsQuery->execute(array(':moduleID'=> $moduleID));
                                    $MErow=$checkModuleExistsQuery->fetch(PDO::FETCH_ASSOC);

                                    if($MErow['module_id'] == $moduleID){
                                         echo "<br>";
                                            echo "<p id='message'>This module exists</p>";
                                        
                                        if($classType == 1){
                                            
                                                $classIDa = 1;
                                                $classIDb = 0;
                                                $classIDc = 0;
                                                
                                                    if($manager->viewModuleClassSessions($moduleID,$classIDa, $classIDb, $classIDc)){
                                                        $manager->viewModuleClassSessions();           
                                                    } 
                                                    
                                        }else if($classType == 2){
                                                        
                                                        $classIDa = 2;
                                                        $classIDb = 0;
                                                        $classIDc = 0;
                                                
                                                    if($manager->viewModuleClassSessions($moduleID,$classIDa,$classIDb, $classIDc)){
                                                        $manager->viewModuleClassSessions();           
                                                    }  
                                                        
                                                    }else if($classType == 3){
                                                        
                                                         $classIDa = 3;
                                                         $classIDb = 0;
                                                         $classIDc = 0;
                                                
                                                    if($manager->viewModuleClassSessions($moduleID,$classIDa,$classIDb, $classIDc)){
                                                        $manager->viewModuleClassSessions();           
                                                    } 
                                                        
                                                    }else if($classType == 4){
                                                        
                                                         $classIDa = 1;
                                                         $classIDb = 2;
                                                         $classIDc = 0;
                                                    if($manager->viewModuleClassSessions($moduleID,$classIDa,$classIDb, $classIDc)){
                                                        $manager->viewModuleClassSessions();           
                                                    } 
                                                        
                                                        
                                                    }else if($classType == 5){
                                                        
                                                         $classIDa = 1;
                                                         $classIDb = 3;
                                                         $classIDc = 0;
                                                    if($manager->viewModuleClassSessions($moduleID,$classIDa,$classIDb,$classIDc)){
                                                        $manager->viewModuleClassSessions();           
                                                    } 
                                                        
                                                    }else if($classType == 6){
                                                        
                                                         $classIDa = 2;
                                                         $classIDb = 3;
                                                         $classIDc = 0;
                                                
                                                    if($manager->viewModuleClassSessions($moduleID,$classIDa,$classIDb,$classIDc)){
                                                        $manager->viewModuleClassSessions();           
                                                    } 
                                                        
                                                        
                                                    }else if($classType == 7){
                                                        
                                                         $classIDa = 1;
                                                         $classIDb = 2;
                                                         $classIDc = 3;
                                                
                                                            if($manager->viewModuleClassSessions($moduleID,$classIDa,$classIDb,$classIDc)){
                                                                $manager->viewModuleClassSessions();           
                                                            } 
                                                        
                                                    }

                                        
                                    }else if($MErow['module_id'] != $moduleID) { 
                                         echo "<br>";
                                            echo "<p id='message'> The Module ID you entered does not exist</p>";

                                        }

                                    }  
                                catch(PDOException $e){

                                    echo $e->getMessage();

                                }

                    }

                }      