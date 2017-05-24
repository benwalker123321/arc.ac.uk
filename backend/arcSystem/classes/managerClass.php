<?php

class manager{
  private $db;

    function __construct($DB_con){
        
        $this->db = $DB_con;
        
    }
                    public function redirect($url){
                                header("Location: $url");

                    }
                            // CREATE STAFF ACCOUNT
                            public function registerStaff($userID,$SID,$staffID,$userName,$fullName,$email,$userPassword,$userRole){
                                        
                                try{
                                   $addStaffUserQuery = "INSERT INTO users VALUES('" .$userID."' , '".$SID."','".$staffID."','".$userName."','".$userPassword."')"; 
                                   $addStaffUserResult = $this->db->prepare($addStaffUserQuery);
                                   $addStaffUserResult->execute(); 

                                  if($addStaffUserResult){

                                   // inserting a new student user into the students table. 
                                              // Getting Lastest userID foor The user 
                                       
                                       $newUserIDResult= $this->db->prepare("SELECT user_id FROM users ORDER BY user_id DESC Limit 1"); // get the new userID ready for the students table
                                       $newUserIDResult->execute();
                                       
                                        $userIDnew = $newUserIDResult->fetchColumn(0);
                                        

                                           // create the student
                                           $addStaffQuery = "INSERT INTO staff VALUES ( '". $staffID ."' , '". $userIDnew ."' , '" .$fullName . "', '" . $email . "')";
                                           $addStaffResult= $this->db->prepare($addStaffQuery);
                                           $addStaffResult->execute();

                                           $newStaffIDResult = $this->db->prepare("SELECT staff_id FROM staff ORDER BY staff_id DESC LIMIT 1");
                                           $newStaffIDResult->execute();
                                               
                                           $staffIDnew = $newStaffIDResult->fetchColumn(0);
                                           
                                                    //Updating the User Details by providing the New Student ID that was created 
                                                $userUpdate = "UPDATE users SET staff_id=$staffIDnew WHERE user_id=$userIDnew";
                                                $userUpdateResult = $this->db->prepare($userUpdate);
                                                $userUpdateResult->execute();

                                                $userRoleAssign = "INSERT INTO user_role VALUES ('".$userIDnew."', '".$userRole."')";
                                                $userRoleAssignResult = $this->db->prepare($userRoleAssign);
                                                $userRoleAssignResult->execute();

                                               } else{

                                      echo "Could not add user!";
                                  }

                                   }catch(PDOException $e){

                                           echo $e->getMessage();
                                   }
                                }
                                    // CREATE A CLASS SESSION
                    public function createClassSession($sessionID,$groupID,$staffID,$roomID,$moduleID,$sessionDate,$sessionStartTime,$sessionEndTime,$classID,$status,$sessionAttendance,$info){

                                   $createClassSessionQuery = " INSERT INTO sessions VALUES('". $sessionID ."','". $groupID ."','". $staffID ."', '". $roomID ."','". $moduleID ."', '". $sessionDate ."', '". $sessionStartTime ."', '". $sessionEndTime ."', '". $classID ."', '". $status ."', '". $sessionAttendance ."', '". $info ."')";
                                   $createClassSessionResult = $this->db->prepare($createClassSessionQuery);
                                   $createClassSessionResult->execute(); 
                                   if($createClassSessionResult){
                                       echo 'Class Session Was created', "<br>";
                         
                                      }else{
                                       echo 'Class session failed to be created';
                                   }

                       }
                        // CREATE A ATTENDANCE CARD(slot)
                    public function createAttendanceCard($attendanceCardID,$studentID,$attended){     
                            $newSessionDetailsResult = $this->db->prepare("SELECT * FROM sessions ORDER BY session_id DESC LIMIT 1");
                            $newSessionDetailsResult->execute();
                            // Find the Newly created session ID a put it on the attendance card.
                               $sessionDetails = $newSessionDetailsResult->fetch();
                               $groupID = $sessionDetails[group_id];
                               $sessionID = $sessionDetails[session_id];         
                                        
                              $studentIDsResult = $this->db->prepare("SELECT student_id FROM student_groups WHERE group_id=$groupID ");
                              $studentIDsResult->execute();
                              $studentCount = $studentIDsResult->rowCount();
                              // create attendance cards base on how many students are in group replace 10 with row count result 
                              if($studentCount <= 0){
                                  //No students 
                              }else{
                                  
                              for($i = 0; $i < $studentCount; $i++ ){
                                  
                                   $studentID = $studentIDsResult->fetchColumn(0);
                                        
                                        // create the attendance card based on the variable set above   
                                   $createAttendanceCard1 = "INSERT INTO attendance (attendance_card_id,session_id,student_id,attended)"
                                           . "VALUES('" . $attendanceCardID . "', '". $sessionID ."', '".$studentID."','".$attended."')";
                                   $result1 = $this->db->prepare($createAttendanceCard1);
                                   $result1->execute();
                             
                               }
   
                              if($result1){
                                            
                                              header("Location: classManagementPage");     
                                             // stops the session and Attendance card from being created again if the page is refreshe 
                                             //redirecting clears the details 

                              }else{
                                echo "Attendance Card Not created";
                            }       

                      }
                    }
                                //CREATE STUDENT ACCOUNT
                      public function registerStudent($SID,$userID,$staffID,$userName,$fullName,$address,$email,$userPassword,$userRole){               
                     try{
                        $addUserQuery = "INSERT INTO users VALUES('" .$userID."' , '".$SID."','".$staffID."','".$userName."','".$userPassword."')"; 
                        $addUser = $this->db->prepare($addUserQuery);
                         $addUser->execute(); 

                       if($addUser){
                                
                        // inserting a new student user into the students table.               
                            $newUserID = $this->db->prepare("SELECT user_id FROM users ORDER BY user_id DESC Limit 1"); // run query
                            $newUserID->execute();                         
                            $userID = $newUserID->fetchColumn(0);
         
                                // create the student
                                $addStudentQuery = "INSERT INTO students VALUES ( '". $SID ."' , '". $userID ."' , '" .$fullName . "', '" . $address . "', '" . $email . "')";
                                $addStudent= $this->db->prepare($addStudentQuery);
                                $addStudent->execute();
                                // find the new student ID    
                                
                                $SIDquery= $this->db->prepare( "SELECT student_id FROM students ORDER BY student_id DESC Limit 1");
                                $SIDquery->execute(); 
                                
                                $SID = $SIDquery->fetchColumn(0);

                                    //Updating the User Details by providing the New Student ID that was created 
                                $userUpdate = "UPDATE users SET student_id=$SID WHERE user_id=$userID";
                                $userUpdateResult = $this->db->prepare($userUpdate);
                                $userUpdateResult->execute();
                                // gives the user the Student permissions 
                                $userRoleAssign = "INSERT INTO user_role VALUES ('".$userID."', '".$userRole."')";
                                $userRoleAssignResult = $this->db->prepare($userRoleAssign);
                                $userRoleAssignResult->execute();
                                // assign the student to an attendance record for the modules they are doing 
                                $studentAssignAttendanceRecord = "INSERT INTO student_attendance VALUES ('".$SID."','0')";
                                $studentAssignAttendanceRecordResult = $this->db->prepare($studentAssignAttendanceRecord);
                                $studentAssignAttendanceRecordResult->execute();

                                    } else{

                                        echo "Could not add user!";
                                    }

                                     // check if the student was successfully inserted in the database
                                     if ($addStudent) {
                                         echo 'The student was inserted in the database';
                                       header("Location: ../../../../../xampp/arc.ac.uk/index.php");

                                     }
                                     else {
                                         // print the error generated
                                         echo "The student was not inserted in the database:" . $this->db->error;
                                     }
                             }catch(PDOException $e){

                                     echo $e->getMessage();
                             }
                       }
                       // LOAD DEGREE TYPES
                       public function loadDegrees(){
                           $findDegreeTypes = $this->db->prepare("SELECT * FROM degrees");
                           $findDegreeTypes->execute();
                           
                           while($degree = $findDegreeTypes->fetch()){
                               echo '<option value='.$degree['degree_id'].'>'.$degree['degree_type'].'</option>';
                           }
                           
                       }
                       
