# Port Control Application
This is an application to control the movement of container in the port tested with WampServer.
It's possible to register container and clients,
register the movements of the containers that are group by the initial date of the movement.
There is a report tab based on customer order movements.
I used autocomplete to search the containers in the database and jQuery to make validation on the search form.


![InitialPage](https://user-images.githubusercontent.com/98726404/157884359-07827c41-5327-487e-b887-43c26388366d.png)


## Initialization
To run the project use the tools described in the *Tools* section.

### Start Project
- Download project
- Init WampServer
- Add project to VirtualHost

## Tools
* [Visual Studio Code](https://code.visualstudio.com/) - Code editor for development.
* [WampServer](https://www.wampserver.com/en/) - Software for managing local servers and databases.

# Port Control Application

## Introduction

> This project is a Web Application to control and manage the movement of containers in the port.  
> The main objective of this project is to **manage container movements with CRUD operations**.  
With the general objectives of learning to deal with **relational database** and **PHP** language.

## Technical analysis

### Description of the technical environment

The system consists of a database and a web interface. Main features:

* **F1** - Autocomplete search container.
> Return database search to javascript file.
```
    if(($result) and ($result->rowCount() != 0)){
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $dados[] = [
                'cd' => $row['cd_container'],
                'tipo' => $row['nm_tipo']
            ];
        }
```
> Show the data for the user.
```
async function loadContainers(val) {
  if (val.length >= 1) {
    const dados = await fetch('../config/autocompleteContainer.php?cd=' + val)
    const resposta = await dados.json()

    var html = "<ul class='list-group position-fixed'>"

    if (resposta['erro']) {
      html +=
        "<li class='list-group-item disabled'>" + resposta['msg'] + '</li>'
    } else {
      for (i = 0; i < resposta['dados'].length; i++) {
        html +=
          "<li class='list-group-item list-group-item-action' onclick='get_container(" +
          JSON.stringify(resposta['dados'][i].cd) +
          ',' +
          JSON.stringify(resposta['dados'][i].tipo) +
          ',' +
          JSON.stringify(resposta['dados'][i].categoria) +
          ")'>" +
          resposta['dados'][i].cd +
          '</li>'
      }
    }

    html += '</ul>'

    document.getElementById('resultado_pesquisaContainer').innerHTML = html
  }
}
```
* **F2** - Adding container in database.
```
if(!$line["cd_container"]){

  $insert = "INSERT INTO container (cd_container, cd_tipo) VALUES ('$number', '$type')";
  
  if ($conn->query($insert) == TRUE) {
    echo "Container adicionado com sucesso <br> <a href='registerContainer.php'><button>Voltar</button></a>";
  } else {
    echo "Error: " . $insert . "<br>" . $conn->errorCode();
  }
  
  $conn = null;
}
```

* **F3** - Save container movement.
```
if(($rowContainer["cd_container"]) && ($dateFormat > $rowMov['dt_inicio_movimentacao'])){

  if($rowInUse["cd_container"] == $cd && $rowInUse["dt_fim_movimentacao"] == null && $rowInUse["cd_cliente"] == $client && $dateInit && ($rowConflict['dt_inicio_movimentacao'] < $dateInit)){

    $insert = "INSERT INTO movimentacao_container (cd_container, cd_categoria, cd_status, cd_movimentacao_tipo, dt_inicio_movimentacao, cd_cliente) VALUES ('$cd', '$category', '$status', '$movimentation', '$dateInit', '$client')";
    
    if ($conn->query($insert) == TRUE) {
      echo "Nova movimentação registrada com sucesso<br>";

      if(($rowMov['dt_fim_movimentacao'] == null && $rowMov['dt_inicio_movimentacao'] < $dateFormat)){
          
        $update = "UPDATE movimentacao_container SET dt_fim_movimentacao = '$dateInit' where cd_container = '$cd' and cd_cliente = '$client' and dt_fim_movimentacao is null and dt_inicio_movimentacao < '$dateInit'";
        
        if ($conn->query($update) == TRUE) {
          echo "Fim de movimentação registrada com sucesso<br><a href='movContainer.php'><button>Voltar</button></a>";
        } else {
          echo "Error: " . $update . "<br>" . $conn->errorCode();
        }
      }
    } else {
      echo "Error: " . $insert . "<br>" . $conn->errorCode();
    }

    }else if(!$rowInUse  && ($rowConflict['dt_inicio_movimentacao'] < $dateInit)){
        $insertNew = "INSERT INTO movimentacao_container (cd_container, cd_categoria, cd_status, cd_movimentacao_tipo, dt_inicio_movimentacao, cd_cliente) VALUES ('$cd', '$category', '$status', '$movimentation', '$dateInit', '$client')";

        if ($conn->query($insertNew) == TRUE) {
          echo "Nova movimentação registrada com sucesso<br><a href='movContainer.php'><button>Voltar</button></a>";
        }
      } else if ((!$dateInit && $dateFin) && ($client == $rowInUse["cd_cliente"]) && ($rowMov['dt_inicio_movimentacao'] < $dateFin)){
        
        $updateFin = "UPDATE movimentacao_container SET dt_fim_movimentacao = '$dateFin' where cd_container = '$cd' and cd_cliente = '$client' and dt_fim_movimentacao is null and dt_inicio_movimentacao < '$dateFin'";

        if ($conn->query($updateFin) == TRUE) {
          echo "Fim de movimentação registrada com sucesso<br><a href='movContainer.php'><button>Voltar</button></a>";
        } else {
          echo "Error: " . $updateFin . "<br>" . $conn->errorCode();
        }

      } else{
        echo "Ocorreu um erro, container já está em uso por outro cliente, finalize o movimentação<br><a href='movContainer.php'><button>Voltar</button></a>";
      }
    }else{
        echo "Ocorreu um erro<br><a href='movContainer.php'><button>Voltar</button></a>";
      }
```

> The tools used for the development include **PHP** which is a programming language used for the Back-end, for the front-end **HTML** was used. **MySQL** acting as a relational database management system and **WampServer** to use the container environment.

### Database Model
![modelDatabase](https://user-images.githubusercontent.com/98726404/157908667-4b117dab-a014-4cdf-98a1-71aec0810125.png)

