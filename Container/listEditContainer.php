<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Containers Editáveis</title>

    
    <link rel="stylesheet" type="text/css" href="../stylePorto.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    

</head>


<body>

<?php
    require("../config/conexao.php");
  
    $searchHist = "SELECT cd_container, nm_tipo
    FROM container c
    INNER JOIN tipo t ON c.cd_tipo = t.cd_tipo
    WHERE NOT EXISTS (SELECT * FROM movimentacao_container m WHERE c.cd_container = m.cd_container)";
    
    $resultHist = $conn->query($searchHist, PDO::FETCH_ASSOC);
  
  ?>
  
  <a href="../index.php" style="position: absolute; left: 1%; top: 2%"><button class="btn btn-dark">Voltar</button></a>
  
  <h1>Lista de Containers Editáveis</h1>

  <table>

  <table class="table table-dark table-striped mt-5" id="histMov">
  <tr> 
    <th scope="col">#</th>
    <th scope="col">Código Container</th>
    <th scope="col">Tipo</th>
  </tr>

  <?php
    while($rowHist = $resultHist->fetch(PDO::FETCH_ASSOC)){
      echo "<tr><td id='options'><a href='editContainer.php?cd=".$rowHist['cd_container']."'>^</a> <a href='deleteContainer.php?cd=".$rowHist['cd_container'] ."'>X</a></td>"
      ."<td id='cd'>".$rowHist['cd_container']."</td>"
      ."<td id='type'>".$rowHist['nm_tipo']."</td>"
      ."</tr>";
    }
  ?>

  </table>

  <?php
if($resultHist->rowCount() == 0){
  echo "<h5 style='text-align: center; color:lightgray'>Nenhum container editável até agora<h5>";
}

?>

  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script type="text/javascript" src="../config/custom.js"></script>
  
</body>
</html>