                      // CREATE A NEW COURSE
                      public function addCourse($courseID,$courseName,$degreeType){                        
                          $addCourseQuery = "INSERT INTO courses VALUES('".$courseID."', '".$courseName."', '".$degreeType."'); ";
                          $addCourseResult = $this->db->prepare($addCourseQuery);
                          $addCourseResult->execute();                      
                      }
                        //CREATE A NEW MODULE
                        public function addModule($moduleID,$moduleCode,$moduleName){           
                            $addModuleQuery = "INSERT INTO modules VALUES('".$moduleID."', '".$moduleCode."', '".$moduleName."' ); ";
                            $addModuleResult = $this->db->prepare($addModuleQuery);
                            $addModuleResult->execute();       
                      }
                        // CREATE A COURSE TO MODULE RELATIONSHIP 
                       public function createCourseModuleLink($moduleID,$courseID,$year,$semTri){
                          
                            $createCMLinkQuery = "INSERT INTO course_modules VALUES('".$moduleID."', '".$courseID."','".$year."', '".$semTri."'); ";
                            $createCMLResult = $this->db->prepare($createCMLinkQuery);
                            $createCMLResult->execute();
 
                      }
                            //CREATE A CLASS GROUP
                          public function createClassGroup($groupID,$groupName,$moduleID,$staffID){
                          
                                $createClassGroupQuery = "INSERT INTO groups VALUES('".$groupID."', '".$groupName."', '".$moduleID."', '".$staffID."')"; 
                                $createClassGroupResult = $this->db->prepare($createClassGroupQuery);
                                $createClassGroupResult->execute();
                          }
                     
