<?php
        // CREATE ATTENDANCE CARD FOR EACH STUDENT IN GROUP SESSION CREATED
        if(isset($_POST['createSession'])){
                                     
                       
                        $attendanceCardID="";
                        $attended = "TBD";
                        $studentID = "";
                            if(!$groupID){
                                
                            }else{
                                 if($manager->createAttendanceCard($attendanceCardID,$studentID,$attended)){
                    
                                echo "<p id='message'> CARDS CREATED</p>";
                                
                            }else{

                                echo "<br>";
                                        echo "<p id='message'>Attendance Cards Failed to be Created!</p>";
                            }
                         }
                        
        }
        
                // VIEW A MODULES CLASS SESSIONS BY CLASS TYPE
                if(isset($_POST['viewModuleSessionsAttendanceBtn'])){
                                             echo  "<style> form#overallClassTypeModuleAttendanceForm{                 
                                             display:inline;
                                             }</style> "; 
                                            $moduleID = trim(filter_input(INPUT_POST,'moduleID'));
                                            $classID = trim(filter_input(INPUT_POST,'choice'));

                                            if(!$moduleID || !$classID ){
                                                echo "<br>";
                                                echo "<p id='message'>Fill in all fields </p>";
                                            }else{

                                         try{
                                                    // add groupID too
                                            $checkModuleExistsQuery = $DB_con->prepare("SELECT module_id FROM sessions WHERE module_id=:moduleID");
                                            $checkModuleExistsQuery->execute(array(':moduleID'=> $moduleID));
                                            $MErow=$checkModuleExistsQuery->fetch(PDO::FETCH_ASSOC);

                                            if($MErow['module_id'] == $moduleID){
                                     //           echo  "<script> alert('This module exists')</script>";
                                                

                                                            if($manager->viewModuleSessionsAttendance($moduleID,$classID)){
                                                                        
                                                            } 

                                          
                                                            }

                                            }  
                                        catch(PDOException $e){

                                            echo $e->getMessage();

                                        }

                            }


                }
                                    // VIEW A ROOMS USAGE BY SESSION
                                    if(isset($_POST['roomUsageBtn'])){
                                         echo  "<style> form#roomUsageForm{                 
                                             display:inline;
                                       }</style> "; 
                                        $roomID = trim(filter_input(INPUT_POST,'roomID'));
                                        $sessionID = trim(filter_input(INPUT_POST, 'sessionID'));

                                        if($roomID && $sessionID){

                                            if($manager->checkRoomUsage($roomID,$sessionID)){

                                                $manager->checkRoomUsage();
                                            }

                                        } else{
                                                 echo "<br>";
                                                 echo "<p id='message'>Enter in all fields! </p>";

                                        }        

                                    }
                                    
                                    if(isset($_POST['changeStudentAttendanceBtn'])){
                                         echo  "<style> form#changeStudentAttendanceStatusForm{                 
                                             display:inline;
                                       }</style> "; 
                                        $studentID = trim(filter_input(INPUT_POST,'studentID'));
                                        $sessionID = trim(filter_input(INPUT_POST,'sessionID'));
                                        $attendanceStatus = trim(filter_input(INPUT_POST,'attendanceStatus'));
                                        
                                        if(!$studentID || !$sessionID || !$attendanceStatus){
                                             echo "<br>";
                                                echo "<p id='message'> You need to enter all fields!</p>";    
                                            
                                        }else{
                                        if($manager->changeStudentAttendanceStatus($studentID,$sessionID, $attendanceStatus)){                                           
                                            
                                             echo "<br>";
                                                echo "<p id='message'> Attendance Changed </p>";
                                        }
                                        
                                        $manager->updateStudentAttendance();
                                        }     
                                    }
                                    
                                    if(isset($_POST['viewStudentAttendanceBtn'])){
                                        echo  "<style> form#viewStudentAttendanceForm{                 
                                             display:inline;
                                       }</style> ";
                                        $studentID = trim(filter_input(INPUT_POST,'studentID'));
                                        
                                        if(!$studentID){
                                            echo "<p id='message'> Enter a student id</p>";
                                        }else{
                                          
                                            $checkSIDs = $DB_con->prepare("SELECT student_id FROM students WHERE student_id=$studentID LIMIT 1");
                                            $checkSIDs->execute();
                                            $checkSIDExists = $checkSIDs->rowCount();
                                            
                                            if($checkSIDExists <= 0){
                                                
                                                echo "<p id='message'> The Student ID entered does not exist </p>";
                                            }else{
                                                
                                                if($manager->viewUpdateStudentAttendance($studentID)){}
                                                // calls the attendance function
                                            }
                                            
                                            
                                            
                                        }
                                        
                                    }
