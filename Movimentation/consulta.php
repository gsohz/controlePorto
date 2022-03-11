<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar Movimentação de Container</title>

    
    <link rel="stylesheet" type="text/css" href="../stylePorto.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>


<body>
<?php

    require("../config/conexao.php");

    $cd = $_GET['cd'];
    $dtIni = $_GET['dtIni'];

    $search = "SELECT movimentacao_container.cd_container, cliente.cd_cliente, dt_inicio_movimentacao, dt_fim_movimentacao, categoria.nm_categoria, nm_status, movimentacao_tipo.nm_movimentacao_tipo
    FROM movimentacao_container 
    INNER JOIN categoria ON movimentacao_container.cd_categoria = categoria.cd_categoria
    INNER JOIN cliente ON movimentacao_container.cd_cliente = cliente.cd_cliente
    INNER JOIN movimentacao_tipo ON movimentacao_container.cd_movimentacao_tipo = movimentacao_tipo.cd_movimentacao_tipo
    INNER JOIN status ON movimentacao_container.cd_status = status.cd_status
    WHERE cd_container='$cd' AND dt_inicio_movimentacao='$dtIni'";

    $searchResult = $conn->query($search);

    $row = $searchResult->fetch(PDO::FETCH_ASSOC);
    
      
        $searchStatus = "SELECT * FROM status ORDER BY nm_status";
        $searchSituation = "SELECT * FROM movimentacao_tipo ORDER BY nm_movimentacao_tipo";
        $searchCategory = "SELECT * FROM categoria ORDER BY nm_categoria";
        
        $resultStatus = $conn->query( $searchStatus, PDO::FETCH_ASSOC);
        $resultSituation = $conn->query( $searchSituation, PDO::FETCH_ASSOC);
        $resultCategory = $conn->query($searchCategory, PDO::FETCH_ASSOC);

    if($row['cd_container'] <> ""){
      ?>

<a href="../index.php" style="position: absolute; left: 1%; top: 2%"><button class="btn btn-dark">Voltar</button></a>

  <h1>Editar Movimentação de Container</h1>

  <form action="postUpdateMov.php" method="POST">
    <table>
      <tr>
        <td>Número do Container:</td>
        <td><input class="inputText" type="text" name="cd" id="cd" value="<?php 
          echo $row['cd_container'];
    ?>"/>     
        <span id="resultado_pesquisaContainer"></span></td>
        
      </tr>
      
      <tr>
        <td>Categoria:</td>
        <td><select class="inputText" name='category'>
        <option id="category" selected disabled hidden ><?php 
          echo utf8_encode($row['nm_categoria']);
    ?></option>
          <?php
              while($lineCategory = $resultCategory->fetch(PDO::FETCH_ASSOC)){
                echo utf8_encode("<option value=".$lineCategory["cd_categoria"].">".$lineCategory ["nm_categoria"]);
              }
              ?></select></td>
      </tr>
      
      <tr>
        <td>Status:</td>
        <td><select class="inputText" name='status'>
        <option id="status" selected disabled hidden ><?php 
          echo $row['nm_status'];
    ?></option>
          <?php
              while($lineStatus = $resultStatus->fetch(PDO::FETCH_ASSOC)){
                echo utf8_encode("<option value=".$lineStatus["cd_status"].">".$lineStatus["nm_status"]);
              }

              ?></select></td>
      </tr>
      
      <tr>
        <td>Movimentação:</td>
        <td><select class="inputText" name="movimentation">
        <option id="movimentation" selected disabled hidden><?php 
          echo $row['nm_movimentacao_tipo'];
    ?></option></option>
        <?php
                while ($line = $resultSituation->fetch(PDO::FETCH_ASSOC)){
                  echo utf8_encode("<option value=".$line["cd_movimentacao_tipo"].">".$line["nm_movimentacao_tipo"]);
                }

              ?>
        </select></td>
      </tr>

      <tr>
        <td>Data Inicial Atual:</td>
        <td><input class="inputText" type="text" name="dtIni" readonly style="color: gray"  value="<?php 
        echo date('d/m/o H:i',strtotime($row["dt_inicio_movimentacao"]));
        ?>"/></td>
      </tr> 
      
      <tr>
        <td>Data Inicial Nova:</td>
        <td><input class="inputText" name="newDtIni" type="datetime-local" id="date" /></td>
      </tr> 

      <tr>
        <td>Data Final Atual:</td>
        <td><input class="inputText" readonly style="color: gray" value="<?php 
        if($row['dt_fim_movimentacao'] != null){
          echo date('d/m/o H:i',strtotime($row["dt_fim_movimentacao"]));
        } else {
          echo "Não finalizado";
        }
        ?>" type="text" id="date" /></td>
      </tr> 

      <tr>
        <td>Data Final Nova:</td>
        <td><input class="inputText" name="newDtFin" type="datetime-local" id="date"/></td>
      </tr> 

      <tr>
        <td>Cliente:</td>
        <td><input id="cpf" class="inputText" name="cliente" type="text" onkeyup="loadClients(this.value)" onfocus="fecharClient()" value="<?php 
        echo $row['cd_cliente'];
        ?>"/><span id="resultado_pesquisaClient"></span></td>
      </tr>
    </table>
    <input class="btEnviar" type="submit" value="Atualizar">
  </form>
  <?php
    }
    else{
      echo "Movimento não existe";
    }

?>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script type="text/javascript" src="../config/custom.js"></script>
  
</body>
</html>
