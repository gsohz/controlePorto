<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Histórico de Movimentação</title>

    
    <link rel="stylesheet" type="text/css" href="../stylePorto.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    

</head>


<body>

<?php
    require("../config/conexao.php");
  
    $searchHist = "SELECT cd_container, cliente.nm_cliente, dt_inicio_movimentacao, movimentacao_tipo.nm_movimentacao_tipo, dt_fim_movimentacao, categoria.nm_categoria
    FROM movimentacao_container
    INNER JOIN cliente ON movimentacao_container.cd_cliente = cliente.cd_cliente
    INNER JOIN movimentacao_tipo ON movimentacao_container.cd_movimentacao_tipo  = movimentacao_tipo .cd_movimentacao_tipo  
    INNER JOIN categoria ON movimentacao_container.cd_categoria = categoria.cd_categoria
    WHERE DATE(dt_inicio_movimentacao)
    LIKE CURDATE() ORDER BY dt_inicio_movimentacao DESC";
    
    $resultHist = $conn->query($searchHist, PDO::FETCH_ASSOC);

  
  ?>

  <a href="../index.php" style="position: absolute; left: 1%; top: 2%"><button class="btn btn-dark">Voltar</button></a>
  <a href="movHist.php"  style="position: absolute; top: 35%; left: 10%"><button class="btn btn-info">Movimentações do Dia</button></a>

  <div class="panel hist">
    <h1>Histórico de Movimentação</h1>
    <div class="container align-items-center justify-content-center mt-4" id="movBar">
      <form id="searchForm" method="POST">
          <div class="input-group">
            <label class="mt-1 mx-2" for="dtIni">Entre: </label>   
            <input class="form-control mx-auto" id="dtIni" name="dtIni" type="datetime-local"></input>
            <label class="input-group-addon mt-1 mx-2" for="dtFin">e: </label> 
            <input class="form-control" id="dtFin" name="dtFin" type="datetime-local"></input>
          </div>
          <div class="input-group">
            <label class="mt-3 mx-2" for="searchMov">Container: </label>   
            <input id="cd" class="form-control m-auto" name="cd" type="text"onkeyup="loadContainers(this.value)" onfocus="fecharContainer()" pattern="[a-zA-Z]{4}[0-9]{7}" title="Insira o código do container. Ex.: TEST1234567" /></input>
            <input class="btEnviar mx-2" name="submit" type="submit" value="Enviar">
          </div>
            <span id="resultado_pesquisaContainer"></span>
      </form>
    </div>
  </div>

  <div class="histTable">

    <span class="errorTxt"></span>
    <br>
    <h3 class="mt-4" style="text-align: center"><?php 
  if(!isset($_POST['submit'])){
    echo "Movimentações do Dia";
  } else{
    $cd = $_POST['cd'];
    $dtIni = $_POST['dtIni'];
    $dtFin = $_POST['dtFin'];
  }


  if(isset($cd) && $dtIni == null) {
    if($cd != null){
      echo "Movimentações do container ".$cd;
    }
  }
  
  
  if(isset($dtIni) && isset($dtFin)) {
    $dtIniGet = date_create($dtIni);
    $dtFinGet = date_create($dtFin);
    $dtIniFormat = date_format($dtIniGet, 'd/m/Y H:i');
    $dtFinFormat = date_format($dtFinGet, 'd/m/Y H:i');
    
    if($dtIni != null && $dtFin != null && $cd == null){
      echo "Movimentações entre ".$dtIniFormat." e ".$dtFinFormat;
    } else if($cd != null && $dtIni != null && $dtFin != null){
      echo "Movimentações do container: " .$cd ." entre ".$dtIniFormat." e ".$dtFinFormat;
    }
  }
  
  ?></h3>
  <table class="table table-dark table-striped mt-3" id="histMov">
    <tr> 
      <th scope="col">#</th>
      <th scope="col">Código Container</th>
      <th scope="col">Início Movimentação</th>
      <th scope="col">Fim Movimentação</th>
      <th scope="col">Tipo</th>
      <th scope="col">Categoria</th>
      <th scope="col">Cliente</th>
    </tr>
    <?php


