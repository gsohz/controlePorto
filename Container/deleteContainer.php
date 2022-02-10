<?php

require("../config/conexao.php");

$cd = $_GET['cd'];

$search = "SELECT cd_container
FROM container c
WHERE cd_container = '$cd'";

$result = $conn->query($search);

$row = $result->fetch(PDO::FETCH_ASSOC);

if($row){
    $delete = "DELETE FROM container WHERE cd_container='$cd'";

    if ($conn->query($delete) == TRUE) {
      echo "Container deletado com sucesso<br><a href='listEditContainer.php'><button>Voltar</button></a>";
    } else{
    echo "Error: " . $delete . "<br>" . $conn->errorCode();
  }
}


?>