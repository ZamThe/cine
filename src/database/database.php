<?php

    class Connection {

   		function connectdb() {

   			//attributes

    		$user = 'root';
    	 	$pass = '';

    	 	global $connect;

    		//methods

	    	// Set DSN

	    	$dsn = 'mysql:host=localhost;dbname=agricola_actividades;';

	    	//Create a PDO instance

	    	try {

		    	$connect = new PDO($dsn, $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
				$connect->query("SET NAMES 'utf8'");


			}catch(PDOexception $e) {

		    	print 'Error: ' . $e->getMessage();
		        
			}

		}

	}

	$newconnection = new Connection();
	$newconnection->connectdb();


?> 