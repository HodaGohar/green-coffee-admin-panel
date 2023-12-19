<?php
   include 'connection';

   session_start();
   session_unset();
   session_destroy();
   header('location: ../admin/login.php'); 

?>