                            // ENROLL STUDENT TO A COURSE
                          public function addStudentToCourse($studentID,$courseID,$enrolDateTime){
                          
                          $createSCLinkQuery = "INSERT INTO student_course VALUES('".$studentID."', '".$courseID."','".$enrolDateTime."') ";
                          $createSCLResult = $this->db->prepare($createSCLinkQuery);
                          $createSCLResult->execute();

                      }
                      
                            //PLACE A STUDENT IN A CLASS GROUP
                      public function addStudentToGroup($studentID,$groupID){
                          $createSGLinkQuery = "INSERT INTO student_groups VALUES('".$studentID."', '".$groupID."') ";
                          $createSGLResult = $this->db->prepare($createSGLinkQuery);
                          $createSGLResult->execute();
                      }
                            // VIEW STUDENTS AND THE SELECTED COURSE
                          public function findStudentsOnCourse($courseID){
                          
                                $findStudentsOnCourseQuery = "SELECT student_course.student_id ,student_course.course_id, students.full_name, courses.course_name "
                                        . " FROM student_course "
                                        . " INNER JOIN students ON students.student_id = student_course.student_id " 
                                        . " INNER JOIN courses ON courses.course_id = student_course.course_id"
                                        . " WHERE student_course.course_id = $courseID";
                                $findStudentsOnCourseResult = $this->db->query($findStudentsOnCourseQuery);

                                                print ("<table id='studentsOnCourseTable' border='3'>");
                                print ("<tr>");                
                                            print ("<th> Student ID</th>");
                                            print ("<th> Full Name </th>");
                                            print ("<th>  Course ID </th>");
                                            print ("<th>  Course Name </th>");
                                print ("</tr>");                
                                                
                          while($row = $findStudentsOnCourseResult->fetch()) {
                               print ("<tr>");

                                    print ("<td> $row[student_id] </td>");
                                    print ("<td> $row[full_name] </td>");
                                    print ("<td> $row[course_id] </td>");
                                    print ("<td> $row[course_name] </td>");

                              print ("</tr>");

                          }

                          print ("</table");

                      }
                      
                                    // VIEW STUDENTS ON A CHOOSEN MODULE
                                public function findStudentsOnModule($moduleID){
                          
                                $findStudentsOnModuleQuery = " SELECT course_modules.module_id, student_course.student_id, student_course.course_id, students.full_name, modules.module_id, modules.module_name"
                                        . " FROM course_modules "
                                        . " INNER JOIN student_course ON student_course.course_id = course_modules.course_id " 
                                        . " INNER JOIN students ON students.student_id = student_course.student_id "
                                        . " INNER JOIN  modules ON modules.module_id = course_modules.module_id "
                                        . " WHERE course_modules.module_id = $moduleID ";
                                
                                $findStudentsOnModuleResult = $this->db->query($findStudentsOnModuleQuery);

                                                print ("<table id='studentsOnModuleTable'border='3'>");
                                print ("<tr>");                
                                            print ("<th> Student ID</th>");
                                            print ("<th> Full Name </th>");
                                            print ("<th>  Module ID </th>");
                                            print ("<th>  Module Name </th>");
                                print ("</tr>");                
                                                
                          while($row = $findStudentsOnModuleResult->fetch()) {
                               print ("<tr>");

                                    print ("<td> $row[student_id] </td>");
                                    print ("<td> $row[full_name] </td>");
                                    print ("<td> $row[module_id] </td>");
                                    print ("<td> $row[module_name] </td>");

                              print ("</tr>");

                          }

                          print ("</table");

                      }
                      
                            // VIEW STUDENT ON A SELECTED GROUP 
                         public function findStudentsInGroup($groupID){
                          
                                $findStudentsInGroupQuery = "SELECT student_groups.student_id ,student_groups.group_id, students.full_name, groups.group_name "
                                        . " FROM student_groups "
                                        . " INNER JOIN students ON students.student_id = student_groups.student_id " 
                                        . " LEFT JOIN groups ON groups.group_id = student_groups.group_id "
                                        . " WHERE student_groups.group_id = $groupID";
                                $findStudentsInGroupResult = $this->db->query($findStudentsInGroupQuery);

                                                print ("<table id='studentsInGroupTable'border='3'>");
                                print ("<tr>");                
                                            print ("<th> Student ID</th>");
                                            print ("<th> Full Name </th>");
                                            print ("<th>  Group ID </th>");
                                            print ("<th>  Group Name </th>");
                                print ("</tr>");                
                                                
                          while($row = $findStudentsInGroupResult->fetch()) {
                               print ("<tr>");

                                    print ("<td> $row[student_id] </td>");
                                    print ("<td> $row[full_name] </td>");
                                    print ("<td> $row[group_id] </td>");
                                    print ("<td> $row[group_name] </td>");

                              print ("</tr>");

                          }

                          print ("</table");

                      }
                            // VIEW GROUPS
                         public function searchGroups($numResults){
                                $searchGroupsQuery = "SELECT group_id, group_name FROM groups LIMIT $numResults";                                   
                                $searchGroupsResult = $this->db->query($searchGroupsQuery);

                                                print ("<table id='groupsTable' border='3'>");
                                print ("<tr>");                
                                            print ("<th>  Group ID </th>");
                                            print ("<th>  Group Name </th>");
                                print ("</tr>");                
                                              
                                            while($row = $searchGroupsResult->fetch()) {
                                                 print ("<tr>");
                                                      print ("<td> $row[group_id] </td>");
                                                      print ("<td> $row[group_name] </td>");

                                                print ("</tr>");
                                            }
                                            print ("</table");
                                        }
                      
                      
                      
