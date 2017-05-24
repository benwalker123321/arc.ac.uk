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

    <title>ARC Student Management</title>
    
    
     <link href="<?=base_url()?>public/styles/main.css" type=text/css rel="stylesheet">
     <link href="<?=base_url()?>public/styles/studentManagement.css" type=text/css rel="stylesheet">
      <script src="<?=base_url()?>public/scripts/studentManagement.js"></script>
     
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
                     <li class="active"><a href="../../../../../xampp/arc.ac.uk/index.php/studentManagementPage">Student Management</a></li> 
                     <li><a href="../../../../../xampp/arc.ac.uk/index.php/staffManagementPage">Staff Management</a></li> 
                     <li><a href="../../../../../xampp/arc.ac.uk/index.php/courseManagementPage">Course Management</a></li> 
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
        <h1>ARC Student Management</h1>

               <table id="studentManagementNavTable" border="2"> 
                
                
                                  <tr>
                                     <th> Student Management</th> 
                                 </tr>
                                 
                                 <tr>
                                     <th>Add/Create</th>
                                 </tr>
                                  <tr>
                                     <td><button type="button" id="viewRegisterStudentAccountBtn" onclick="viewCreateStudentForm()"> Student Account</button> </td>
                                 </tr>
                                 
                                  <tr>
                                      <td><button type="button" id="viewAddStudentToCourseBtn" onclick="viewAddStudentToCourseForm()">Student To Course</button> </td>
                                 </tr>                                
                                     
                                   <tr>
                                        <td><button type="button" id="viewAddStudentToGroupBtn" onclick="viewAddStudentToGroupForm()"> Student to Group</button> </td>
                                     </tr>  
                                
                                  <tr>
                                     <th>Find</th>
                                  </tr> 
                                  
                                  <tr>
                                      <td><button type="button" id="viewFindStudentOnCourseBtn" onclick="viewFindStudentOnCourseForm()"> Student On Course</button> </td>
                                 </tr>
                                 
                                  <tr>
                                      <td><button type="button" id="viewFindStudentOnModuleBtn" onclick="viewFindStudentOnModuleForm()"> Student On Module</button> </td>
                                 </tr>
                                 
                                  <tr>
                                      <td><button type="button" id="viewFindStudentInGroupBtn" onclick="viewFindStudentInGroupForm()"> Student In Group</button> </td>
                                 </tr>
                         </table>
                            <center>
                <form method="post" action="" id="studentRegisterForm"> 
                                    <h3>Create Student Account</h3>
         
					 Username <br>
		 <input type="text" name="userName" > <br>
                                          Full Name <br>
		 <input type="text" name="fullName" > <br>  
                 
                                       Home Address <br>
		 <input type="text" name="address" > <br>
                                        Email Address <br>
		 <input type="email" name="email" > <br>
                 <!-- Email validation works -->
                                          Password <br>
		<input type="password" name="userPassword"> <br>
                
                		          Confirm Password <br>
		<input type="password" name="confirmUserPassword"> <br>
                
                
		<br>
		<input type="submit" name="submitNewStudentBtn" id="submitNewStudentBtn" value="Create Student Account">
		<input type="reset"  name="clear" value="Clear"> 
             
	</form>
 
             <form method="post" id="addStudentToCourseForm">
                             <h3> Add Student to Course</h3> 
                      
                                   Student ID <br>
               <input type="text" id="studentID" name="studentID"> <br>
                                   Course ID <br>
                <input type="text" id="courseID" name="courseID"> <br>
                <br>
                <input type="submit" id="addStudentCourse" name="addStudentCourse" Value="Add  Student to Course">
         
            </form>  
            
             <form method="post" id="addStudentToGroupForm">
               
                             <h3> Add Student to Group</h3>             
                                   Student ID <br>
               <input type="text" id="studentID" name="studentID"> <br>
                                   Group ID <br>
                <input type="text" id="groupID" name="groupID"> <br>
                <br>
                <input type="submit" id="addStudentGroup" name="addStudentGroup" Value="Add  Student to Group">
             
            </form> 
            
            
            <form method="post" id="findStudentOnCourseForm">
             
                             <h3> Find Student on a Course</h3>             
                                   Course ID <br>
               <input type="text" id="courseID" name="courseID"> <br>
                <br>
                <input type="submit" id="findStudentCourse" name="findStudentCourse" Value="Show Students on Course">
                
            </form> 
            
             <form method="post" id="findStudentOnModuleForm">
              
                             <h3> Find Students of a Module</h3>             
                                   Module ID <br>
               <input type="text" id="moduleID" name="moduleID"> <br>
                <br>
                <input type="submit" id="findStudentModule" name="findStudentModule" Value="Show Students on Module">
            
            </form> 
        
        <form method="post" id="findStudentInGroupForm">
            
                             <h3> Find Students in a Group</h3>             
                                   Group ID <br>
               <input type="text" id="groupID" name="groupID"> <br>
                <br>
                <input type="submit" id="findStudentGroup" name="findStudentGroup" Value="Show Students">
            </form> 
            </center>

                        <?php include_once 'backend/arcSystem/functions/managerTools/studentManagement.php';?>
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
