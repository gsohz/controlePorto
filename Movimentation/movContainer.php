<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registrar Movimentação de Container</title>

    
    <link rel="stylesheet" type="text/css" href="../stylePorto.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    </head>


<body>

<?php
    require("../config/conexao.php");
  
    $searchStatus = "SELECT * FROM status ORDER BY nm_status";
    $searchMovi = "SELECT * FROM movimentacao_tipo ORDER BY nm_movimentacao_tipo";
    $searchCategory = "SELECT * FROM categoria ORDER BY nm_categoria";
    
    $resultStatus = $conn->query( $searchStatus, PDO::FETCH_ASSOC);
    $resultMovi = $conn->query( $searchMovi, PDO::FETCH_ASSOC);
    $resultCategory = $conn->query( $searchCategory, PDO::FETCH_ASSOC);
  
  ?>
    <a href="../index.php" style="position: absolute; left: 1%; top: 2%"><button class="btn btn-dark">Voltar</button></a>
  
  <h1>Registrar Movimentação de Container</h1>

  <form action="postMovContainer.php" method="POST">
  <table>
    <tr>
      <td>Número do Container:</td>
      <td><input class="inputText" type="text" name="cd" id="cd" onkeyup="loadContainers(this.value)"  onfocus="fecharContainer()"/><span id="resultado_pesquisaContainer"></span></td>
      
    </tr>
    
    <tr>
      <td>Tipo:</td>
      <td><input class="inputText" disabled name="type" id="type" /></td>
    </tr>
    
    <tr>
      <td>Categoria:</td>
      <td><select class="inputText" name="category" id="category"><option id="status" selected disabled hidden></option>
        <?php
            while($rowCategory = $resultCategory->fetch(PDO::FETCH_ASSOC)){
              echo utf8_encode("<option value=".$rowCategory["cd_categoria"].">".$rowCategory["nm_categoria"]);
            }
            ?></select></td></td>
      </select>
    </tr>
    
    <tr>
      <td>Status:</td>
      <td><select class="inputText" name='status'>
      <option id="status" selected disabled hidden></option>
        <?php
            while($rowStatus = $resultStatus->fetch(PDO::FETCH_ASSOC)){
              echo utf8_encode("<option value=".$rowStatus["cd_status"].">".$rowStatus["nm_status"]);
            }
            ?></select></td>
    </tr>
    
    <tr>
      <td>Movimentação:</td>
      <td><select class="inputText" name="movimentation">
      <option selected disabled hidden></option>
      <?php
              while ($rowMov = $resultMovi->fetch(PDO::FETCH_ASSOC)){
                echo utf8_encode("<option value=".$rowMov["cd_movimentacao_tipo"].">".$rowMov["nm_movimentacao_tipo"]);
              }

            ?>
      </select></td>
    </tr>

    <tr>
      <td>Data Inicial:</td>
      <td><input class="inputText" name="dateInit" type="datetime-local" id="dateInit" /></td>
    </tr> 

    <tr>
      <td>Data Final:</td>
      <td><input class="inputText" name="dateFin" type="datetime-local" id="dateFin" /></td>
    </tr> 
    
    <tr>
      <td>Cliente:</td>
      <td><input id="cliente" class="inputText" name="cliente" type="text" onkeyup="loadClients(this.value)" onfocus="fecharClient()"/><span id="resultado_pesquisaClient"></span></td>
    </tr>
  </table>
  <input class="btEnviar" type="submit" value="Atualizar">
  </form>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script type="text/javascript" src="../config/custom.js"></script>
  
</body>
</html>