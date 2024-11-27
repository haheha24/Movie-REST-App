<?php

$log_file = "./errors.log"; 
  
// setting error logging to be active 
ini_set("log_errors", TRUE); 

// ignore repeated errors
ini_set('ignore_repeated_errors', TRUE);
  
// setting the logging file in php.ini 
ini_set('error_log', $log_file); 



