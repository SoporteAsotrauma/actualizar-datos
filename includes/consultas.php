<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

date_default_timezone_set("America/Bogota");
require __DIR__ . "/../conectFox.php";
session_start();

function getInformacionPaciente($documento): array
{
    $data = [];
    ConnectionFox::con()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = ConnectionFox::con()->query("
        SELECT DAT.nombre, DAT.nombre2, DAT.apellido1, DAT.apellido2, DAT.direccion, DAT.telefono, DAT.email, DAT.ciudad, DAT.fech_nacim
        FROM Z:\GEMA10.D\SALUD\DATOS\SAHISTOC DAT
        WHERE DAT.num_histo = $documento
    ");
    $c = function ($s) {
        return trim(mb_convert_encoding($s, "UTF-8", "CP1252"));
    };
    while ($row = $query->fetch()) {

        // $data = $row;
        $data = [];
        foreach ($row as $key => $value) {
            if (gettype($value) == 'string') {
                $data[$key] = $c($value);
                continue;
            }
            $data[$key] = $value;
        }
        // $data[] = [
        //     "eps" => $c($row['eps']),
        // ];
    }

    if ($data != null) {
        $data = [
            "status" => true,
            "data" => $data,
        ];
    } else {
        $data = [
            "status" => false,
            "messagge" => "Cedula No Registrada"
        ];
    }

    return $data;
}

function updateInformacion($datos)
{
    try {
        // Establecer la conexión y habilitar el modo de error
        ConnectionFox::con()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Primera tabla: Z:\GEMA10.D\SALUD\DATOS\SAHISTOC
        $query1 = "
            UPDATE Z:\GEMA10.D\SALUD\DATOS\SAHISTOC
            SET direccion = '{$datos['direccion']}',
                telefono = STR({$datos['telefono']}, 10),
                email = '{$datos['email']}'
            WHERE num_histo = {$datos['documento']}
        ";
        ConnectionFox::con()->exec($query1);

        // Segunda tabla: Z:\GEMA_MEDICOS\DATOS\SAHISTOC
        $query2 = "
            UPDATE Z:\GEMA_MEDICOS\DATOS\SAHISTOC
            SET direccion = '{$datos['direccion']}',
                telefono = STR({$datos['telefono']}, 10),
                email = '{$datos['email']}'
            WHERE num_histo = {$datos['documento']}
        ";
        ConnectionFox::con()->exec($query2);

        return [
            "status" => true,
            "message" => "Información actualizada correctamente"
        ];
    } catch (Exception $e) {
        return [
            "status" => false,
            "message" => "Error al actualizar la información: " . $e->getMessage()
        ];
    }
}
