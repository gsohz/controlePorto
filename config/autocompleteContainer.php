<?php

include_once "conexao.php";

$cd_container = filter_input(INPUT_GET, "cd", FILTER_SANITIZE_STRING);

if(!empty($cd_container)){
  
  $searchTerm = "%" . $cd_container . "%";
  
  $searchContainers= "SELECT container.cd_container, tipo.nm_tipo
  FROM container
  INNER JOIN tipo ON container.cd_tipo = tipo.cd_tipo
  WHERE container.cd_container LIKE :cd LIMIT 20";
  $result = $conn->prepare($searchContainers);
  $result->bindParam(':cd', $searchTerm);


  $result->execute();

    if(($result) and ($result->rowCount() != 0)){
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $dados[] = [
                'cd' => $row['cd_container'],
                'tipo' => $row['nm_tipo']
            ];
        }

        $retorna = ['erro' => false, 'dados' => $dados];
    }else{
        $retorna = ['erro' => true, 'msg' => "Erro: Nenhum container encontrado!"];
    }
    
}else{
    $retorna = ['erro' => true, 'msg' => "Erro: Nenhum container encontrado!"];
}

echo json_encode($retorna);


?>
