<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edição de Container</title>
    
    <link rel="stylesheet" type="text/css" href="../stylePorto.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    
  </head>
  <body>
    <?php
    require("../config/conexao.php");

    $searchType = "SELECT * FROM tipo ORDER BY cd_tipo ASC";
    

    $cd = $_GET['cd'];

    $search = "SELECT cd_container, nm_tipo
    FROM container c
    INNER JOIN tipo t ON c.cd_tipo = t.cd_tipo
    WHERE cd_container = '$cd'";
    
    $result = $conn->query($search);

    $row = $result->fetch(PDO::FETCH_ASSOC);
    
    $resultType = $conn->query( $searchType, PDO::FETCH_ASSOC);

    if($row['cd_container'] <> ""){
  ?>

    <h1>Edição de Container</h1>
    <form action="postUpdateContainer.php" method="POST">
      <table>
        <tr>
          <input type="hidden" name="oldCd" value="<?php echo $row['cd_container'] ?>">
          <td>Número do Container: </td>
          <td><input id="cd" class="inputText" type="text" name="cd" pattern="[a-zA-Z]{4}[0-9]{7}" title="Insira o código do container. Ex.: TEST1234567" value="<?php echo $row['cd_container'] ?>" required/><span id="resultado_pesquisaContainer"></span></td>
        </tr>

        <tr>
          <td>Tipo:</td>
          <td><select id="type" class="inputText" name="type" required>
          <option  selected disabled hidden ><?php 
          echo $row['nm_tipo']
          ?></option><?php
              while ($lineType = $resultType->fetch(PDO::FETCH_ASSOC)){
                echo "<option value=".$lineType["cd_tipo"].">".$lineType["nm_tipo"];
              }

            ?>
          </select></td>
        </tr>
        
      </table>
      <input class="btEnviar" type="submit" value="Enviar">
    </form>

  <?php
    } else{
      echo "Container não existe<br><a href='listEditContainer.php'><button>Voltar</button></a";
    }

  ?>

      
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script type="text/javascript" src="../config/custom.js"></script>

  </body>
</html>