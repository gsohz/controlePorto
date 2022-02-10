<?php

    require("../config/conexao.php");

    $cd = $_POST['cd'];
    $dtIni = date($_POST['dtIni']);
    $newDtIni = $_POST['newDtIni'];
    $newDtFin = $_POST['newDtFin'];
    $category = $_POST['category'];
    $status = $_POST['status'];
    $client = $_POST['cliente'];
    $movimentation = $_POST['movimentation'];

    $getDate = date_create_from_format('d/m/Y H:i', $dtIni);
    $formatIni = date_format($getDate, 'Y-m-d H:i');


    $search = "SELECT movimentacao_container.cd_container, cliente.nm_cliente, dt_inicio_movimentacao, dt_fim_movimentacao, categoria.nm_categoria, nm_status, movimentacao_tipo.nm_movimentacao_tipo
    FROM movimentacao_container 
    INNER JOIN categoria ON movimentacao_container.cd_categoria = categoria.cd_categoria
    INNER JOIN cliente ON movimentacao_container.cd_cliente = cliente.cd_cliente
    INNER JOIN movimentacao_tipo ON movimentacao_container.cd_movimentacao_tipo = movimentacao_tipo.cd_movimentacao_tipo
    INNER JOIN status ON movimentacao_container.cd_status = status.cd_status
    WHERE cd_container='$cd' AND dt_inicio_movimentacao='$formatIni'";

    $searchResult = $conn->query($search);

    $row = $searchResult->fetch(PDO::FETCH_ASSOC);

    if($row['cd_container'] && $newDtIni && $newDtFin){
      $update = "UPDATE movimentacao_container
      SET cd_categoria = '$category', cd_status = '$status', cd_movimentacao_tipo = '$movimentation', dt_inicio_movimentacao = '$newDtIni', dt_final_movimentacao = '$newDtFin', cd_cliente = '$client'
      WHERE cd_container = '$cd' AND dt_inicio_movimentacao = '$formatIni'";

    if ($conn->query($update) == TRUE) {
        echo "Movimentação atualizado com sucesso<br><a href='movHist.php'><button>Voltar</button></a>";
    } else {
        echo "Ocorreu um erro<br><a href='movHist.php'><button>Voltar</button></a>";

      }} else if ($row['cd_container'] && $newDtIni && !$newDtFin){
        $update = "UPDATE movimentacao_container
        SET cd_categoria = '$category', cd_status = '$status', cd_movimentacao_tipo = '$movimentation', dt_inicio_movimentacao = '$newDtIni', cd_cliente = '$client'
        WHERE cd_container = '$cd' AND dt_inicio_movimentacao = '$formatIni'";

      if ($conn->query($update) == TRUE) {
          echo "Movimentação atualizado com sucesso<br><a href='movHist.php'><button>Voltar</button></a>";
      } else {
          echo "Ocorreu um erro<br><a href='movHist.php'><button>Voltar</button></a>";
      }
    } else if ($row['cd_container'] && !$newDtIni && $newDtFin){
      $update = "UPDATE movimentacao_container
      SET cd_categoria = '$category', cd_status = '$status', cd_movimentacao_tipo = '$movimentation', dt_final_movimentacao = '$newDtFin', cd_cliente = '$client'
      WHERE cd_container = '$cd' AND dt_inicio_movimentacao = '$formatIni'";

    if ($conn->query($update) == TRUE) {
        echo "Movimentação atualizado com sucesso<br><a href='movHist.php'><button>Voltar</button></a>";
    } else {
        echo "Ocorreu um erro<br><a href='movHist.php'><button>Voltar</button></a>";
  }
}else {
  echo "Ocorreu um erro, tente inserir uma data<br><a href='movHist.php'><button>Voltar</button></a>";

}
?>