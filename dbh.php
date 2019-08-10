<?php

if(!isset($_SESSION)) 
    { 
        session_start();
    }
    
	$host = 'localhost';
	$username = 'root';
	$password = '';
	$database = 'ppfo_inventory';

	$mysqli = new mysqli($host,$username,$password,$database) or die(mysql_error($mysqli));

?>