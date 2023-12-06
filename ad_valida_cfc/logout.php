<?php
   session_start();
   if(isset($_COOKIE['dni']) and isset($_COOKIE['contra'])) {

   $dni = $_COOKIE['dni'];
   $contra = $_COOKIE['contra'];
   
      session_destroy($_SESSION['logueado']);
       session_destroy($_SESSION['dni']);
   setcookie('dni', $dni, time()-1);	
   setcookie('contra', $contra, time()-1);
   
   }

   if(session_destroy()) {
      header("Location: index.php");

   }
?>