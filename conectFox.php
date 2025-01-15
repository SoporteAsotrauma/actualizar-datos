<?php
declare(strict_types=1);

/**
 * Esta clase representa la conexion con las tablas de fox pro mediante PDO
*/
class ConnectionFox
{
    private static ?PDO $conexion = null;


    public static function con(): PDO
    {

        if (self::$conexion === null) {

            try {
                self::$conexion = self::connect();
            } catch(\Exception) {
                die("No se pudo conectar a GEMA...");
            }
        }


        return self::$conexion;

    }


    private static function connect(): PDO
    {

        $dsn = "odbc:Driver={Microsoft Visual FoxPro Driver};".
        "SourceType=DBF;SourceDB=Z:\\;Exclusive=No;".
        "Collate=Machine;NULL=NO;DELETED=NO;BACKGROUNDFETCH=NO";

        return new PDO(
            $dsn,
            "",
            "",
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    }
}