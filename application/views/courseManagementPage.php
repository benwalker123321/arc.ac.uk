<?php
defined('BASEPATH') OR exit('No direct script access allowed');
        include_once 'backend/arcSystem/core/dbConfig.php';
        include_once 'backend/arcSystem/functions/admin/authoriseManager.php';
         
        
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?=base_url()?>public/styles/bootstrap-3.3.6/bootstrap-3.3.6/favicon.ico">

    <title>ARC Course Management</title>
     <link href="<?=base_url()?>public/styles/main.css" type=text/css rel="stylesheet">
     <link href="<?=base_url()?>public/styles/courseManagement.css" type=text/css rel="stylesheet">
     <script src="<?=base_url()?>public/scripts/courseManagement.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="<?=base_url()?>public/styles/bootstrap-3.3.6/bootstrap-3.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?=base_url()?>public/styles/bootstrap-3.3.6/bootstrap-3.3.6/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?=base_url()?>public/styles/bootstrap-3.3.6/bootstrap-3.3.6/docs/examples/starter-template/starter-template.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="<?=base_url()?>public/styles/bootstrap-3.3.6/bootstrap-3.3.6/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="../../../../../xampp/arc.ac.uk/index.php/">ARC</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
                                <?php
                        include_once 'backend/arcSystem/functions/admin/authoriseContent.php';      
                    if($user->is_loggedin()){

                    ?> 
      
                   <?php
                   if($roleIDa == "3") {
                   ?> 
                     <li><a href="../../../../../xampp/arc.ac.uk/index.php/managementHomePage">Home</a>
                     <li><a href="../../../../../xampp/arc.ac.uk/index.php/studentManagementPage">Student Management</a></li> 
                     <li><a href="../../../../../xampp/arc.ac.uk/index.php/staffManagementPage">Staff Management</a></li> 
                     <li class="active"><a href="../../../../../xampp/arc.ac.uk/index.php/courseManagementPage">Course Management</a></li> 
                     <li><a href="../../../../../xampp/arc.ac.uk/index.php/classManagementPage">Class Management</a></li> 
                     <li><a href="../../../../../xampp/arc.ac.uk/index.php/attendanceManagementPage">Attendance Management</a></li>              
                     
                     </li> 

                     <?php
                    }
                   }
                  ?>
          </ul>
                    <?php 

                    if($user->is_loggedin()){
                        include_once 'backend/arcSystem/functions/login&register/loggedIn.php';
                        ?>
         <label id="welcomeLbl"> Welcome <?php print($userRow['user_name']); ?> </label>
         <?php   
                                echo '<br>';
                        ?>
                   <label id="logoutLbl"><a href="<?=base_url()?>../../../../../xampp/arc.ac.uk/index.php/logout?logout=true "><i class="glyphicon glyphicon-log-out"></i> Logout</a></label>
                 <?php
                    }else{
                      ?>
                      <label id="welcomeLbl">Welcome Guest</label>
                      <?php
                    }  
            ?>

           
              
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div id="content">
        <h1>ARC Course Management</h1>
  
          <table id="courseManagementNavTable" border="2">
                             
                                 
                                 <tr>
                                     <th> Course Management</th> 
                                 </tr>
                                 
                                 <tr>
                                     <th>Add/Create</th>
                                 </tr>
                                  <tr>
                                     <td><button type="button" id="addCourseBtn" onclick="viewAddCourseForm()">Course</button> </td>
                                 </tr>
                                 
                                  <tr>
                                      <td><button type="button" id="addModuleBtn" onclick="viewAddModuleForm()">Module</button> </td>
                                 </tr>
                                     <tr>
                                        <td><button type="button" id="createCourseModuleLinkBtn" onclick="viewCreateCourseModuleLinkForm()"> Module to Course Link</button> </td>
                                     </tr>
                                
                                 <tr>
                                     <th>Find</th>
                                    
                                  <tr>
                                      <td><button type="button" id="viewCoursesBtn" onclick="viewViewCoursesForm()"> Courses</button> </td>
                                 </tr>
                                 
                                  <tr>
                                      <td><button type="button" id="viewModulesBtn" onclick="viewViewModulesForm()"> Modules</button> </td>
                                 </tr>
                                 
                                  <tr>
                                      <td><button type="button" id="viewCourseModulesBtn" onclick="viewViewCourseModulesForm()"> Course Modules</button> </td>
                                 </tr>
                                 
                                  <tr>
                                      <td><button type="button" id="viewModulesCoursesBtn" onclick="viewViewModulesCoursesForm()"> Modules linked Courses</button> </td>
                                 </tr>
                                 
                                 
                                 </tr>
                             </table>
        
               <form method="post" id="addCourseForm">
                   <center>
                             <h3> Add Course</h3>             
                                   Course Name <br>
               <input type="text" id="courseName" name="courseName"> <br>
                <br>
                                    Degree Type <br>   
                <select name="degreeTypeSelect">
                    <option value=""> Select A Degree </option>
                 <?php $manager->loadDegrees(); ?>
                </select> 
                                    <br> <br>
               <input type="submit" id="addCourse" name="addCourse" Value="Add Course">
                
                </center>
            </form>  
            
                <form method="post" id="addModuleForm">
                    <center>
                             <h3> Add Module</h3>             
                                   Module Code <br>
               <input type="text" id="moduleCode" name="moduleCode" Value="MOD"> <br>
                                   Module Name <br>
                <input type="text" id="moduleName" name="moduleName">
                <br>   
                <br>
                <input type="submit" id="addModule" name="addModule" Value="Add Module">
                </center>
            </form>  
            
                <form method="post" id="createCourseModuleLinkForm">
                    <center>
                             <h3> Create Course Modules Link</h3>             
                                   Course ID<br>
               <input type="text" id="courseID" name="courseID"> <br>
                                   Module ID <br>
                <input type="text" id="moduleID" name="moduleID">
                <br>
                       Year<br>
                <select name="yearSelect">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
                <br><br>
                            Semester/Trimester<br>
                <select name="semTriSelect">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
                <br>
                <input type="submit" id="createCourseModLink" name="createCourseModLink" Value="Create Course Module Link">
                </center>
            </form>  
            
            
               <form method="post" id="viewCoursesForm">
                   <center>
                             <h3>  Show University Courses</h3>             

                                   Enter Number of results to be displayed <br>
                <input type="text" id="numResults" name="numResults"> <br>
                <br>
                
                <input type="submit" id="viewCourses" name="viewCourses" Value="View Courses">
                </center>
            </form>  
            
             <form method="post" id="viewModulesForm">
                 <center>
                             <h3>  Show University Modules</h3>             

                                   Enter Number of results to be displayed <br>
                <input type="text" id="numResults" name="numResults"> <br>
                <br>
                
                <input type="submit" id="viewModules" name="viewModules" Value="View Modules">
                </center>
            </form>  
            
            
             <form method="post" id="viewCourseModulesForm">
                     <center>       
                                <h3>  Find Course Modules</h3>             

                                        Course ID<br>
                <input type="text" id="courseID" name="courseID"> <br>
                <br>
                <input type="submit" id="viewCoursesModules" name="viewCoursesModules" Value="View Course Modules">
                    </center>
             </form>  
            
            
              <form method="post" id="viewModulesCoursesForm">
                  <center>
                             <h3>  View Courses A Module is featured on</h3>                 
                                        Module ID<br>
                <input type="text" id="moduleID" name="moduleID"> <br>
                <br>
                
                <input type="submit" id="viewModulesCourses" name="viewModulesCourses" Value="View Module Courses">
            </form>  
                 </center>
                 

       
                                 <?php
                                    include_once 'backend/arcSystem/functions/managerTools/courseManagement.php';  
                            ?>
            
      </div>
                   
      
      



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?=base_url()?>https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="<?=base_url()?>public/styles/bootstrap-3.3.6/bootstrap-3.3.6/dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?=base_url()?>public/styles/bootstrap-3.3.6/bootstrap-3.3.6/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
