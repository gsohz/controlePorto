<?php
$hostname = "localhost";
$db = "porto";
$user = "root";
$pass = "";

try{

  $conn = new PDO("mysql:host=$hostname;dbname=" . $db, $user, $pass);

  //echo "Conexão com banco de dados realizado com sucesso!";
}  catch(PDOException $err){
  echo "Erro: Conexão com banco de dados não foi realizada com sucesso. Erro gerado " . $err->getMessage();
}


?>