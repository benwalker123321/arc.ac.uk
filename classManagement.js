

   function viewCreateSessions(){
     
             document.getElementById('createAClassSessionForm').style.display = 'inline', 
             document.getElementById('createGroupForm').style.display = 'none', 
             document.getElementById('viewGroupsForm').style.display = 'none',           
             document.getElementById('findModuleClassSessionsForm').style.display = 'none';
             document.getElementById('message').style.display = 'none';

 }
    
 
  function  viewCreateGroup(){
     
             document.getElementById('createAClassSessionForm').style.display = 'none', 
             document.getElementById('createGroupForm').style.display = 'inline', 
             document.getElementById('viewGroupsForm').style.display = 'none',           
             document.getElementById('findModuleClassSessionsForm').style.display = 'none';
             document.getElementById('message').style.display = 'none';
 }
 
 
  function  viewGroupSearch(){
     
             document.getElementById('createAClassSessionForm').style.display = 'none', 
             document.getElementById('createGroupForm').style.display = 'none', 
             document.getElementById('viewGroupsForm').style.display = 'inline',           
             document.getElementById('findModuleClassSessionsForm').style.display = 'none';
             document.getElementById('message').style.display = 'none';
 }
 
 function viewSessions(){
     
             document.getElementById('createAClassSessionForm').style.display = 'none', 
             document.getElementById('createGroupForm').style.display = 'none', 
             document.getElementById('viewGroupsForm').style.display = 'none',           
             document.getElementById('findModuleClassSessionsForm').style.display = 'inline';
             document.getElementById('message').style.display = 'none';

 }

