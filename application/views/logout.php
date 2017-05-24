<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'backend/arcSystem/core/dbconfig.php';

session_destroy();
unset($_SESSION['user_session']);
redirect('../../../../../xampp/arc.ac.uk/index.php/');
?>




