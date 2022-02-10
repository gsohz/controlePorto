<?php
require("../config/conexao.php");

$number = $_POST['number'];
$type = $_POST['type'];

$search = "SELECT cd_container FROM container WHERE cd_container = '$number'";
$result = $conn->query($search);

$line = $result->fetch(PDO::FETCH_ASSOC);

if(!$line["cd_container"]){

  $insert = "INSERT INTO container (cd_container, cd_tipo) VALUES ('$number', '$type')";
  
  if ($conn->query($insert) == TRUE) {
    echo "Container adicionado com sucesso <br> <a href='registerContainer.php'><button>Voltar</button></a>";
  } else {
    echo "Error: " . $insert . "<br>" . $conn->errorCode();
  }
  
  $conn = null;
}
else{
  echo "Container já cadastrado<a href='registerContainer.php'><button>Voltar</button></a>";
}
?>