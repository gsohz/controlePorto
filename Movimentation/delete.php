<?php

require("../config/conexao.php");

$cd = $_GET['cd'];
$dtIni = $_GET['dtIni'];

$search = "SELECT movimentacao_container.cd_container, cliente.nm_cliente, dt_inicio_movimentacao, dt_fim_movimentacao, categoria.nm_categoria, nm_status, movimentacao_tipo.nm_movimentacao_tipo
FROM movimentacao_container 
INNER JOIN categoria ON movimentacao_container.cd_categoria = categoria.cd_categoria
INNER JOIN cliente ON movimentacao_container.cd_cliente = cliente.cd_cliente
INNER JOIN movimentacao_tipo ON movimentacao_container.cd_movimentacao_tipo = movimentacao_tipo.cd_movimentacao_tipo
INNER JOIN status ON movimentacao_container.cd_status = status.cd_status
WHERE cd_container='$cd' AND dt_inicio_movimentacao='$dtIni'";

$searchResult = $conn->query($search);

$row = $searchResult->fetch(PDO::FETCH_ASSOC);

if($row){
    $delete = "DELETE FROM movimentacao_container WHERE cd_container='$cd' AND dt_inicio_movimentacao='$dtIni'";

    if ($conn->query($delete) == TRUE) {
      echo "Movimentação deletada com sucesso<br><a href='movHist.php'><button>Voltar</button></a>";
    } else{
    echo "Error: " . $delete . "<br>" . $conn->errorCode();
  }
}


?>