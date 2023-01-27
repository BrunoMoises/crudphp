<?php
require_once("../../vendor/autoload.php");

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$controller = null;
$id_pessoa = null;
$data = null;
$method = $_SERVER["REQUEST_METHOD"];
$uri = $_SERVER["REQUEST_URI"];
$unsetCount = 3;

$ex = explode("/", $uri);

for ($i = 0; $i < $unsetCount; $i++)
{
    unset($ex[$i]);
}

$ex = array_filter(array_values($ex));

if (isset($ex[0]))
    $controller = $ex[0];

if (isset($ex[1]))
    $controller = $ex[1];

parse_str(file_get_contents('php://input'), $data);

?>