<?php
// USER CLASS
class user{
    
            private $db;

            function __construct($DB_con){

                $this->db = $DB_con;

            } 
                // LOGIN FUNCTION 
            public function login($userName,$password){
            echo "<br /> in login function <br />";
                        try{
                                //CHECKING USERNAME EXISTS
                        $checkUser = $this->db->prepare("SELECT * FROM users WHERE user_name='".$userName."' AND password='".md5($password)."'");
                        $checkUser->execute(); 
                        $userRow=$checkUser->fetch(PDO::FETCH_ASSOC);
                        if($checkUser->rowCount() > 0){
                            echo "found............................";
                                // CHECK PASSWORD MATCHES VALID USERNAME
                            if(md5($password) == $userRow['password']){
                                    // CREATE USER SESSION ID
                                $_SESSION['user_session'] = $userRow['user_name'];                              
                                return true;

                            }
                            else{
                                    return false;
                                    }

                             }
                        }
                        catch(PDOException $e){
                             echo $e->getMessage();
                 }
              }



                   public function is_loggedin(){
                                    // CREATE USER SESSION
                                 if(isset($_SESSION['user_session'])){
                                     return true; 
                                 }
                     }



                   public function redirect($url){
                                    header("Location: $url");
                                 }
                                    // LOGOUT FUNCTION 
                   public function logout(){
                                     session_destroy();
                                     unset($_SESSION['user_session']);
                                     return true;
                             }
                             
                             
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
                             
                             

               }
