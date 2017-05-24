<?php

class student{
    private $db;

        function __construct($DB_con){        
            $this->db = $DB_con;        
        }

                        //LOAD STUDENT MODULES LIST
           public function loadModules($studentID){
                    $stuModQuery = "SELECT student_course.student_id, student_course.course_id, course_modules.module_id, modules.module_name "
                                 . "FROM student_course INNER JOIN course_modules on course_modules.course_id = student_course.course_id "
                                 . "LEFT JOIN modules ON modules.module_id = course_modules.module_id WHERE student_id = $studentID ";
                   $stuModResult = $this->db->query($stuModQuery);
                   $stuModResult->execute();

                        while($row = $stuModResult->fetch()) {
                                       echo '<option value='.$row['module_id'].'>'.$row['module_name'].'</option>';
                                   }
           }
                            // VIEW MODULE ATTENDANCE AND BREAKDOWN 
               public  function moduleAttendanceStudent($module,$studentID){
                    // find how many time a student has attended Module Sessions
                    $studentsTallyQuery = "SELECT * FROM attendance INNER JOIN sessions ON sessions.session_id = attendance.session_id"
                            . " WHERE sessions.module_id = $module AND attendance.student_id=$studentID AND attendance.attended IN ('YES','TBD') ";
                    $studentsTallyResult = $this->db->prepare($studentsTallyQuery) ;
                    $studentsTallyResult->execute();
                    $stNumTotal = $studentsTallyResult->rowCount();
                    
                    // find the possiable number of session there are so far for that module 
                    $possibleAttendanceQuery  = "SELECT * FROM attendance INNER JOIN sessions ON sessions.session_id = attendance.session_id "
                            . "WHERE sessions.module_id = $module AND attendance.student_id= $studentID"; 
                    $possibleAttendanceResult = $this->db->prepare($possibleAttendanceQuery);
                    $possibleAttendanceResult->execute();  
                    $paNumTotal = $possibleAttendanceResult->rowCount();
                    
                     // stops Division by 0 Zero Error
                     if($stNumTotal != 0 && $paNumTotal !=0){
                         
                         // Sum up Total Sessions with how many Student Attended
                        $attendance = ($stNumTotal / $paNumTotal ) * 100;
                            // module name has to be declared out here for multiple use

                                $modAttendOverviewQuery = "SELECT sessions.session_id, attendance.attended, modules.module_name FROM attendance "
                                        . " INNER JOIN sessions ON sessions.session_id = attendance.session_id "
                                        . " INNER JOIN modules ON modules.module_id = sessions.module_id "
                                        . " WHERE sessions.module_id = $module AND attendance.student_id=$studentID";
                                  $modAttendOverviewResult = $this->db->prepare($modAttendOverviewQuery) ;
                                  $modAttendOverviewResult->execute();

                                // Table that shows all the sessions 
                                 print ("<table id='studentModAttend' border='3'>");
                                            print ("<tr>");
                                            print ("<th> session_id </th>");
                                            print ("<th> Module Name </th>");
                                            print ("<th> Attended </th>");
                                    print ("</tr>");
                                    
                                    
                            while($row = $modAttendOverviewResult->fetch()) {
     
                                print ("<tr>");
                                    print ("<td> $row[session_id]</td>");
                                    print ("<td> $row[module_name] </td>");
                                    print ("<td> $row[attended] </td>");
                                print ("</tr>");
   
                            print ("</table");
                             }
                             
                                  print ("<br>");
                   
                                    // module overall Table
                                    print ("<table id='studentModAttend' border='2'>");
                                   
                                    print("<tr>");
                                          print ("<th>Module Grand Total Attendance</th>"); 
                                    print ("</tr>"); 

                                    print("<tr>");
                                          print (" <td> $attendance % </td>");
                                    print ("</tr>");        

                                    print ("</table>");           
                    
                     }else{
                             $moduleNameResult = $this->db->prepare( "SELECT module_name FROM modules WHERE module_id = $module LIMIT 1");
                             $moduleNameResult->execute();
                             $moduleName = $moduleNameResult->fetchColumn(0);                      
                        print  ("<table id='studentModAttend' border='2'>");
                               print ("<tr>");
                               print ("<th> $moduleName Attendance </th>") ;
                               print ("</tr>");
                               print ("<tr>");
                               print  ("<td> 0 % <td>");
                               print ("</tr>");
                        print ("</table>");        
                         
                     }                                       
                    // query to find the name of the module

                    }
                        // VIEW OVERALL ATTENDANCE PLUS MODULES ATTEDNACE SUMMERY
                 public function overallAttendanceStudent($studentID){  
                                    // what module they are doing
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
                                 // UPDATE THE STUDENTS ATTENDANCE ON THE STUDENT ATTENDANCE TABLE   
                                 $updateStudentOverallAttendanceQuery = "UPDATE student_attendance SET overall='$attendance' WHERE student_id=$studentID ";
                                 $updateStudentOverallResult = $this->db->prepare($updateStudentOverallAttendanceQuery);
                                 $updateStudentOverallResult->execute();
                       }
                 
                       
                       public function loadStudentTimetable($studentID){
                           
                            $studentTimetableQuery = "SELECT sessions.session_id, sessions.session_date, sessions.session_start_time, sessions.session_end_time, "
                                    . " modules.module_name, groups.group_name, classes.class_type, rooms.room_name "
                                    . " FROM attendance "
                                    . " INNER JOIN sessions ON sessions.session_id = attendance.session_id "
                                    . " INNER JOIN modules ON  modules.module_id = sessions.module_id "
                                    . " INNER JOIN classes ON classes.class_id = sessions.class_id "
                                    . " INNER JOIN groups ON groups.group_id = sessions.group_id "
                                    . " INNER JOIN rooms ON rooms.room_id = sessions.room_id "
                                    . " WHERE attendance.student_id=$studentID AND sessions.status !='PAST' " ;
                            
                            $studentTimetableResult = $this->db->prepare($studentTimetableQuery);
                            $studentTimetableResult->execute(); 
                            
                            while( $row = $studentTimetableResult->fetch() ){
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