if(!isset($_POST['submit'])){
  while($rowHist = $resultHist->fetch(PDO::FETCH_ASSOC)){
    echo "<tr><td id='options'><a href='consulta.php?cd=".$rowHist['cd_container'] ."&dtIni=" .$rowHist['dt_inicio_movimentacao'] ."'>^</a> <a href='delete.php?cd=".$rowHist['cd_container'] ."&dtIni=" .$rowHist['dt_inicio_movimentacao'] ."'>X</a></td>"
    ."<td id='cd'>".$rowHist['cd_container']."</td>"
      ."<td id='dtInit'>".$rowHist['dt_inicio_movimentacao']."</td>"
      ."<td id='dtFin'>".$rowHist['dt_fim_movimentacao']."</td>"
      ."<td id='mov_type'>".$rowHist['nm_movimentacao_tipo']."</td>"
      ."<td id='category'>".utf8_encode($rowHist['nm_categoria'])."</td>"
      ."<td id='client'>".$rowHist['nm_cliente']."</td>"
      ."</tr>";
      
    }
  } else if(isset($_POST['submit'])){
    $cd = $_POST['cd'];
    $dtIni = $_POST['dtIni'];
    $dtFin = $_POST['dtFin'];
    
    $searchCd= "SELECT cd_container, nm_movimentacao_tipo, nm_cliente, dt_inicio_movimentacao, dt_fim_movimentacao, nm_categoria
    FROM movimentacao_container
    INNER JOIN movimentacao_tipo ON movimentacao_container.cd_movimentacao_tipo = movimentacao_tipo.cd_movimentacao_tipo
    INNER JOIN categoria ON movimentacao_container.cd_categoria = categoria.cd_categoria
    INNER JOIN cliente ON movimentacao_container.cd_cliente = cliente.cd_cliente
    WHERE cd_container LIKE '$cd' ORDER BY dt_inicio_movimentacao DESC";
  
    $resultCd = $conn->query($searchCd);

    $searchDt = "SELECT cd_container, nm_movimentacao_tipo, nm_cliente, dt_inicio_movimentacao, dt_fim_movimentacao, nm_categoria
    FROM movimentacao_container
    INNER JOIN movimentacao_tipo ON movimentacao_container.cd_movimentacao_tipo = movimentacao_tipo.cd_movimentacao_tipo
    INNER JOIN categoria ON movimentacao_container.cd_categoria = categoria.cd_categoria
    INNER JOIN cliente ON movimentacao_container.cd_cliente = cliente.cd_cliente
    WHERE dt_inicio_movimentacao BETWEEN '$dtIni' AND '$dtFin' ORDER BY dt_inicio_movimentacao DESC";
    
    $resultDt = $conn->query($searchDt);
    
    $resultCdDt = "SELECT cd_container, nm_movimentacao_tipo, nm_cliente, dt_inicio_movimentacao, dt_fim_movimentacao, nm_categoria
    FROM movimentacao_container
    INNER JOIN movimentacao_tipo ON movimentacao_container.cd_movimentacao_tipo = movimentacao_tipo.cd_movimentacao_tipo
    INNER JOIN categoria ON movimentacao_container.cd_categoria = categoria.cd_categoria
    INNER JOIN cliente ON movimentacao_container.cd_cliente = cliente.cd_cliente
    WHERE cd_container LIKE '$cd' AND dt_inicio_movimentacao BETWEEN '$dtIni' AND '$dtFin' ORDER BY dt_inicio_movimentacao DESC";

$resultCdDt = $conn->query($resultCdDt);

    if($resultCd->rowCount() >= 1 && $_POST['dtIni'] == null){
    while($resultCd && $rowCd = $resultCd->fetch(PDO::FETCH_ASSOC)){
      echo "<tr><td id='options'><a href='consulta.php?cd=".$rowCd['cd_container'] ."&dtIni=" .$rowCd['dt_inicio_movimentacao'] ."'>^</a> <a href='delete.php?cd=".$rowCd['cd_container'] ."&dtIni=" .$rowCd['dt_inicio_movimentacao'] ."'>X</a></td>"
      ."<td id='cd'>".$rowCd['cd_container']."</td>"
      ."<td id='dtInit'>".$rowCd['dt_inicio_movimentacao']."</td>"
      ."<td id='dtFin'>".$rowCd['dt_fim_movimentacao']."</td>"
      ."<td id='mov_type'>".$rowCd['nm_movimentacao_tipo']."</td>"
      ."<td id='category'>".utf8_encode($rowCd['nm_categoria'])."</td>"
      ."<td id='client'>".$rowCd['nm_cliente']."</td>"
      ."</tr>";

  }
} else if($resultDt->rowCount() >= 1 && $_POST['cd'] == null){
  while($resultDt && $rowDt = $resultDt->fetch(PDO::FETCH_ASSOC)){
    echo "<tr><td id='options'><a href='consulta.php?cd=".$rowDt['cd_container'] ."&dtIni=" .$rowDt['dt_inicio_movimentacao'] ."'>^</a> <a href='delete.php?cd=".$rowDt['cd_container'] ."&dtIni=" .$rowDt['dt_inicio_movimentacao'] ."'>X</a></td>"
    ."<td id='cd'>".$rowDt['cd_container']."</td>"
    ."<td id='dtInit'>".$rowDt['dt_inicio_movimentacao']."</td>"
    ."<td id='dtFin'>".$rowDt['dt_fim_movimentacao']."</td>"
    ."<td id='mov_type'>".$rowDt['nm_movimentacao_tipo']."</td>"
    ."<td id='category'>".utf8_encode($rowDt['nm_categoria'])."</td>"
    ."<td id='client'>".$rowDt['nm_cliente']."</td>"
    ."</tr>";
  }
} else if($resultCdDt->rowCount() >= 1){
  while($resultCdDt && $rowCdDt = $resultCdDt->fetch(PDO::FETCH_ASSOC)){
    echo "<tr><td id='options'><a href='consulta.php?cd=".$rowCdDt['cd_container'] ."&dtIni=" .$rowCdDt['dt_inicio_movimentacao'] ."'>^</a> <a href='delete.php?cd=".$rowCdDt['cd_container'] ."&dtIni=" .$rowCdDt['dt_inicio_movimentacao'] ."'>X</a></td>"
    ."<td id='cd'>".$rowCdDt['cd_container']."</td>"
    ."<td id='dtInit'>".$rowCdDt['dt_inicio_movimentacao']."</td>"
    ."<td id='dtFin'>".$rowCdDt['dt_fim_movimentacao']."</td>"
    ."<td id='mov_type'>".$rowCdDt['nm_movimentacao_tipo']."</td>"
    ."<td id='category'>".utf8_encode($rowCdDt['nm_categoria'])."</td>"
    ."<td id='client'>".$rowCdDt['nm_cliente']."</td>"
    ."</tr>";
  }
}
?>
</table>



<?php
if ($_POST['cd'] != '' && $resultCd->rowCount() == 0) {
  echo "<h5 style='text-align: center; color:lightgray'>Nenhuma movimentacão encontrada para " .$cd ."</h5>";
}  else if($_POST['dtIni'] != '' && $resultDt->rowCount() == 0){
  echo "<h5 style='text-align: center; color:lightgray'>Nenhuma movimentacão encontrada entre " .$dtIniFormat .'  e ' .$dtFinFormat ."</h5>";
}
}
if($resultHist->rowCount() == 0 && !isset($_POST['submit'])){
  echo "<h5 style='text-align: center; color:lightgray'>Nenhuma movimentação até agora<h5>";
}

?>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script type="text/javascript" src="../config/validator.js"></script>
<script type="text/javascript" src="../config/custom.js"></script>
</body>
</html>