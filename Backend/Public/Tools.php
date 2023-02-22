<?php

namespace Backend\Public;

class Tools
{

    public static function passwordCrypt(String $pass): String
    {
        return  password_hash($pass, PASSWORD_DEFAULT, ['cost' => 5]);
    }

    public static function getMonthToStr(int $month): String
    {
        switch ($month) {
            case 1:
                return 'Enero';
            case 2:
                return 'Febrero';
            case 3:
                return 'Marzo';
            case 4:
                return 'Abril';
            case 5:
                return 'Mayo';
            case 6:
                return 'Junio';
            case 7:
                return 'Julio';
            case 8:
                return 'Agosto';
            case 9:
                return 'Septiembre';
            case 10:
                return 'Octubre';
            case 11:
                return 'Noviembre';
            case 12:
                return 'Diciembre';
            default:
                return 'Mes inexistente';
        }
    }

    public static function createPasswordCode(): String
    {
        $string = '';

        for ($i = 0; $i < 10; $i++) {
            $int = rand(33, 126);
            $string = $string . strval(chr($int));
        }

        return $string;
    }

    public static function getCodeKey(String $key): String
    {
        switch ($key) {
            case '001':
                return 'Entrada';
            case '002':
                return 'Venta';
            case '003':
                return 'Reporte de existencia';
            case '004':
                return 'Compra';
            case '005':
                return 'Devolución';
            case '006':
                return 'Baja';
            default:
                return 'Código inexistente.';
        }
    }

    public static function getCodeStatus(String $status): String
    {
        switch ($status) {
            case 'A':
                return 'Activo';
            case 'C':
                return 'Caducado';
            case 'D':
                return 'Descontinuado';
            default:
                return 'Código inexistente';
        }
    }

    public static function getTodayDate(bool $format = false, bool $time = true): String
    {
        if ($time) {
            return $format ? date('d') . '-' . Tools::getMonthToStr(intval(date('m'))) . '-' . date('Y H:i:s') : date('Y-m-d H:i:s');
        } else {
            return $format ? date('d') . '-' . Tools::getMonthToStr(intval(date('m'))) . '-' . date('Y') : date('Y-m-d');
        }
    }

    public static function getFormatDate(String $date): String
    {
        return date('d', strtotime($date)) . ' - ' . Tools::getMonthToStr(intval(date('m', strtotime($date)))) . ' - ' . date('Y H:i:s', strtotime($date));
    }
}
