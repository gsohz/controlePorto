<?php
  require("../config/conexao.php");
  
if(isset($_POST['cd']) && isset($_POST['type'])){
  $cd = $_POST['cd'];
  $type = $_POST['type'];
  $oldCd = $_POST['oldCd'];
  
  $search = "SELECT cd_container, cd_tipo
  FROM container 
  WHERE cd_container='$oldCd'";
  
  $searchResult = $conn->query($search);
  
  $row = $searchResult->fetch(PDO::FETCH_ASSOC);
  
  if($row['cd_container']){
    $update = "UPDATE container
    SET cd_container = '$cd', cd_tipo = '$type'
     WHERE cd_container = '$oldCd'";
  
    if ($conn->query($update) == TRUE) {
      echo "Container atualizado com sucesso<br><a href='listEditContainer.php'><button>Voltar</button></a>";
    } else {
      echo "Ocorreu um erro, já existem movimentações com este container registrada, exclua os registros para excutar esta ação<br><a href='listEditContainer.php'><button>Voltar</button></a>";
    }
    
    $conn = null;
  }
  else{
    echo "Ocorreu um erro<br><a href='listEditContainer.php'><button>Voltar</button></a>";
  }

}  else{
  echo "Ocorreu um erro, selecione todos os campos<br><a href='listEditContainer.php'><button>Voltar</button></a>";
}



?>