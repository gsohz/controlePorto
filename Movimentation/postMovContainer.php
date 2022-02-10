<?php
require("../config/conexao.php");


  $cd = $_POST['cd'];
  $category = $_POST['category'];
  $movimentation = $_POST['movimentation'];
  $status = $_POST['status'];
  $dateInit = $_POST['dateInit'];
  $dateFin = $_POST['dateFin'];
  $client = $_POST['cliente'];


$searchContainer = "SELECT cd_container, cd_tipo FROM container WHERE cd_container = '$cd'";
$resultContainer = $conn->query($searchContainer);
$rowContainer = $resultContainer->fetch(PDO::FETCH_ASSOC);

$searchMov = "SELECT cd_container, dt_inicio_movimentacao, dt_fim_movimentacao FROM movimentacao_container WHERE cd_container = '$cd' AND cd_cliente = '$client' AND dt_fim_movimentacao IS NULL";
$resultMov = $conn->query($searchMov);
$rowMov = $resultMov->fetch(PDO::FETCH_ASSOC);

$searchConflict = "SELECT cd_container, dt_inicio_movimentacao, dt_fim_movimentacao FROM movimentacao_container 
WHERE cd_container = '$cd' AND cd_cliente = '$client' AND dt_inicio_movimentacao < '$dateInit' ORDER BY dt_inicio_movimentacao DESC";
$resultConflict =  $conn->query($searchConflict);
$rowConflict = $resultConflict->fetch(PDO::FETCH_ASSOC);

$searchInUse = "SELECT cd_container, cd_cliente, dt_fim_movimentacao FROM movimentacao_container WHERE cd_container='$cd' AND dt_fim_movimentacao IS NULL";
$resultInUse = $conn->query($searchInUse);
$rowInUse = $resultInUse->fetch(PDO::FETCH_ASSOC);

$dateGet = date_create($dateInit);
$dateFormat = date_format($dateGet, 'Y-m-d H:i:s');

if(($rowContainer["cd_container"]) && ($dateFormat > $rowMov['dt_inicio_movimentacao'])){

  if($rowInUse["cd_container"] == $cd && $rowInUse["dt_fim_movimentacao"] == null && $rowInUse["cd_cliente"] == $client && $dateInit && ($rowConflict['dt_inicio_movimentacao'] < $dateInit)){

    $insert = "INSERT INTO movimentacao_container (cd_container, cd_categoria, cd_status, cd_movimentacao_tipo, dt_inicio_movimentacao, cd_cliente) VALUES ('$cd', '$category', '$status', '$movimentation', '$dateInit', '$client')";
    
    if ($conn->query($insert) == TRUE) {
      echo "Nova movimentação registrada com sucesso<br>";

      if(($rowMov['dt_fim_movimentacao'] == null && $rowMov['dt_inicio_movimentacao'] < $dateFormat)){
          
        $update = "UPDATE movimentacao_container SET dt_fim_movimentacao = '$dateInit' where cd_container = '$cd' and cd_cliente = '$client' and dt_fim_movimentacao is null and dt_inicio_movimentacao < '$dateInit'";
        
        if ($conn->query($update) == TRUE) {
          echo "Fim de movimentação registrada com sucesso<br><a href='movContainer.php'><button>Voltar</button></a>";
        } else {
          echo "Error: " . $update . "<br>" . $conn->errorCode();
        }
      }
    } else {
      echo "Error: " . $insert . "<br>" . $conn->errorCode();
    }

    }else if(!$rowInUse  && ($rowConflict['dt_inicio_movimentacao'] < $dateInit)){
        $insertNew = "INSERT INTO movimentacao_container (cd_container, cd_categoria, cd_status, cd_movimentacao_tipo, dt_inicio_movimentacao, cd_cliente) VALUES ('$cd', '$category', '$status', '$movimentation', '$dateInit', '$client')";

        if ($conn->query($insertNew) == TRUE) {
          echo "Nova movimentação registrada com sucesso<br><a href='movContainer.php'><button>Voltar</button></a>";
        }
      } else if ((!$dateInit && $dateFin) && ($client == $rowInUse["cd_cliente"]) && ($rowMov['dt_inicio_movimentacao'] < $dateFin)){
        
        $updateFin = "UPDATE movimentacao_container SET dt_fim_movimentacao = '$dateFin' where cd_container = '$cd' and cd_cliente = '$client' and dt_fim_movimentacao is null and dt_inicio_movimentacao < '$dateFin'";

        if ($conn->query($updateFin) == TRUE) {
          echo "Fim de movimentação registrada com sucesso<br><a href='movContainer.php'><button>Voltar</button></a>";
        } else {
          echo "Error: " . $updateFin . "<br>" . $conn->errorCode();
        }

      } else{
        echo "Ocorreu um erro, container já está em uso por outro cliente, finalize o movimentação<br><a href='movContainer.php'><button>Voltar</button></a>";
      }
    }else{
        echo "Ocorreu um erro<br><a href='movContainer.php'><button>Voltar</button></a>";
      }



?>

