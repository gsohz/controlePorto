<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Relatório do Cliente</title>

    
    <link rel="stylesheet" type="text/css" href="../stylePorto.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    

</head>


<body>

<a href="pageReport.php" style="position: absolute; left: 1%; top: 2%"><button class="btn btn-dark">Voltar</button></a>

<?php
    require("../config/conexao.php");

    $cliente = $_GET['cd'];
  
    $searchRep = "SELECT cd_cliente, cd_container, 
    count(dt_inicio_movimentacao) AS vl_total_movimentacao,
    count(CASE WHEN cd_movimentacao_tipo = 1 THEN 1 END) AS vl_total_importacao, 
    count(CASE WHEN cd_movimentacao_tipo = 2 THEN 1 END) AS vl_total_exportacao 
    FROM movimentacao_container
    WHERE cd_cliente = '$cliente' GROUP BY cd_container";
    
    $resultRep = $conn->query($searchRep, PDO::FETCH_ASSOC);

  ?>
  
  
  <h1>Relatório do Cliente</h1>

  <div class="container align-items-center justify-content-center mt-4" id="movBar">
    <form action="../config/autocompleteHist.php" method="POST">
  <div class="input-group">
  <label class="mt-1 mx-2" for="searchMovDtIni">Entre: </label>   
  <input class="form-control" name="searchMovDtIni" type="datetime-local"></input>
  <label class="input-group-addon mt-1 mx-2" for="searchMovDtFin">e: </label> 
  <input class="form-control" name="searchMovDtFin" type="datetime-local"></input>
</div>
<div class="input-group">
  <label class="mt-3 mx-2" for="searchMov">Cliente: </label>   
  <input id="searchMovCont" class="form-control m-auto" name="searchMovCont" type="text"onkeyup="loadHist(this.value)" onfocus="fecharContainer()" /></input>
  <input class="btEnviar mx-2" type="submit" value="Enviar">
</div>
<span id="resultado_pesquisaContainer"></span>
</form>
  </div>

<h3 class="mt-4"style="text-align: center">Relatório do Dia</h3>
  <table class="table table-bordered table-striped mt-3" id="histMov">
  <tr> 
    <th scope="col">Cliente</th>
    <th scope="col">Código do Container</th>
    <th scope="col">Total Importação</th>
    <th scope="col">Total Exportação</th>
    <th scope="col">Total Movimentação</th>
  </tr>
  <?php

while($rowRep = $resultRep->fetch(PDO::FETCH_ASSOC)){
  echo
  "<td id='cd'>".$rowRep['cd_cliente']."</td>"
  ."<td id='dtInit'>".$rowRep['cd_container']."</td>"
  ."<td id='dtFin'>".$rowRep['vl_total_importacao']."</td>"
  ."<td id='type'>".$rowRep['vl_total_exportacao']."</td>"
  ."<td id='dtInit'>".$rowRep['vl_total_movimentacao']."</td>"
  ."</tr>";
}


?>

</table>

<?php
if($resultRep->rowCount() == 0){
  echo "<h5 style='text-align: center; color:lightgray'>Nenhuma movimentação até agora<h5>";
}

?>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script type="text/javascript" src="../config/custom.js"></script>
  
</body>
</html>