<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Controle de Porto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./stylePorto.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
    
  <script>
    $(document).ready(() => {
      setInterval(() => {
        $('#time').load('./time.php')
      }, 1000);
    })
  </script>

  </head>
  <body>
    <div class="containerPage">

      <div class="panel">
        <h2>Controle Porto</h2>
        <a href="Container/registerContainer.php"><button class="btn btn-secondary">Cadastro de Container</button></a>
        <a href="Movimentation/movContainer.php"><button class="btn btn-secondary">Registro de Movimentação de Container</button></a>
        <a href="Movimentation/movHist.php"><button class="btn btn-secondary">Histórico de Movimentações</button></a>
        <a href="Client/registerClient.php"><button class="btn btn-secondary">Cadastro de Cliente</button></a>
        <a href="Container/listEditContainer.php"><button class="btn btn-secondary">Lista Containers Editáveis</button></a>
        <a href="Report/pageReport.php"><button class="btn btn-info">Relatório</button></a>
      </div>

    
      <div id="time">
        <p>00:00:00</p>
      </div>
      <section>
        <div class="wave wave1"></div>
        <div class="wave wave2"></div>
        <div class="wave wave3"></div>
        <div class="wave wave4"></div>
      </section>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
  </html>
  