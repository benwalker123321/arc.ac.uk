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

    <title>ARC Class Management</title>
     <link href="<?=base_url()?>public/styles/main.css" type=text/css rel="stylesheet">
      <link href="<?=base_url()?>public/styles/classManagement.css" type=text/css rel="stylesheet">
      
        <script src="<?=base_url()?>public/scripts/classManagement.js"></script>
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
                     <li><a href="../../../../../xampp/arc.ac.uk/index.php/courseManagementPage">Course Management</a></li> 
                     <li class="active"><a href="../../../../../xampp/arc.ac.uk/index.php/classManagementPage">Class Management</a></li> 
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

            <h1>ARC Class Management</h1>
            
                  <table id="classManagementNavTable" border="2">
                             
                                 
                                 <tr>
                                     <th> Class Management</th> 
                                 </tr>
                                 
                                 <tr>
                                     <th>Create</th>
                                 </tr>
                                  <tr>
                                     <td><button type="button" id="createClassSessionBtn" onclick="viewCreateSessions()"> Class Sessions</button> </td>
                                 </tr>
                                 
                                  <tr>
                                      <td><button type="button" id="createGroupBtn" onclick="viewCreateGroup()"> Class Groups</button> </td>
                                 </tr>
                                 
                                
                                 <tr>
                                     <th>Find</th>
                                 </tr>    
                                      <tr>
                                        <td><button type="button" id="viewGroupsBtn" onclick="viewGroupSearch()"> Groups</button> </td>
                                     </tr>
                                  <tr>
                                      <td><button type="button" id="findSessionsBtn" onclick="viewSessions()"> Sessions</button> </td>
                                 </tr>
                                
             </table>
           
            <center>
             <form method="post" id="createAClassSessionForm"  name="createAClassSessionForm">           
                    <h3> Create a Class Session</h3>
                    
                                            Group ID <br>
                    <input type="text" name="groupID" id="groupID"> </br>
                                            Staff ID <br>
                    <input type="text" name="staffID" id="staffID"> </br>
                                            Room ID <br>
                    <input type="text" name="roomID" id="roomID"> </br>
                                            Module ID <br>
                    <input type="text" name="moduleID" id="moduleID"> </br>
                                            Session Date <br>
                    <input type="text" name="sessionDate" id="sessionDate"> </br>
                                            Session Start Time <br>
                    <input type="text" name="sessionStartTime" id="sessionStartTime"> </br>
                                            Session End Time <br>
                    <input type="text" name="sessionEndTime" id="sessionEndTime"> </br>
                                            Class ID <br>
                    <input type="text" name="classID" id="classID"> <br> <br>

                    <input type="submit" id="createSession" name="createSession" value="Create Class Session">
                   
            </form>   
     
            <form method="post" id="createGroupForm">
             
                                    <h2> Create a Class group</h2>
                                     Group Name <br>
                  <input type="text" name="groupName" id="groupName"> </br>
                                        Staff ID <br>
                  <input type="text" name="staffID" id="staffID"> </br>
                                     Module ID <br>
                  <input type="text" name="moduleID" id="moduleID"> </br>
                  <br>
                  <input type="submit" id="createClassGroup" name="createClassGroup" value="Submit New Group">
                                  
            </form>
        
            <form method="post" id="viewGroupsForm">
            
                             <h3> Search Groups </h3>             
                                   Enter The Number of Results To Display <br>
               <input type="text" id="numResults" name="numResults"> <br>
                <br>
                <input type="submit" id="searchGroups" name="searchGroups" Value="Search">
                
            </form> 
        
             <form method="post" id="findModuleClassSessionsForm">
              
                             <h3> Find Sessions </h3>             
                                   Enter Module ID <br>
                                <input type="text" id="moduleID" name="moduleID"> <br>
                                      Choose One for Class Type(s) <br>
                                      
                                       Only Lectures<input type="radio" id="c1" name="choice" value="1" > 
                                       Only Labs<input type="radio" id="c2" name="choice" value="2" > 
                                       Only Seminars<input type="radio" id="c3" name="choice" value="3" > <br>
                                       Lectures & Labs<input type="radio" id="c4" name="choice" value="4" >   
                                       Lectures & Seminars<input type="radio" id="c5" name="choice" value="5" > 
                                       Labs & Seminars <input type="radio" id="c6" name="choice" value="6" > 
                                       All<input type="radio" id="c7" name="choice" value="7" > 
                            <br>
                <input type="submit" id="viewModuleClassSessions" name="viewModuleClassSessions" value="Search">
               
            </form> 
            </center>
   
                                <?php include_once 'backend/arcSystem/functions/managerTools/classManagement.php';
                                      include_once 'backend/arcSystem/functions/managerTools/attendanceManagement.php'; ?>  
                                
                                             
                       
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
