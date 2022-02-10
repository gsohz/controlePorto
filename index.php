<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Controle de Porto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
.painel{
  margin-left: auto;
  margin-right: auto;
  width: 30%;
}

button {
  display: block;
  margin: 1em;
  margin-left: auto;
  margin-right: auto;
  width: 100%;
}

a:link {
  text-decoration: none;
}
      </style>

  </head>
  <body>
    <div class="painel mt-5">
      <a href="Container/registerContainer.php"><button class="btn btn-secondary">Cadastro de Container</button></a>
      <a href="Movimentation/movContainer.php"><button class="btn btn-secondary">Registro de Movimentação de Container</button></a>
      <a href="Movimentation/movHist.php"><button class="btn btn-secondary">Histórico de Movimentações</button></a>
      <a href="Client/registerClient.php"><button class="btn btn-secondary">Cadastro de Cliente</button></a>
      <a href="Container/listEditContainer.php"><button class="btn btn-secondary">Lista Containers Editáveis</button></a>
      <a href="Report/pageReport.php"><button class="btn btn-info">Relatório</button></a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>
