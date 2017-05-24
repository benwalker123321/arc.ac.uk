<?php
                    // SUBMIT REGISTER
                if(isset($_POST['logSessionAttendanceBtn'])){
                        // The class session submitted
                        $sessionID = $_POST['sessionID'];
                        // The Students in the Class
                       $studentID = $_POST['studentID'];   
                       $attendedSID = $_POST['attended'];
                       
                             

                        if(!$sessionID){
                            
                             echo "<br>";
                                        echo "<p id='message'>Warning: A Session ID is required</p>";
                            
                        } else{
                            
                            //check if the session ID exists to begin with
                            try{
                                    $checkSessionIDQuery = $DB_con->prepare("SELECT session_id FROM sessions WHERE session_id=:sessionID");
                                    $checkSessionIDQuery->execute(array(':sessionID'=> $sessionID));
                                    $sessionIDRow=$checkSessionIDQuery->fetch(PDO::FETCH_ASSOC);
                    
                                    if($sessionIDRow['session_id'] == $sessionID){
                                     //   echo  "This Session Exists";
                                        if($lecturer->classSessionRegistration($sessionID,$studentID,$attendedSID)){ 
                                                        $lecturer->classSessionRegistration();                
                                            }
                                                             $manager->updateStudentAttendance();    
                                    }else{      
                                            echo "<br>";
                                        echo "<p id='message'>The Session ID Not Exists try again.</p>";
                                            return; 
                                        }

                                }catch(PDOException $e){

                                    echo $e->getMessage();

                                }

                               }

                             }
                             
                                //
                                if(isset($_POST['selectSessionGroupBtn'])){

                                    $staffID = trim(filter_input(INPUT_POST,'staffID'));
                                    $groupID = trim(filter_input(INPUT_POST,'sessionGroupSelect'));

                                }
                                    
                                if(isset($_POST['logSessionAttendanceBtn'])){
                                    
                                  
                                     $sessionID = $_POST['sessionID'];
                                    
                                   if($lecturer->updateClassSessionInfo($sessionID)){ 
                                       
                                       $lecturer->updateClassSessionInfo();

                                }
                                        $manager->updateStudentAttendance(); 
                                                               
                                }