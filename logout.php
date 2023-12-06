<?php
   session_start();
   if(isset($_COOKIE['cuit']) and isset($_COOKIE['contra'])) {

   $cuit = $_COOKIE['cuit'];
   $contra = $_COOKIE['contra'];
   
      session_destroy($_SESSION['logueado']);
      session_destroy($_SESSION['cuit']);
      session_destroy($_SESSION['idsucursal']);
       session_destroy($_SESSION['dni']);
   setcookie('cuit', $cuit, time()-1);	
   setcookie('contra', $contra, time()-1);
   
   }

   if(session_destroy()) {
      header("Location: index.php");

   }
?>