<?php

class lecturer{
            private $db;

            function __construct($DB_con){

                $this->db = $DB_con;

            }
            
                // UPDATE STUDENTS ATTENDANCE CARDS WITH SUBMITTED ANSWERS
            public function classSessionRegistration($sessionID,$studentID,$attendedSID){
                             // update all student attendance cards that are of the session ID that the lecturer enter in the form                   
                                $findStudentsInSessionQuery = "SELECT student_id FROM attendance WHERE session_id = $sessionID";
                                $findStudentsInSessionResult = $this->db->prepare($findStudentsInSessionQuery);
                                $findStudentsInSessionResult->execute();                               
                                $studentCount = $findStudentsInSessionResult->rowCount(0);                                
                                // random student can not log attendance as only student of the group are listed.
                for ($i=0; $i< $studentCount; $i++){
                                $studentIDAttendanceResult = $this->db->prepare(" UPDATE attendance SET attended='$attendedSID[$i]' "
                                        . " WHERE session_id=$sessionID AND student_id='$studentID[$i]' ");
                                $studentIDAttendanceResult->execute(); 
                }
 
            } 
            
            // LOAD THE SIDS OF SELECTED GROUP
             public function loadGroupSIDs($groupID){

                $studentsInGroupQuery = "SELECT * FROM student_groups WHERE group_id=$groupID ";
                $studentsInGroupResult = $this->db->query($studentsInGroupQuery);            
                $studentsInGroupResult->execute();
                
                  while($row = $studentsInGroupResult->fetch()) {
                     echo '<center><label>'.$row['student_id'].'</label>',  '<input type="text" hidden name="studentID[]" value="'.$row['student_id'].'">', 
                             '&nbsp;&nbsp;', '<input type="text" name="attended[]">' ,'</br> </center> </br>';
                          }        
                       
            }
            // LOAD LECTURERS MODULE LIST ON DROPDOWN MENU
            public function loadLecturerModules($staffID){
                                $lecturersModulesQuery  =  " SELECT * FROM groups "                                                    
                                                         . " INNER JOIN modules ON modules.module_id = groups.module_id"
                                                         . " WHERE staff_id=$staffID";
                                   
                                $lecturersModulesResult = $this->db->query($lecturersModulesQuery);
                                $lecturersModulesResult->execute();
                
                                while($row2 = $lecturersModulesResult->fetch()) {
                                            echo '<option value='.$row2['module_id'].'>'.$row2['module_name'].'</option>';
                                        }

                  }
             // LOAD LECTURERS GROUP ON DROPDOWN MENU 
              public function loadLecturerGroups($staffID){
                                $lecturersGroupsQuery  =  " SELECT * FROM groups WHERE staff_id=$staffID";                                                  
                                $lecturersGroupsResult = $this->db->query($lecturersGroupsQuery);
                                $lecturersGroupsResult->execute();
                
                                while($row3 = $lecturersGroupsResult->fetch()) {
                                            echo '<option value='.$row3['group_id'].'>'.$row3['group_name'].'</option>';
                                        }
                  } 
                  
                  public function loadLecturerStudents($staffID){
                      
                      $findLecturerStudents = "SELECT student_groups.student_id FROM student_groups "
                              . " INNER JOIN groups ON groups.group_id = student_groups.group_id"
                              . " WHERE groups.staff_id=$staffID ";
                     $findLecturerStudentsResult = $this->db->prepare($findLecturerStudents); 
                     $findLecturerStudentsResult->execute();
                     
                     while($row4 = $findLecturerStudentsResult->fetch()){
                         
                         echo '<option value = '.$row4['student_id'].'>'. $row4['student_id']. '</option>';
                         
                     }
                  }
                  

