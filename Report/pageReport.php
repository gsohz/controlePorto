<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Relatório</title>
    
    <link rel="stylesheet" type="text/css" href="../stylePorto.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>


<body>

<?php
    require("../config/conexao.php");
  
    $searchRep = "SELECT cd_cliente, count(dt_inicio_movimentacao) AS vl_total_movimentacao, 
    count(CASE WHEN cd_movimentacao_tipo = 1 THEN 1 END) AS vl_total_importacao, 
    count(CASE WHEN cd_movimentacao_tipo = 2 THEN 1 END) AS vl_total_exportacao 
    FROM movimentacao_container 
    WHERE DATE(dt_inicio_movimentacao) BETWEEN CURDATE() AND CURDATE()+1 GROUP BY cd_cliente";
    
    $resultRep = $conn->query($searchRep, PDO::FETCH_ASSOC);
  
  ?>
  
  <a href="../index.php" style="position: absolute; left: 1%; top: 2%"><button class="btn btn-dark">Voltar</button></a>
  <a href="pageReport.php"  style="position: absolute; top: 35%; left: 10%"><button class="btn btn-info">Relatórios do Dia</button></a>
  <div class="panel hist">
  <h1>Relatório</h1>
    <div class="container align-items-center justify-content-center mt-4" id="movBar">
      <form id="searchForm" name="searchForm" method="POST">
        <div class="input-group">
          <label class="mt-1 mx-2" for="dtIni">Entre: </label>   
          <input class="form-control" id="dtIni" name="dtIni" type="datetime-local"></input>
          <label class="input-group-addon mt-1 mx-2" for="dtFin">e: </label> 
          <input class="form-control" id="dtFin" name="dtFin" type="datetime-local"></input>
        </div>
        <div class="input-group">
          <label class="mt-3 mx-2" for="cd">Cliente: </label>   
          <input id="cd" class="form-control m-auto" name="cd" type="text" onkeyup="loadHist(this.value)" onfocus="fecharContainer()" /></input>
          <input class="btEnviar mx-2" name="submit" type="submit" value="Enviar">
        </div>
        <span id="resultado_pesquisaContainer"></span>
      </form>
    </div>
  </div>
  <span class="errorTxt"></span>
<br>
<h3 class="mt-4"style="text-align: center">
<?php




if(!isset($_POST['submit'])){
  echo "Relatórios do Dia";
} else {
  $cd = $_POST['cd'];
  $dtIni = $_POST['dtIni'];
  $dtFin = $_POST['dtFin'];
  }


  if(isset($cd) && $dtIni == null) {
    if($cd != null){
    echo "Relatórios do cliente ".$cd;
    }
  }

    if(isset($dtIni) && isset($dtFin)) {
      $dtIniGet = date_create($dtIni);
      $dtFinGet = date_create($dtFin);
      $dtIniFormat = date_format($dtIniGet, 'd/m/Y H:i');
      $dtFinFormat = date_format($dtFinGet, 'd/m/Y H:i');
      
      if($dtIni != null && $dtFin != null && $cd == null){
        echo "Relatórios entre ".$dtIniFormat." e ".$dtFinFormat;
      } else if($cd != null && $dtIni != null && $dtFin != null){
        echo "Relatórios do cliente: " .$cd ." entre ".$dtIniFormat." e ".$dtFinFormat;
      }

  }

  
  
  ?>

</h3>
  <table class="table table-dark table-striped mt-3" id="histMov">
  <tr> 
    <th scope="col">#</th>
    <th scope="col">Cliente</th>
    <th scope="col">Total Importação</th>
    <th scope="col">Total Exportação</th>
    <th scope="col">Total Movimentação</th>
  </tr>
  <?php

