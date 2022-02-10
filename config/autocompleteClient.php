<?php

include_once "conexao.php";

$cd_cliente = filter_input(INPUT_GET, "cd", FILTER_SANITIZE_STRING);

if(!empty($cd_cliente)){
  
  $pesq_clientes = "%" . $cd_cliente . "%";
  
  $query_clientes= "SELECT cd_cliente
  FROM cliente
  WHERE cd_cliente LIKE :cd LIMIT 20";
  $result_clientes = $conn->prepare($query_clientes);
  $result_clientes->bindParam(':cd', $pesq_clientes);

  
  $result_clientes->execute();

    if(($result_clientes) and ($result_clientes->rowCount() != 0)){
        while($row_cliente = $result_clientes->fetch(PDO::FETCH_ASSOC)){
            $dados[] = [
                'cd' => $row_cliente['cd_cliente']
            ];
        }

        $retorna = ['erro' => false, 'dados' => $dados];
    }else{
        $retorna = ['erro' => true, 'msg' => "Erro: Nenhum usuário encontrado!"];
    }
    
}else{
    $retorna = ['erro' => true, 'msg' => "Erro: Nenhum usuário encontrado!"];
}

echo json_encode($retorna);


?>