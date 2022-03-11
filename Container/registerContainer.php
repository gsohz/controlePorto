<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cadastro de Container</title>

    <link rel="stylesheet" type="text/css" href="../stylePorto.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    </head>
  <body>
    <?php
    require("../config/conexao.php");
  
    $searchType = "SELECT * FROM tipo ORDER BY cd_tipo ASC";
    $searchCategory = "SELECT * FROM categoria ORDER BY cd_categoria ASC";
    $searchStatus = "SELECT * FROM status ORDER BY cd_status ASC";

    $resultType = $conn->query( $searchType, PDO::FETCH_ASSOC);
    $resultCategory = $conn->query( $searchCategory, PDO::FETCH_ASSOC);
    $resultStatus = $conn->query( $searchStatus, PDO::FETCH_ASSOC);  

    ?>

<a href="../index.php" style="position: absolute; left: 1%; top: 2%"><button class="btn btn-dark">Voltar</button></a>

<div class="containerPage">
    <div class="panel">

      <h1>Cadastro de Container</h1>
      <form action="postContainer.php" method="POST">
        <table>
          <tr>
            <td>Número do Container: </td>
            <td><input id="number" class="inputText" type="text" name="number" pattern="[a-zA-Z]{4}[0-9]{7}" title="Insira o código do container. Ex.: TEST1234567" required/></td>
          </tr>

          <tr>
            <td>Tipo:</td>
            <td><select class="inputText" name="type" required>
              <?php
                while ($lineType = $resultType->fetch(PDO::FETCH_ASSOC)){
                  echo "<option value=".$lineType["cd_tipo"].">".$lineType["nm_tipo"];
                }

              ?>
            </select></td>
          </tr>
        </table>
        <input class="btEnviar" type="submit" value="Enviar">
      </form>
    </div>
  </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
</body>
</html>