<?php
	session_start();


	$con = new mysqli("localhost","root","","ecom");

// Check connection
if ($con -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();}
// 	define('DB_HOST','localhost');
// define('DB_USER','root');
// define('DB_PASSWORD','');
// define('DB_DATABASE','ecom');

// class DatabaseConnection
// {
//     public function __construct()
//     {
//         $con = new mysqli("localhost","root","","ecom");

//         if($con->connect_error)
//         {
//             die ("<h1>Database Connection Failed</h1>");
//         }
//         return $this -> con = $con;
        
//     }
// }

?>