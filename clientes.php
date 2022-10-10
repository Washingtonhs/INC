<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once 'config/database.php';
    include_once 'class/Clientes.class.php';

    $database = new Database();
    $db = $database->getConnection();

    $cliente = new Clientes($db);
    $clienteId = intval($_GET["cliente_id"]);
    $clienteEmail = $_GET["cliente_email"];

    switch($_SERVER["REQUEST_METHOD"])
    {
        case 'GET':
            if(!empty($clienteId) || !empty($clienteEmail))
                $clientes = $cliente->getSingleCliente($clienteId, $clienteEmail);
            else
                $clientes = $cliente->getClientes();

            echo json_encode($clientes, JSON_PRETTY_PRINT);

            break;

        case 'POST':
            $result = $cliente->createCliente();
            echo json_encode($result, JSON_PRETTY_PRINT);
            break;

        case 'DELETE':
            $result = $cliente->deleteCliente($clienteId);
            echo json_encode(['success' => $result], JSON_PRETTY_PRINT);
            break;

        default:
            header("HTTP/1.0 405 Método não permitido");
            break;
    }
?>