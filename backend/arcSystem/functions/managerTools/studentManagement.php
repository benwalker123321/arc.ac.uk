<?php
         // Register Student
                        if(isset($_POST['submitNewStudentBtn'])){
                            
                                 echo  "<style> form#studentRegisterForm{                 
                                             display:inline;
                                       }</style> ";                                   
                            $SID = "";
                            $staffID = 0;
                            $userRole = "1";
                            $userID= "";
                            $userName = trim(filter_input(INPUT_POST,'userName'));
                            $fullName = trim(filter_input(INPUT_POST,'fullName'));
                            $address = trim(filter_input(INPUT_POST,'address'));
                            $email = trim(filter_input(INPUT_POST,'email'));
                            $userPassword = trim(filter_input(INPUT_POST,'userPassword'));
                            $confirmUserPassword = trim(filter_input(INPUT_POST,'confirmUserPassword'));
  
            // check that boxes have been filled in 
            if( !$userName || !$fullName || !$address ||!$email ||!$userPassword ||!$confirmUserPassword ) {
                echo '<br>';
                echo '<p id="message">One or more fields are empty.</p>';
                return;
            } else{
                
                try{
                    $checkUserName = $DB_con->prepare("SELECT user_name FROM users WHERE user_name=:userName");
                    $checkUserName->execute(array(':userName'=> $userName));
                    $row=$checkUserName->fetch(PDO::FETCH_ASSOC);
                    
                    if($row['user_name'] == $userName){
                       echo '<br>';
                       echo '<p id="message">This User Name is already taken</p>';
                        
                    }else{      
                                    if( $userPassword != $confirmUserPassword){ // check password match

                            echo '<br>';
                            echo '<p id="message">Passwords do not match!</p>';

                            return; 
                        }
                        else {
                            // escape special characters in a string for use in the SQL statement 
                            $userPassword = md5($userPassword);
                       } 
                            if($manager->registerStudent($SID,$userID,$staffID,$userName,$fullName,$address,$email,$userPassword,$userRole)){

                                   $manager->redirect('home.php');

                              }

                           }  
                        }catch(PDOException $e){

                            echo $e->getMessage();

                        }
                    }
                 }

            // ADD STUDENT TO COURSE
        if(isset($_POST['addStudentCourse'])){
                                       echo  "<style> form#addStudentToCourseForm{                 
                                                     display:inline;
                                             }</style> ";    

                    $studentID= trim(filter_input(INPUT_POST,'studentID'));
                    $courseID = trim(filter_input(INPUT_POST,'courseID'));
                    $enrolDateTime= date("Y-m-d H:i:s");   
                    if(!$studentID || !$courseID){
                         echo '<br>';   
                         echo '<p id="message">Fill in all fields!</p>';
                    } else{


                        $checkStudentIDQuery = $DB_con->prepare("SELECT student_id FROM students WHERE student_id=:studentID");
                        $checkStudentIDQuery->execute(array(':studentID'=> $studentID));
                        $SIDrow=$checkStudentIDQuery->fetch(PDO::FETCH_ASSOC);

                        $checkCourseIDQuery = $DB_con->prepare("SELECT course_id FROM courses WHERE course_id=:courseID");
                        $checkCourseIDQuery->execute(array(':courseID'=> $courseID));
                        $CIDrow=$checkCourseIDQuery->fetch(PDO::FETCH_ASSOC);

                        if($SIDrow['student_id'] != $studentID || $CIDrow['course_id'] != $courseID){
                           echo '<br>';
                           echo '<p id="message">The details you have entered do not match the database</p>';

                        }else{
                                        // CHECKING TO SEE IF STUDENT EXISTS ON COURSE ALREADY
                                        $checkStuCourseExistsQuery = $DB_con->prepare("SELECT student_id,course_id FROM student_course WHERE student_id=:studentID AND course_id=:courseID");
                                        $checkStuCourseExistsQuery->execute(array(':studentID'=> $studentID, ':courseID' => $courseID));
                                        $SCErow=$checkStuCourseExistsQuery->fetch(PDO::FETCH_ASSOC);

                                        if($SCErow['student_id'] != $studentID && $SCErow['course_id'] != $courseID ){
                                            
                                           if($manager->addStudentToCourse($studentID,$courseID,$enrolDateTime)){}

                                        }else{
                                                 echo '<br>';
                                                 echo '<p id="message">The Student is already enrolled onto this course</p>';
                                             }

                         }

            }
        }
                     // ADD STUDENT TO GROUP
                    if(isset($_POST['addStudentGroup'])){
                                       echo  "<style> form#addStudentToGroupForm{                 
                                             display:inline;
                                       }</style> ";       
                             $studentID= trim(filter_input(INPUT_POST,'studentID'));
                             $groupID =trim(filter_input(INPUT_POST,'groupID'));

                             if(!$studentID || !$groupID){

                                  echo '<br>';
                                   echo '<p id="message">Fill in all fields!</p>';
                             } else{


                                 $checkStudentIDQuery = $DB_con->prepare("SELECT student_id FROM students WHERE student_id=:studentID");
                                 $checkStudentIDQuery->execute(array(':studentID'=> $studentID));
                                 $SIDrow=$checkStudentIDQuery->fetch(PDO::FETCH_ASSOC);

                                 $checkgroupIDQuery = $DB_con->prepare("SELECT group_id FROM groups WHERE group_id=:groupID");
                                 $checkgroupIDQuery->execute(array(':groupID'=> $groupID));
                                 $GIDrow=$checkgroupIDQuery->fetch(PDO::FETCH_ASSOC);

                                 if($SIDrow['student_id'] != $studentID || $GIDrow['group_id'] != $groupID){

                                    echo '<br>';
                                       echo '<p id="message">The details you have entered do not match the database</p>';
                                 }else{
                                                    // CHECKING TO SEE IF STUDENT IS ALREADY IN SELECTED GROUP
                                                 $checkStuGroupExistsQuery = $DB_con->prepare("SELECT student_id,group_id FROM student_groups WHERE student_id=:studentID AND group_id=:groupID");
                                                 $checkStuGroupExistsQuery->execute(array(':studentID'=> $studentID, ':groupID' => $groupID));
                                                 $SGErow=$checkStuGroupExistsQuery->fetch(PDO::FETCH_ASSOC);

                                                 if($SGErow['student_id'] != $studentID && $SGErow['group_id'] != $groupID ){

                                                      if($manager->addStudentToGroup($studentID,$groupID)){

                                                             $manager->addStudentToGroup();

                                                      } 
                                                 }else{

                                                          echo '<br>';
                                                          echo '<p id="message">The Student already belongs to this group!</p>';
                                                      }

                                           }
                                 }

                             }

                             // FIND STUDENTS COURSES
                            if(isset($_POST['findStudentCourse'])){
                                       echo  "<style> form#findStudentOnCourseForm{                 
                                             display:inline;
                                       }</style> ";         
                          $courseID = trim(filter_input(INPUT_POST,'courseID'));

                          if(!$courseID){

                               echo '<br>';
                                 echo '<p id="message">Enter a Course ID!</p>';

                          } else{

                              $checkCourseIDQuery = $DB_con->prepare("SELECT course_id FROM courses WHERE course_id=:courseID");
                              $checkCourseIDQuery->execute(array(':courseID'=> $courseID));
                              $CIDrow=$checkCourseIDQuery->fetch(PDO::FETCH_ASSOC);

                              if($CIDrow['course_id'] != $courseID){

                                 echo '<br>';
                                     echo '<p id="message">The details you have entered do not match the database</p>';

                              }else {
                                  if($manager->findStudentsOnCourse($courseID)){   

                                      $manager->findStudentsOnCourse(); 

                                  } else{
                                      echo "<br>";
                                        echo "<p id='message'>ERROR!</p>";

                                  }
                              }     

                              }
                            }

                               
                         if(isset($_POST['findStudentModule'])){
                                           // FIND STUDENT MODULE
                                      echo  "<style> form#findStudentOnModuleForm{                 
                                             display:inline;
                                       }</style> ";  
                          $moduleID =trim(filter_input(INPUT_POST,'moduleID'));

                          if(!$moduleID){

                               echo '<br>';
                                 echo '<p id="message">Enter a module ID!</p>';

                          } else{

                              $checkmoduleIDQuery = $DB_con->prepare("SELECT module_id FROM modules WHERE module_id=:moduleID");
                              $checkmoduleIDQuery->execute(array(':moduleID'=> $moduleID));
                              $MIDrow=$checkmoduleIDQuery->fetch(PDO::FETCH_ASSOC);

                              if($MIDrow['module_id'] != $moduleID){

                                 echo '<br>';
                                  echo '<p id="message">The details you have entered do not match the database</p>';

                              }else {
                                  if($manager->findStudentsOnModule($moduleID)){   

                                      $manager->findStudentsOnModule(); 

                                  } else{
                                       echo "<br>";
                                        echo "<p id='message'>ERROR!</p>";

                                  }
                              }     

                              }
                            }

                                //FIND STUDENT GROUP
                            if(isset($_POST['findStudentGroup'])){
                                echo  "<style> form#findStudentInGroupForm{                 
                                             display:inline;
                                       }</style> ";       
                                 $groupID = trim(filter_input(INPUT_POST,'groupID'));

                                if(!$groupID){

                                     echo '<br>';
                                          echo '<p id="message">Enter a Group ID!</p>';

                                }else{

                                    $checkGroupIDQuery = $DB_con->prepare("SELECT group_id FROM groups WHERE group_id=:groupID");
                                    $checkGroupIDQuery->execute(array(':groupID'=> $groupID));
                                    $GIDrow=$checkGroupIDQuery->fetch(PDO::FETCH_ASSOC);

                                        if($GIDrow['group_id'] != $groupID){

                                           echo '<br>';
                                            echo '<p id="message">The details you have entered do not match the database</p>';

                                        }else {
                                            if($manager->findStudentsInGroup($groupID)){   

                                                   $manager->findStudentsInGroup(); 

                                            } else{
                                                 echo "<br>";
                                                    echo "<p id='message'>ERROR!</p>";
                                            }
                                         }     

                                    }
                            }


           
           
        