<?php
session_start();    //create or retrieve session
if (IsSet($_SESSION["user"]))  //if username exists in session
   {
    session_destroy();    //destroy the session
    header("Location: index.html");   //forward to use home page
    exit();
   }
?>