if(!isset($_POST['submit'])){
  while($rowRep = $resultRep->fetch(PDO::FETCH_ASSOC)){
    echo "<tr><td id='options'><a href='clientReport.php?cd=".$rowRep['cd_cliente'] ."'>^</a></td>"
    ."<td id='cd'>".$rowRep['cd_cliente']."</td>"
    ."<td id='dtFin'>".$rowRep['vl_total_importacao']."</td>"
    ."<td id='type'>".$rowRep['vl_total_exportacao']."</td>"
    ."<td id='dtInit'>".$rowRep['vl_total_movimentacao']."</td>"
    ."</tr>";
  }
} else if(isset($_POST['submit'])){
  $cd = $_POST['cd'];
  $dtIni = $_POST['dtIni'];
  $dtFin = $_POST['dtFin'];
  
  $searchCd = "SELECT cd_cliente, count(dt_inicio_movimentacao) AS vl_total_movimentacao, 
    count(CASE WHEN cd_movimentacao_tipo = 1 THEN 1 END) AS vl_total_importacao, 
    count(CASE WHEN cd_movimentacao_tipo = 2 THEN 1 END) AS vl_total_exportacao 
    FROM movimentacao_container 
    WHERE cd_cliente LIKE '$cd' GROUP BY cd_cliente";
    
    $resultCd = $conn->query($searchCd, PDO::FETCH_ASSOC);
    
    $searchDt = "SELECT cd_cliente, count(dt_inicio_movimentacao) AS vl_total_movimentacao, 
    count(CASE WHEN cd_movimentacao_tipo = 1 THEN 1 END) AS vl_total_importacao, 
    count(CASE WHEN cd_movimentacao_tipo = 2 THEN 1 END) AS vl_total_exportacao 
    FROM movimentacao_container 
    WHERE dt_inicio_movimentacao BETWEEN '$dtIni' AND '$dtFin' GROUP BY cd_cliente";
    
    $resultDt = $conn->query($searchDt, PDO::FETCH_ASSOC);
    
    if($resultCd->rowCount() >= 1){
      while($resultCd && $rowCd = $resultCd->fetch(PDO::FETCH_ASSOC)){
        echo "<tr><td id='options'><a href='clientReport.php?cd=".$rowCd['cd_cliente'] ."'>^</a></td>"
        ."<td id='cd'>".$rowCd['cd_cliente']."</td>"
        ."<td id='dtFin'>".$rowCd['vl_total_importacao']."</td>"
        ."<td id='type'>".$rowCd['vl_total_exportacao']."</td>"
        ."<td id='dtInit'>".$rowCd['vl_total_movimentacao']."</td>"
        ."</tr>";
      }
    } else if($resultDt->rowCount() >= 1){
      while($resultDt && $rowDt = $resultDt->fetch(PDO::FETCH_ASSOC)){
        echo "<tr><td id='options'><a href='clientReport.php?cd=".$rowDt['cd_cliente'] ."'>^</a></td>"
        ."<td id='cd'>".$rowDt['cd_cliente']."</td>"
        ."<td id='dtFin'>".$rowDt['vl_total_importacao']."</td>"
        ."<td id='type'>".$rowDt['vl_total_exportacao']."</td>"
        ."<td id='dtInit'>".$rowDt['vl_total_movimentacao']."</td>"
        ."</tr>";
        
      }
    } 
      
      ?>

</table>


<?php
if($cd != '' && $resultCd->rowCount() == 0){
  echo "<h5 style='text-align: center; color:lightgray'>Nenhuma movimentacão encontrada para " .$cd ."</h5>";
} else if(isset($dtIni) && $dtIni != '' && $resultDt->rowCount() == 0){
  echo "<h5 style='text-align: center; color:lightgray'>Nenhuma movimentacão encontrada entre " .$dtIniFormat .'  e ' .$dtFinFormat ."</h5>";
}
}

if($resultRep->rowCount() == 0 && !isset($_POST['submit'])){
  echo "<h5 style='text-align: center; color:lightgray'>Nenhuma movimentação até agora<h5>";
}


?>



  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script type="text/javascript" src="../config/validator.js"></script>
  <script type="text/javascript" src="../config/custom.js"></script>

  
  
</body>
</html>
