<?php
require("../config/conexao.php");

$name = $_POST['name'];

$insert = "INSERT INTO cliente (nm_cliente) VALUES ('$name')";
  
  if ($conn->query($insert) == TRUE) {
    echo "Cliente cadastrado com sucesso<br><a href='registerClient.php'><button>Voltar</button></a>";
  } else {
    echo "Error: " . $insert . "<br>" . $conn->errorCode();
  }
  
  $conn = null;

  ?>