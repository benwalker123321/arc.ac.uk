
    <?php

        class user{
            public $Name;
            private $StudentID;
            private $Email;
        }
        
    //    require_once 'authoriseManager.php';
    //    require_once 'authoriseStudent.php';
   //     authorise_user(array('Academics'));
        
        
        //connect to the DB
        $dsn = 'mysql:host=127.0.0.1;dbname=angliaruskincollege';
        $user = 'root';
        $password = 'password';
        
        try {
            $db = new PDO($dsn, $user, $password);
        } catch (PDOException $e) {
    //        echo 'Connection failed: ' . $e->getMessage();
            die('Sorry, database problem');
        }
        
        // create a query
        $query = "SELECT user_name,password FROM users";
        
        //send the query to the db
        $result = $db->query($query);
        
        
 
        $result->setFetchMode(PDO::FETCH_CLASS, 'Student');
        while($object = $result->fetch()) {
            echo '<pre>', $object->Name, '</pre>';
        }
        
        
        // create the table
        print ("<table border='3'>");
        
        // add the rows to the table
        while($row = $result->fetch()) {
            
            //add a row
            print ("<tr>");
            
            //print a cell
            print ("<td> $row[user_name] </td>");
            print ("<td> $row[Name] </td>");
            print ("<td> $row[Email] </td>");
//            print ("<td> $row[username] </td>");
            //close row
            print ("</tr>");
            
        }
        
        //close table
        print ("</table");
        
