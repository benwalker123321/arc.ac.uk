        <?php

                        // VIEW ALL UNIVERSITY COURSES
                      if(isset($_POST['viewCourses'])){
                           echo  "<style> form#viewCoursesForm{                 
                                             display:inline;
                                       }</style> "; 

                            $numResults = trim(filter_input(INPUT_POST,'numResults'));

                            if(!$numResults){

                              echo "<br>";     
                               echo "<p id='message'>Enter a Number!</p>";

                            } else{

                                   if($user->viewCourses($numResults)){}
                                    

                                }     
                             }
                             
                                    // VIEW ALL UNIVERSITY MODULES
                                   if(isset($_POST['viewModules'])){
                                    echo  "<style> form#viewModulesForm{                 
                                             display:inline;
                                       }</style> ";      
                            $numResults = trim(filter_input(INPUT_POST,'numResults'));

                            if(!$numResults){

                                echo "<br>";     
                               echo "<p id='message'> Enter a Number!</p>";

                            } else{

                                   if($user->viewModules($numResults)){}   

                                }     
                             }

                              // VIEW COURSES AND THEIR MODULES
                              if(isset($_POST['viewCoursesModules'])){
                                     echo  "<style> form#viewCourseModulesForm{                 
                                             display:inline;
                                       }</style> "; 
                                    $courseID = trim(filter_input(INPUT_POST,'courseID'));

                                    if(!$courseID){

                                       echo "<br>";     
                                               echo "<p id='message'>Enter A Course ID!</p>";
                                    }else{

                                 try{

                                    $checkCourseExistsQuery = $DB_con->prepare("SELECT course_id FROM courses WHERE course_id=:courseID");
                                    $checkCourseExistsQuery->execute(array(':courseID'=> $courseID));
                                    $CErow=$checkCourseExistsQuery->fetch(PDO::FETCH_ASSOC);

                                    if($CErow['course_id'] == $courseID){
                                       echo "<br>";     
                                        echo "<p id='message'>This Course exists </p>";
                                        if($user->viewCourseModules($courseID)){}

                                        
                                        
                                    }else if($CRErow['course_id'] != $courseID) { 
                                        echo "<br>";     
                                             echo "<p id='message'>The Course ID you entered does not exist</p>";

                                        }

                                    }  
                                catch(PDOException $e){

                                    echo $e->getMessage();

                                }

                    }

                }       

                        // VIEW COURSES THART FEATURE THE SELECTED MODULE
                        if(isset($_POST['viewModulesCourses'])){
                                     echo  "<style> form#viewModulesCoursesForm{                 
                                             display:inline;
                                       }</style> "; 

                                    $moduleID = trim(filter_input(INPUT_POST,'moduleID'));

                                    if(!$moduleID){

                                      echo "<br>";     
                                             echo "<p id='message'>Enter A Module ID!</p>";
                                    }else{

                                 try{

                                    $checkModuleExistsQuery = $DB_con->prepare("SELECT module_id FROM modules WHERE module_id=:moduleID");
                                    $checkModuleExistsQuery->execute(array(':moduleID'=> $moduleID));
                                    $MErow=$checkModuleExistsQuery->fetch(PDO::FETCH_ASSOC);

                                    if($MErow['module_id'] == $moduleID){
                                        echo "<br>";     
                                         echo "<p id='message'>This module exists</p>";
                                        if($user->viewModulesCourses($moduleID)){}

                                    }else if($MErow['module_id'] != $moduleID) { 
                                        echo "<br>";     
                                          echo "<p id='message'>The Module ID you entered does not exist </p>";

                                        }

                                    }  
                                catch(PDOException $e){

                                    echo $e->getMessage();

                                }

                    }

                }       