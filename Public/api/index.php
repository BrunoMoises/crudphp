<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once("../../vendor/autoload.php");
use App\Controller\PessoaController;

$controller = null;
$id_pessoa = null;
$method = $_SERVER["REQUEST_METHOD"];
$uri = $_SERVER["REQUEST_URI"];
$data = null;
parse_str(file_get_contents('php://input'), $data);
$unsetCount = 3;

$ex = explode("/", $uri);

for ($i = 0; $i < $unsetCount; $i++) {
    unset($ex[$i]);
}

$ex = array_filter(array_values($ex));

if (isset($ex[0]))
    $controller = $ex[0];

if (isset($ex[1]))
    $id_pessoa = $ex[1];

$pessoaController = new PessoaController();

switch ($method) {
    case 'GET':
        if ($controller != null && $id_pessoa == null) {
            echo $pessoaController->readAll();
        } else if ($controller != null && $id_pessoa != null) {
            echo $pessoaController->readById($id_pessoa);
        } else {
            echo json_encode(["result" => "invalid"]);
        }
        break;
    case 'POST':
        if ($controller != null && $id_pessoa == null) {
            echo $pessoaController->create($data);
        } else {
            echo json_encode(["result" => "invalid"]);
        }
        break;
    case 'PUT':
        if ($controller != null && $id_pessoa != null) {
            echo $pessoaController->update($id_pessoa, $data);
        } else {
            echo json_encode(["result" => "invalid"]);
        }
        break;
    case 'DELETE':
        if ($controller != null && $id_pessoa != null) {
            echo $pessoaController->delete($id_pessoa);
        } else {
            echo json_encode(["result" => "invalid"]);
        }
        break;
    default:
        echo json_encode(["result" => "invalid request"]);
        break;
}

?>