                        // UPDATE THE SESSION TABLE WITH SUBMITTED SESSION ID AND ITS CALCULATIONS 
            public function updateClassSessionInfo($sessionID){
                        
                            $studentsSessionAttendanceTallyQuery = " SELECT * FROM attendance WHERE session_id=$sessionID AND attended='YES' ";
                            $studentsSessionAttendanceTallyResult = $this->db->prepare($studentsSessionAttendanceTallyQuery);
                            $studentsSessionAttendanceTallyResult->execute();
                            
                           $studentsNumTally = $studentsSessionAttendanceTallyResult->rowCount(); 
                           
                           $possibleSessionAttendanceTallyQuery = " SELECT * FROM attendance WHERE session_id=$sessionID ";
                           $possibleSessionAttendanceTallyResult = $this->db->prepare($possibleSessionAttendanceTallyQuery);
                           $possibleSessionAttendanceTallyResult->execute();
                            
                           $possibleNumTotalTally = $possibleSessionAttendanceTallyResult->rowCount(); 
                           
                           if($studentsNumTally != 0 && $possibleNumTotalTally != 0){
                               
                               $attendance = ($studentsNumTally / $possibleNumTotalTally) * 100;
                               
                               if($attendance >= 90){
                                   
                                   $status = "PAST";
                                   $info = "HIGH ATTENDANCE";
                                   
                                    $updateClassSessionQuery = " UPDATE sessions SET status='$status', attendance='$attendance', information='$info' WHERE session_id=$sessionID ";
                                    $updateClassSessionResult = $this->db->prepare($updateClassSessionQuery);
                                    $updateClassSessionResult->execute();
                                   
                                    if($updateClassSessionResult){
                                        
                                        echo "Class registeration form successfully submitted with high attendance results! ";
                                        
                                    }else{
                                        
                                        echo"NEW ERROR!";
                                    }
                                   
                               } else if($attendance >= 70 && $attendance <= 89){
                                   
                                   $status = "PAST";
                                   $info = "AVERAGE ATTENDANCE";
                                   
                                    $updateClassSessionQuery = " UPDATE sessions SET status='$status', attendance='$attendance', information='$info' WHERE session_id=$sessionID ";
                                    $updateClassSessionResult = $this->db->prepare($updateClassSessionQuery);
                                    $updateClassSessionResult->execute();
                                   
                                    if($updateClassSessionResult){
                                        
                                        echo "Class registeration form successfully submitted with average attendance results! ";
                                        
                                    }else{
                                        
                                        // query failed
                                    }
                                   
                               } else if($attendance <= 69){
                                   
                                   $status = "PAST";
                                   $info = "POOR ATTENDANCE";
                                   
                                    $updateClassSessionQuery = " UPDATE sessions SET status='$status', attendance='$attendance', information='$info' WHERE session_id=$sessionID ";
                                    $updateClassSessionResult = $this->db->prepare($updateClassSessionQuery);
                                    $updateClassSessionResult->execute();
                                   
                                    if($updateClassSessionResult){
      
                                        echo "Class registeration form successfully submitted with poor attendance results! ";
                                    }else{
                                        
                                        // query failed
                                    }
                                   
                               }
                           } else{
                               
                               $attendance = 0;
                               $status = "ERROR";
                               $info = "ERROR";

                               $updateClassSessionErrorQuery = " UPDATE sessions SET status='$status', attendance='$attendance', information='$info' WHERE session_id=$sessionID ";
                               $updateClassSessionErrorResult = $this->db->prepare($updateClassSessionErrorQuery);
                               $updateClassSessionErrorResult->execute();
                               
                               if($updateClassSessionErrorResult){
                                   
                                   echo " The Form was submitted, but there maybe errors, please check with you local manager";
                               }else{
                                   // query failed!
                                   
                               }

                           }

                    }
                        // VIEW CLASS GROUP ATTENDANCE
                    public function viewClassGroupAttendance($staffID,$groupID){
                        
                              $viewClassGroupAttendanceQuery = "SELECT * FROM sessions "
                                      . " INNER JOIN classes ON classes.class_id = sessions.class_id"
                                      . " INNER JOIN modules ON modules.module_id = sessions.module_id"
                                      . " INNER JOIN groups ON groups.group_id = sessions.group_id"
                                      . " INNER JOIN staff ON staff.staff_id = sessions.staff_id"
                                      . " INNER JOIN rooms ON rooms.room_id = sessions.room_id "
                                      . " WHERE sessions.group_id=$groupID ";
                              
                                  $viewClassGroupAttendanceResult = $this->db->query($viewClassGroupAttendanceQuery);

                                                print ("<table id='classAttendanceTable' border='3'>");
   
                                print ("<tr>");
                                            print ("<th>  Session ID </th>");
                                            print ("<th>  Group Name </th>");
                                            print ("<th>  Staff Name </th>");
                                            print ("<th>  Room Name </th>");
                                            print ("<th>  Module Name </th>");
                                            print ("<th>  Session Date </th>");
                                            print ("<th>  Session Start Time </th>");
                                            print ("<th>  Session End Time</th>");
                                            print ("<th>  Class Type </th>");
                                            print ("<th>  Statues </th>");
                                            print ("<th>  Attendance </th>");
                                            print ("<th>  Information </th>");
                                print ("</tr>");                
                                                
                          while($row = $viewClassGroupAttendanceResult->fetch()) {

                              print ("<tr>");
                                    
                                    print ("<td> $row[session_id] </td>");
                                    print ("<td> $row[group_name] </td>");
                                    print ("<td> $row[full_name] </td>");
                                    print ("<td> $row[room_name] </td>");
                                    print ("<td> $row[module_name] </td>");
                                    print ("<td> $row[session_date] </td>");
                                    print ("<td> $row[session_start_time] </td>");
                                    print ("<td> $row[session_end_time] </td>");
                                    print ("<td> $row[class_type] </td>");
                                    print ("<td> $row[status] </td>");
                                    print ("<td> $row[attendance] </td>");
                                    print ("<th> $row[information] </th>");

                              print ("</tr>");
                          }

                          print ("</table");
                        }
                        // VIEW MODULE ATTENDANCE
                    public function viewModuleAttendance($staffID,$moduleID){
                        
                        $calModuleAttendanceQuery = "SELECT * FROM attendance "
                                . " INNER JOIN sessions ON sessions.session_id = attendance.session_id"
                                . " WHERE sessions.staff_id=$staffID AND sessions.module_id=$moduleID AND attended IN ('YES','TBD') ";
                        $calModuleAttendanceResult = $this->db->prepare($calModuleAttendanceQuery);
                        $calModuleAttendanceResult->execute(); 
                        $stuModTally = $calModuleAttendanceResult->rowCount();

                       $cal2ModuleAttendanceQuery = "SELECT * FROM attendance "
                                . " INNER JOIN sessions ON sessions.session_id = attendance.session_id"
                                . " WHERE sessions.staff_id=$staffID AND sessions.module_id=$moduleID ";
                        $cal2ModuleAttendanceResult = $this->db->prepare($cal2ModuleAttendanceQuery);
                        $cal2ModuleAttendanceResult->execute(); 
                        
                      $posStuModTally = $cal2ModuleAttendanceResult->rowCount();

                        if($stuModTally != 0 && $posStuModTally != 0){
                               
                            $attendance = ($stuModTally / $posStuModTally) * 100;      
                            print ("<table id='moduleAttendanceTable' border='2'>");
   
                                print ("<tr>");
                                           
                                            print ("<th>  Module Name </th>");
                                            print ("<th>  Attendance </th>");
                                          
                                print ("</tr>");            
                               print ("<tr>");
                                           
                                            print ("<th>  $moduleID </th>");
                                            print ("<th>  $attendance % </th>");
                                          
                                print ("</tr>");                         
                                print ("</table>");
                            
                            
                            
                        }else{
                            
                               print ("<table id='moduleAttendanceTable' border='2'>");
   
                                print ("<tr>");
                                           
                                            print ("<th>  Module Name </th>");
                                            print ("<th>  Attendance </th>");
                                          
                                print ("</tr>");             
                            
                               print ("<tr>");
                                           
                                            print ("<th>  $moduleID </th>");
                                            print ("<th>  0 % </th>");
                                          
                                print ("</tr>");   
                                
                                
                                print ("</table>");
                            
                        }
                        
                        
                        
                        
                        
                    }
                            // UPDATE SELECTED STUDENTS ATTENDANCE 
                         public function viewUpdateStudentAttendance($studentID){
                          
                              $stuModIDQuery = "SELECT course_modules.module_id, modules.module_name "
                                            . " FROM student_course "
                                            . "  INNER JOIN course_modules on course_modules.course_id = student_course.course_id"
                                            . "  INNER JOIN modules ON modules.module_id = course_modules.module_id "
                                            . " WHERE student_id = $studentID ";    
                                   $stuModIDResult = $this->db->query($stuModIDQuery);
                                   $stuModIDResult->execute();                                   
                                   
                                      // this loop will now caluate the attendance for each module and give an overall %  
                                   print ("<table id='studentCourseOverViewTable' border='2'>"); // start of mode
                                   
                                print ("<tr>");
                                            print ("<th> Module Name</th>");
                                            print ("<th> Attendance %</th>");                                   
                                   print ("</tr>");    
                                   
                              while($row = $stuModIDResult->fetch()) {

                      // select all sessions attended or TDB from a module  
                    $stuModQuery = "SELECT * FROM attendance "
                            . " INNER JOIN sessions ON sessions.session_id = attendance.session_id"
                            . " WHERE sessions.module_id = $row[module_id] AND attendance.student_id=$studentID AND attendance.attended IN ('YES','TBD') ";                  
                    $stuModResult = $this->db->prepare($stuModQuery);
                    $stuModResult->execute();
                    $sModANumTotal = $stuModResult->rowCount(); // actucal 
                    
                    // find the possiable number of sessions there are so far for that module 
                    $stuModPosAttendanceQuery  = "SELECT * FROM attendance INNER JOIN sessions ON sessions.session_id = attendance.session_id "
                            . "WHERE sessions.module_id = $row[module_id] AND attendance.student_id= $studentID"; 
                    $stuModPosAttendanceResult = $this->db->prepare($stuModPosAttendanceQuery);
                    $stuModPosAttendanceResult->execute();
                    $sModPNumTotal = $stuModPosAttendanceResult->rowCount(); //possiable
                    
                     // stops Division by 0 Zero Error
                     if($sModANumTotal != 0 && $sModPNumTotal !=0){

                         // Sum up Total Sessions with how many Student Attended
                        $stuModAttendance = ($sModANumTotal / $sModPNumTotal ) * 100;
                     }else{
                           // do nothing
                          $stuModAttendance = 0;
                     }
         
                                print ("<tr>");
                                            print("<td> $row[module_name] </td>");
                                            print ("<td> $stuModAttendance </td>");
                                print ("</tr>");                                   

                             
                              }  
                   print ("</table>");     
                   // this will give the students OVERALL attendance and Update the students Overall Attendance field in the student_attendance table
                    $studentsTallyQuery = "SELECT * FROM attendance INNER JOIN sessions ON sessions.session_id = attendance.session_id WHERE  attendance.student_id=$studentID AND attendance.attended IN ('YES','TBD') ";
                    $studentsTallyResult = $this->db->prepare($studentsTallyQuery) ;
                    $studentsTallyResult->execute();
                    $stNumTotal = $studentsTallyResult->rowCount();
                    
                    $possibleAttendanceQuery = "SELECT * FROM attendance INNER JOIN sessions ON sessions.session_id = attendance.session_id WHERE attendance.student_id= $studentID";
                    $possibleAttendanceResult = $this->db->prepare($possibleAttendanceQuery);      
                    $possibleAttendanceResult->execute();
                    $paNumTotal = $possibleAttendanceResult->rowCount();
           
                            if($stNumTotal != 0 && $paNumTotal != 0){

                                $attendance = ($stNumTotal / $paNumTotal) * 100;

                                        print ("<table id='studentCourseOverViewTable' border='2'>");
                                        print("<tr>");
                                              print ("<th>Overall Attendance</th>"); 
                                        print ("</tr>"); 

                                        print("<tr>");
                                              print (" <td> $attendance % </td>");
                                        print ("</tr>");        

                                        print ("</table>");  
                                        }else{
                                // do nothing
                                 }
                             
                               
                         }
                              
                        
                      public function loadLecturerTimetable($staffID){
                           
                            $lecturerTimetableQuery = "SELECT sessions.session_id, sessions.session_date, sessions.session_start_time, sessions.session_end_time, "
                                    . " modules.module_name, groups.group_name, classes.class_type, rooms.room_name "
                                    . " FROM sessions "
                                    . " INNER JOIN modules ON  modules.module_id = sessions.module_id "
                                    . " INNER JOIN classes ON classes.class_id = sessions.class_id "
                                    . " INNER JOIN groups ON groups.group_id = sessions.group_id "
                                    . " INNER JOIN rooms ON rooms.room_id = sessions.room_id "
                                    . " WHERE sessions.staff_id=$staffID AND sessions.status !='PAST' " ;
                            
                            $lecturerTimetableResult = $this->db->prepare($lecturerTimetableQuery);
                            $lecturerTimetableResult->execute(); 
                            
                            while( $row = $lecturerTimetableResult->fetch() ){
                              print ("<tr>");  
                                print ("<td> $row[session_id]</td>");
                                print ("<td> $row[module_name]</td>");
                                print ("<td> $row[group_name]</td>");
                                print ("<td> $row[session_date]</td>");
                                print ("<td> $row[session_start_time]</td>");
                                print ("<td> $row[session_end_time]</td>");
                                print ("<td> $row[room_name]</td>");
                                print ("<td> $row[class_type]</td>");
                              print ("</tr>");  
                            } 
                           
                       }       
                }        

