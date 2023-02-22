<?php

namespace Backend\Services;

use Backend\Services\Structures\Collection;

class Validator
{
    public static function validateString($value, int $max = -1, int $min = -1): bool
    {
        if (is_string($value)) {
            return ($max > -1 ? strlen($value) <= $max : true) && ($min > -1 ? strlen($value) >= $min : true);
        } else {
            return false;
        }
    }

    public static function validateRegularPhrase(String $value, String $expresion): bool
    {
        return preg_match($expresion, $value);
    }

    public static function validateInt($value, int $max = -1, int $min = -1): bool
    {
        if (is_numeric($value)) {
            $value = explode('.', strval($value));

            if (!isset($value[1])) {
                return ($max > -1 ? $value <= $max : true) && ($min > -1 ? $value >= $min : true);
            }
        }

        return false;
    }

    public static function validateDecimal($value, int $max = -1, int $min = -1): bool
    {
        if (is_numeric($value)) {
            return ($max > -1 ? $value <= $max : true) && ($min > -1 ? $value >= $min : true);
        } else {
            return false;
        }
    }

    public static function validateDecimalFormat($value, String $limits): bool
    {
        if (is_numeric($value)) {
            $value = explode('.', strval($value));

            $limits = explode(',', $limits);

            if (isset($limits[0]) && isset($limits[1]) &&  isset($value[0]) && isset($value[1])) {
                if (Validator::validateInt($limits[0]) && Validator::validateInt($limits[1])) {
                    return strlen($value[0]) <= intval($limits[0]) && strlen($value[1]) <= intval($limits[1]);
                }
            }
        }

        return false;
    }

    public static function validateMax($value, int $max): bool
    {
        return strlen($value) <= $max;
    }

    public static function validateMin($value, int $min): bool
    {
        return strlen($value) >= $min;
    }

    public static function validate(String $validates, $value): Collection
    {
        $validatesKeys = explode('|', $validates);
        $errors = new Collection();

        foreach ($validatesKeys as $val) {
            $message = Validator::indentifyValidate($val, $value);
            if ($message != '') {
                $errors->addItem($message);
            }
        }

        return $errors;
    }

    private static function indentifyValidate(String $keys, $value): string
    {
        $tokens = explode(':', $keys);

        switch ($tokens[0]) {
            case 'int':
                if (!Validator::validateInt($value)) {
                    return 'integer_error';
                }
                break;
            case 'string':
                if (!Validator::validateString($value)) {
                    return 'string_error';
                }
                break;
            case 'decimal':

                if (!isset($tokens[1])) {
                    if (!Validator::validateDecimal($value)) {
                        return 'decimal_error';
                    }
                } else {
                    if (!Validator::validateDecimalFormat($value, $tokens[1])) {
                        return 'decimal_error_format';
                    }
                }
                break;
            case 'max':
                if (!Validator::validateMax($value, $tokens[1])) {
                    return 'max_error';
                }
                break;
            case 'min':
                if (!Validator::validateMin($value, $tokens[1])) {
                    return 'min_error';
                }
                break;
            case 'regex':
                if (!Validator::validateRegularPhrase($value, $tokens[1])) {
                    return 'regex_error';
                }
                break;
        }

        return '';
    }
}
