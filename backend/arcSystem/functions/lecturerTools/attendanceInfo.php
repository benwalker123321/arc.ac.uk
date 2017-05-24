<?php
                    // VIEW CLASS GROUP ATTENDANCE
                if(isset($_POST['selectClassGroupBtn'])){
                                    echo  "<style> form#viewClassGroupSessionAttendanceForm{                 
                                              display:inline;
                                             }</style> ";
                                    $groupID = trim(filter_input(INPUT_POST,'selectClass'));
                                    $staffID = trim(filter_input(INPUT_POST,'staffID'));
                                    
                                     if($groupID>= 1 && $groupID <= 1000000 ){
				if($lecturer->viewClassGroupAttendance($staffID,$groupID)){
			
                                    }else{
                                         // do nothing                               
                                    }
                      }
                 }
                                       
                                    // VIEW MODULE ATTENDANCE
                                  
                                 if(isset($_POST['selectModuleBtn'])){
                                    echo  "<style> form#viewModuleAttendanceForm{                 
                                              display:inline;
                                             }</style> "; 
                                    $staffID = trim(filter_input(INPUT_POST,'staffID'));
                                    $moduleID = trim(filter_input(INPUT_POST,'selectModule'));
                                    
                                    if(!$staffID || !$moduleID){
                                        echo "<br>";
                                        echo "<p id='message'> ENTER </p>";
                                    }else{
                                        
                                    if($moduleID >= 1 && $moduleID <= 1000000 ){
                                        $lecturer->viewModuleAttendance($staffID,$moduleID);
                               
																		                                         
                                        }else{
                                            echo '<p id="message">Error</p>';
                                        }											
                                }
                             }
                                 
                                 
                        
                // VIEW STUDENT ATTENDANCE 
                if(isset($_POST['viewStudentAttendanceBtn'])){
                      echo  "<style> form#viewStudentAttendanceForm{                 
                                              display:inline;
                                             }</style> "; 
                    $staffID = trim(filter_input(INPUT_POST,'staffID'));
                    $studentID = trim(filter_input(INPUT_POST,'selectStudent'));
                    
                    
                    if(!$staffID){
                        
                        echo "<br>";
                                        
                                        echo "<p id='message'>Its seems you are not authorised to preform this action!</p>";
                       
                    } else{
                        
                          if (!$studentID){
                              
                               echo "<br>";
                               echo "<p id='message'>Enter The Student ID field </p>";
                              
                             } else{

                                     try{
                                      $checkStaffStudentQuery  = $DB_con->prepare("SELECT groups.staff_id, student_groups.student_id FROM groups"
                                              . " INNER JOIN student_groups ON student_groups.group_id = groups.group_id "
                                              . " WHERE student_groups.student_id=:studentID AND groups.staff_id=:staffID");
                                      $checkStaffStudentQuery->execute(array(':studentID'=> $studentID, ':staffID' => $staffID));
                                      $SSrow= $checkStaffStudentQuery->fetch(PDO::FETCH_ASSOC);
                                            // if statements will be done on the view page
                                       if($SSrow['staff_id'] != $staffID && $SSrow['student_id'] != $studentID){
                                                          
                                             echo "<br>";
                                             echo "<p id='message'>This is not one of your Students IDs!</p>"; 

                                         }else{
                                             if($lecturer->viewUpdateStudentAttendance($studentID)){}; 
                                         }
                                      
                                       
                                  }catch(PDOException $e){

                                      echo $e->getMessage();

                                  }

                             }
                    }
                    

                }
                
                
        
                
                 
                                    