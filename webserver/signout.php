<?php
   session_start();
   
  session_destroy();
  // redirec to login page
  header("Location: login");
   
?>