                      // VIEW COURSES
                      public function viewCourses($numResults){
                          
                                $viewCoursesQuery = "SELECT courses.course_id, courses.course_name, degrees.degree_type,degrees.degree_duration "
                                        . " FROM courses "
                                        . " INNER JOIN degrees ON degrees.degree_id = courses.degree_id LIMIT $numResults";
                                $viewCoursesResult = $this->db->query($viewCoursesQuery);

                                                print ("<table id='viewCoursesTable' border='3'>");
                                print ("<tr>");  
                                            
                                            print ("<th>  Course ID </th>");
                                            print ("<th>  Course Name </th>");
                                            print ("<th>  Degree  </th>");
                                            print ("<th>  Duration  </th>");
                                            
                                print ("</tr>");                
                                                
                          while($row = $viewCoursesResult->fetch()) {
                               print ("<tr>");
                                    print ("<td> $row[course_id] </td>");
                                    print ("<td> $row[course_name] </td>");
                                    print ("<td> $row[degree_type] </td>");
                                    print ("<td> $row[degree_duration] </td>");                                    

                              print ("</tr>");
                          }

                          print ("</table");

                      }
                      
                      
                       // VIEW MODULES    
                      public function viewModules($numResults){
                          
                                $viewModulesQuery = "SELECT * FROM modules LIMIT $numResults";
                                $viewModulesResult = $this->db->query($viewModulesQuery);

                                                print ("<table id='viewModulesTable'border='3'>");
                                print ("<tr>");                
                                            print ("<th>  Module ID </th>");
                                            print ("<th>  Module Code </th>");
                                            print ("<th>  Module Name </th>");
                                print ("</tr>");                
                                                
                          while($row = $viewModulesResult->fetch()) {
                               print ("<tr>");
                                    print ("<td> $row[module_id] </td>");
                                    print ("<td> $row[module_code] </td>");
                                    print ("<td> $row[module_name] </td>");

                              print ("</tr>");
                          }

                          print ("</table");

                      }
                      
                            // VIEW A COURSES MODULES
                         public function viewCourseModules($courseID){
                          
                                $viewCourseModulesQuery = "SELECT course_modules.module_id, course_modules.year, course_modules.semester_trimester, courses.course_name, "
                                        . " modules.module_code, modules.module_name, degrees.degree_type "
                                        . " FROM course_modules"
                                        . " INNER JOIN courses ON courses.course_id = course_modules.course_id "
                                        . " INNER JOIN modules ON modules.module_id = course_modules.module_id "
                                        . " INNER JOIN degrees ON degrees.degree_id = courses.degree_id "
                                        . " WHERE course_modules.course_id = $courseID";
                                    
                                $viewCourseModulesResult = $this->db->prepare($viewCourseModulesQuery);
                                $viewCourseModulesResult->execute();
                                
                                $getCourseDetailsQuery = $this->db->prepare("SELECT * FROM courses "
                                        . " INNER JOIN Degrees ON degrees.degree_id = courses.degree_id "
                                        . " WHERE courses.course_id =$courseID");
                                $getCourseDetailsQuery->execute();
                                $courseDetails = $getCourseDetailsQuery->fetch();
                                
                                        print("<h3> $courseDetails[course_name] $courseDetails[degree_type] Degree </h3>");
                                print ("<table id='viewCourseModulesTable' border='3'>");
   
                                print ("<tr>");
                                            print ("<th>  Module ID </th>");
                                            print ("<th>  Module Code </th>");
                                            print ("<th>  Module Name </th>");
                                            print ("<th>  Year </th>");
                                            print ("<th>  Semester/Trimester </th>");
                                print ("</tr>");                
                                                
                          while($row = $viewCourseModulesResult->fetch()) {

                              print ("<tr>");
                                    print ("<td> $row[module_id] </td>");
                                    print ("<td> $row[module_code] </td>");
                                    print ("<td> $row[module_name] </td>");
                                    print ("<td> $row[year] </td>");
                                    print ("<td> $row[semester_trimester] </td>");

                              print ("</tr>");
                          }

                          print ("</table");

                      }
                        // VIEW COURSES TO RELATE TO A SELECTED MODULE
                      public function viewModulesCourses($moduleID){
                          
                                $viewModulesCoursesQuery = "SELECT course_modules.module_id, course_modules.course_id, courses.course_name, modules.module_code, modules.module_name "
                                        . " FROM course_modules"
                                        . " INNER JOIN courses ON courses.course_id = course_modules.course_id "
                                        . " INNER JOIN modules ON modules.module_id = course_modules.module_id "
                                        . " WHERE course_modules.module_id = $moduleID";
                                    
                                $viewModulesCoursesResult = $this->db->query($viewModulesCoursesQuery);
                                $viewModulesCoursesResult->execute();    
                                                print ("<table id='viewModulesCoursesTable' border='3'>");
   
                                print ("<tr>");
                                            
                                            print ("<th>  Module ID </th>");
                                            print ("<th>  Module Code </th>");
                                            print ("<th>  Module Name </th>");
                                            print ("<th>  Course Name </th>");
                                print ("</tr>");                
                                                
                          while($row = $viewModulesCoursesResult->fetch()) {

                              print ("<tr>");
                                    
                                    print ("<td> $row[module_id] </td>");
                                    print ("<td> $row[module_code] </td>");
                                    print ("<td> $row[module_name] </td>");
                                    print ("<th> $row[course_name] </th>");

                              print ("</tr>");
                          }

                          print ("</table");

                      }
                      
