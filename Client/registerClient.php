<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cadastrar Cliente</title>
    <link rel="stylesheet" type="text/css" href="../stylePorto.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  </head>
  <body>
  <a href="../index.php" style="position: absolute; left: 1%; top: 2%"><button class="btn btn-dark">Voltar</button></a>

<div class="form client">

  <div class="containerPage">
    <div class="panel">
      <h1>Cadastrar Cliente</h1>
      <form action="postRegisterClient.php" method="POST">
        <table>
          <tr>
            <td>Nome:</td>
            <td><input class="inputText" id="name" name="name" type="text" /></td>
          </tr>
        </table>
        <input class="btEnviar" type="submit" value="Registrar">
      </form>
    </div>
  </div>
</div>
      
      
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
    </html>
    