<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require __DIR__ . "/consultas.php";
$action = $_GET['action'];

$data = null;
header("Content-Type: application/json");
switch ($action) {
    case 'getInformacion':
        $documento = $_GET['documento'];
        $data = getInformacionPaciente($documento);
        break;
    case 'updateInformacion':
        $data = updateInformacion($_POST);
        break;
}


echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