                      // VIEW MODULE CLASS SESSIONS(LIKE A TIMETABLE FOR THE MANAGER)
                      public function viewModuleClassSessions($moduleID,$classIDa,$classIDb,$classIDc){
                          
                          if($classIDa == 1 && $classIDb == 0 && $classIDc == 0){
                              
                              $lectureClassSessionsQuery = "SELECT * FROM sessions "
                                      . " INNER JOIN classes ON classes.class_id = sessions.class_id"
                                      . " INNER JOIN modules ON modules.module_id = sessions.module_id"
                                      . " INNER JOIN groups ON groups.group_id = sessions.group_id"
                                      . " INNER JOIN staff ON staff.staff_id = sessions.staff_id"
                                      . " INNER JOIN rooms ON rooms.room_id = sessions.room_id "
                                      . " WHERE sessions.module_id=$moduleID AND sessions.class_id=$classIDa ";
                              
                                  $lectureClassSessionsResult = $this->db->query($lectureClassSessionsQuery);

                                                print ("<table id='moduleClassSessionsTable' border='3'>");
   
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
                                                
                          while($row = $lectureClassSessionsResult->fetch()) {

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
                              
      
                              
                          } else if($classIDa == 2 && $classIDb == 0 && $classIDc == 0){
                              
                                $lectureClassSessionsQuery = "SELECT * FROM sessions "
                                      . " INNER JOIN classes ON classes.class_id = sessions.class_id"
                                      . " INNER JOIN modules ON modules.module_id = sessions.module_id"
                                      . " INNER JOIN groups ON groups.group_id = sessions.group_id"
                                      . " INNER JOIN staff ON staff.staff_id = sessions.staff_id"
                                      . " INNER JOIN rooms ON rooms.room_id = sessions.room_id "
                                      . " WHERE sessions.module_id=$moduleID AND sessions.class_id=$classIDa ";
                              
                                  $lectureClassSessionsResult = $this->db->query($lectureClassSessionsQuery);

                                                print ("<table id='moduleClassSessionsTable' border='3'>");
   
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
                                                
                          while($row = $lectureClassSessionsResult->fetch()) {

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
                              
                          }else if($classIDa == 3 && $classIDb == 0 && $classIDc == 0){
                              
                                $lectureClassSessionsQuery = "SELECT * FROM sessions "
                                      . " INNER JOIN classes ON classes.class_id = sessions.class_id"
                                      . " INNER JOIN modules ON modules.module_id = sessions.module_id"
                                      . " INNER JOIN groups ON groups.group_id = sessions.group_id"
                                      . " INNER JOIN staff ON staff.staff_id = sessions.staff_id"
                                      . " INNER JOIN rooms ON rooms.room_id = sessions.room_id "
                                      . " WHERE sessions.module_id=$moduleID AND sessions.class_id=$classIDa ";
                              
                                  $lectureClassSessionsResult = $this->db->query($lectureClassSessionsQuery);

                                                print ("<table id='moduleClassSessionsTable' border='3'>");
   
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
                                                
                          while($row = $lectureClassSessionsResult->fetch()) {

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
                              
                              
                          }else if($classIDa == 1 && $classIDb == 2 && $classIDc == 0 ){
                              echo "This Works";
                                $lectureClassSessionsQuery = "SELECT * FROM sessions "
                                      . " INNER JOIN classes ON classes.class_id = sessions.class_id"
                                      . " INNER JOIN modules ON modules.module_id = sessions.module_id"
                                      . " INNER JOIN groups ON groups.group_id = sessions.group_id"
                                      . " INNER JOIN staff ON staff.staff_id = sessions.staff_id"
                                      . " INNER JOIN rooms ON rooms.room_id = sessions.room_id "
                                      . " WHERE sessions.module_id=$moduleID AND sessions.class_id IN ($classIDa,$classIDb) ";
                              
                                  $lectureClassSessionsResult = $this->db->query($lectureClassSessionsQuery);

                                                print ("<table id='moduleClassSessionsTable' border='3'>");
   
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
                                                
                          while($row = $lectureClassSessionsResult->fetch()) {

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
                              
                          } else if($classIDa == 1 && $classIDb == 3 && $classIDc == 0){
                              
                                $lectureClassSessionsQuery = "SELECT * FROM sessions "
                                      . " INNER JOIN classes ON classes.class_id = sessions.class_id"
                                      . " INNER JOIN modules ON modules.module_id = sessions.module_id"
                                      . " INNER JOIN groups ON groups.group_id = sessions.group_id"
                                      . " INNER JOIN staff ON staff.staff_id = sessions.staff_id"
                                      . " INNER JOIN rooms ON rooms.room_id = sessions.room_id "
                                      . " WHERE sessions.module_id=$moduleID AND sessions.class_id IN ($classIDa,$classIDb)";
                              
                                  $lectureClassSessionsResult = $this->db->query($lectureClassSessionsQuery);

                                                print ("<table id='moduleClassSessionsTable' border='3'>");
   
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
                                                
                          while($row = $lectureClassSessionsResult->fetch()) {

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
                              
                              
                          } else if($classIDa == 2 && $classIDb == 3 && $classIDc == 0){
                              
                                $lectureClassSessionsQuery = "SELECT * FROM sessions "
                                      . " INNER JOIN classes ON classes.class_id = sessions.class_id"
                                      . " INNER JOIN modules ON modules.module_id = sessions.module_id"
                                      . " INNER JOIN groups ON groups.group_id = sessions.group_id"
                                      . " INNER JOIN staff ON staff.staff_id = sessions.staff_id"
                                      . " INNER JOIN rooms ON rooms.room_id = sessions.room_id "
                                      . " WHERE sessions.module_id=$moduleID AND sessions.class_id IN ($classIDa,$classIDb)";
                              
                                  $lectureClassSessionsResult = $this->db->query($lectureClassSessionsQuery);

                                                print ("<table id='moduleClassSessionsTable' border='3'>");
   
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
                                                
                          while($row = $lectureClassSessionsResult->fetch()) {

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
                              
                          } else if($classIDa == 1 && $classIDb == 2 && $classIDc == 3){
                              
                                $lectureClassSessionsQuery = "SELECT * FROM sessions "
                                      . " INNER JOIN classes ON classes.class_id = sessions.class_id"
                                      . " INNER JOIN modules ON modules.module_id = sessions.module_id"
                                      . " INNER JOIN groups ON groups.group_id = sessions.group_id"
                                      . " INNER JOIN staff ON staff.staff_id = sessions.staff_id"
                                      . " INNER JOIN rooms ON rooms.room_id = sessions.room_id "
                                      . " WHERE sessions.module_id=$moduleID AND sessions.class_id IN ($classIDa,$classIDb,$classIDc) ";
                              
                                  $lectureClassSessionsResult = $this->db->query($lectureClassSessionsQuery);

                                                print ("<table id='moduleClassSessionsTable' border='3'>");
   
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
                                                
                          while($row = $lectureClassSessionsResult->fetch()) {

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
                          
                      }
                      
                        // VIEW OVERALL CLASS TYPE ATTENDANCE BY MODULE 
                      public function viewModuleSessionsAttendance($moduleID,$classID){
                        // aSMLATallyQuery = all Students Module Lecture Attendance Tally Query      
                    $aSMLATallyQuery = "SELECT * FROM attendance "
                            . " INNER JOIN sessions ON sessions.session_id = attendance.session_id "
                            . " WHERE sessions.module_id = $moduleID AND sessions.class_id=$classID AND attendance.attended IN ('YES','TBD') ";
                    $aSMLATallyResult = $this->db->prepare($aSMLATallyQuery) ;
                    $aSMLATallyResult->execute();
                    // find the possiable number of session there are so far for that module 
                    // pMLAttendanceQuery = Possiable Module Lecture Attendance Query
                    $pMLAttendanceQuery  = "SELECT * FROM attendance "
                            . " INNER JOIN sessions ON sessions.session_id = attendance.session_id "
                            . " WHERE sessions.module_id = $moduleID AND sessions.class_id=$classID"; 
                    $pMLAttendanceResult = $this->db->prepare($pMLAttendanceQuery);
                    $pMLAttendanceResult->execute();
                    
                     // count the rows    
                     $pMLANumTotal = $pMLAttendanceResult->rowCount();
                     $aSMLANumTotal = $aSMLATallyResult->rowCount();
                    
                     // stops Division by 0 Zero Error
                     if($aSMLANumTotal != 0 && $pMLANumTotal !=0){
                         
                         // Sum up Total Sessions with how many Student Attended
                        $overallModuleLectureAttendance = ($aSMLANumTotal / $pMLANumTotal ) * 100;
                        
                    
                          $moduleNameQuery = "SELECT module_name FROM modules WHERE module_id = $moduleID LIMIT 1";
                          $moduleNameResult = $this->db->prepare($moduleNameQuery);
                          $moduleNameResult->execute();
                          
                            // Find the Name of the Module to place on Table
                                $moduleName = $moduleNameResult->fetchColumn(0);

                                  print ("<br>");
                   
                                    // module overall Table
                                    print ("<table id='modOverallTable' border='2'>");
                                    print("<tr>");
                                          print ("<th>Module </th>"); 
                                          print ("<th>Overall Attendance </th>"); 
                                          print ("<th> Statues </th>"); 
                                    print ("</tr>"); 

                                    print("<tr>");
                                          print (" <td> $moduleName </td>");  
                                          print (" <td> $overallModuleLectureAttendance % </td>");
                                          if($overallModuleLectureAttendance < 70){
                                              print (" <td> WARNING VERY LOW ATTENDANCE </td>");
                                        }else{
                                               print (" <td> HIGH ATTENDANCE</td>");
                                        }
                                    print ("</tr>"); 
                                                                        
                                    print ("</table>");            
                   
                    
                     }else{
                           
                            $moduleNameResult = $this->db->prepare( "SELECT module_name FROM modules WHERE module_id = $moduleID LIMIT 1");
                            $moduleNameResult->execute();
                            // Find the Newly created session ID a put it on the attendance card.
                                $moduleName = $moduleNameResult->fetchColumn(0);
                                        
                                print ("<table id='modOverallTable' border='2'>");      
                                print ("<tr>");
                                print("<th> $moduleName, 'Attendance' </th>");
                                print ("</tr>");
                               
                                print ("<tr>");
                              
                                print ("<td>0%</td>");
                                
                                print("</tr>");
                                print ("</table>");                         
                     }
     
                          
}
                            // VIEW POORLY ATTENDED LECTURES
                        public function viewPoorLectureSessions(){

                              $poorlyAttendedLecturesQuery = "SELECT * FROM sessions "
                                      . " INNER JOIN classes ON classes.class_id = sessions.class_id"
                                      . " INNER JOIN modules ON modules.module_id = sessions.module_id"
                                      . " INNER JOIN groups ON groups.group_id = sessions.group_id"
                                      . " INNER JOIN staff ON staff.staff_id = sessions.staff_id"
                                      . " INNER JOIN rooms ON rooms.room_id = sessions.room_id "
                                      . " WHERE sessions.status='PAST' AND sessions.attendance < 70 AND sessions.information='POOR ATTENDANCE' AND sessions.class_id=1 ";
                              
                                  $poorlyAttendedLecturesResult = $this->db->prepare($poorlyAttendedLecturesQuery);
                                  $poorlyAttendedLecturesResult->execute();               
                                                print ("<table id='poorlyAttendedLecturesTable' border='2'>");
                                    print ("<h3> Poorly Attended Lectures! </h3>" );   
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
                                                
                          while($row = $poorlyAttendedLecturesResult->fetch()) {

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
                                // VIEW STUDENTS WITH OVERALL POOR ATTENDANCE 
                               public function viewStudentsWithPoorAttendance(){

                              $poorAttendanceStudentsQuery = "SELECT * FROM student_attendance "
                                      . " INNER JOIN students ON students.student_id = student_attendance.student_id"
                                      . " WHERE overall < 70";
                              
                                  $poorAttendanceStudentsResult = $this->db->prepare($poorAttendanceStudentsQuery);
                                  $poorAttendanceStudentsResult->execute();

                                                print ("<h3> Students With Poor Attendance </h3>" );
                                                print ("<table id='stuPoorAttendanceTable' border='2'");
   
                                print ("<tr>");
                                            print ("<th>  Student ID </th>");
                                            print ("<th>  Student Name </th>");
                                            print ("<th>  Overall </th>");
                                           
                                print ("</tr>");                
                                                
                          while($row =  $poorAttendanceStudentsResult->fetch()) {

                              print ("<tr>");
                                    
                                    print ("<td> $row[student_id] </td>");
                                    print ("<td> $row[full_name] </td>");
                                    print ("<td> $row[overall] </td>");                                  
                              print ("</tr>");
                          }
                          print ("</table");
                 
                        }  
                            // CHECK A ROOMS USAGE FROM A PAST CLASS SESSION 
                        public function checkRoomUsage($roomID, $sessionID){
                                   // getting the size of the room how many student it can take.  
                                $checkRoom = $this->db->prepare("SELECT * FROM rooms WHERE room_id= $roomID LIMIT 1");
                                $checkRoom->execute();
                                $roomInfo = $checkRoom->fetch();
                                // gettin ght enumber of student that attended the session
                            $sessionAttendanceTallyQuery = " SELECT * FROM attendance WHERE session_id=$sessionID AND attended='YES' ";
                            $sessionAttendanceTallyResult = $this->db->prepare($sessionAttendanceTallyQuery);
                            $sessionAttendanceTallyResult->execute();
                            
                           $sessionNumTally = $sessionAttendanceTallyResult->rowCount(); 
                                
                               if($sessionNumTally != 0 && $roomInfo['room_size'] != 0){
                                   // the room usage 
                               
                                   $roomUsage = ($sessionNumTally / $roomInfo['room_size'])  * 100 ;
                                 
                               print  "<table id='roomUsageTable' border='2'>";
                               print "<tr>";
                               print "<th> $roomInfo[room_name] </th>";
                               print "</tr>";
                               print "<tr>";
                               print "<td>$roomUsage% "; 
                               print "</tr>";
                               }else{
                                   $roomUsage = 0;
                                    print  "<table id='roomUsageTable' border='2'>";
                                    print "<tr>";
                                    print "<th> $roomInfo[room_name] </th>";
                                    print "</tr>";
                                    print "<tr>";
                                    print "<td>$roomUsage% "; 
                                    print "</tr>";
 
                               }
                        }
                            //UPDATE ALL STUDENTS OVERALL ATTENDANCE 
                            public function updateStudentAttendance(){
                                    //search all students                                   
                                    $searchAllStudentsQuery = "SELECT student_id FROM students";
                                    $searchAllStudentsResult = $this->db->prepare($searchAllStudentsQuery);
                                    $searchAllStudentsResult->execute();
                                    
                                    while($studentID = $searchAllStudentsResult->fetchColumn()){
              
                                            // this will give the students OVERALL attendance and Update the students Overall Attendance field in the student_attendance table
                                             $studentsTallyQuery = "SELECT * FROM attendance "
                                                     . "INNER JOIN sessions ON sessions.session_id = attendance.session_id "
                                                     . "WHERE  attendance.student_id=$studentID AND attendance.attended IN ('YES','TBD') ";
                                             $studentsTallyResult = $this->db->prepare($studentsTallyQuery) ;
                                             $studentsTallyResult->execute();
                                             $stNumTotal = $studentsTallyResult->rowCount();

                                             $possibleAttendanceQuery = "SELECT * FROM attendance "
                                                     . "INNER JOIN sessions ON sessions.session_id = attendance.session_id "
                                                     . "WHERE attendance.student_id= $studentID";
                                             $possibleAttendanceResult = $this->db->prepare($possibleAttendanceQuery);      
                                             $possibleAttendanceResult->execute();
                                             $paNumTotal = $possibleAttendanceResult->rowCount();
           
                                    if($stNumTotal != 0 && $paNumTotal != 0){

                                        $attendance = ($stNumTotal / $paNumTotal) * 100;

                                         $updateStudentOverallAttendanceQuery = "UPDATE student_attendance SET overall='$attendance' WHERE student_id=$studentID ";
                                         $updateStudentOverallResult = $this->db->prepare($updateStudentOverallAttendanceQuery);
                                         $updateStudentOverallResult->execute();
                              
                                    }else{
                                        
                                        $attendance = 0;
                                    }                         
                            }
                         } 
                                // CHANGE ATTENDANCE STATUS FOR A STUDENT
                                public function changeStudentAttendanceStatus($studentID,$sessionID, $attendanceStatus){
                                    
                                    $updateStudentAttendanceStatusQuery = "UPDATE attendance SET attended='$attendanceStatus' WHERE session_id =$sessionID AND student_id=$studentID ";
                                    $updateStudentAttendanceStatusResult = $this->db->prepare($updateStudentAttendanceStatusQuery);
                                    $updateStudentAttendanceStatusResult->execute(); 

                                }
                                
                                
                             public function viewUpdateStudentAttendance($studentID){
                          
                              $stuModIDQuery = "SELECT course_modules.module_id, modules.module_name "
                                            . " FROM student_course "
                                            . "  INNER JOIN course_modules on course_modules.course_id = student_course.course_id"
                                            . "  INNER JOIN modules ON modules.module_id = course_modules.module_id "
                                            . " WHERE student_id = $studentID ";    
                                   $stuModIDResult = $this->db->query($stuModIDQuery);
                                   $stuModIDResult->execute();                                   
                                   
                                      // this loop will now caluate the attendance for each module and give an overall %  
                                   print ("<br>");
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
                                
                                
                                
                         
                       }
                            
