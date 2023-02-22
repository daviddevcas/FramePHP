<?php

namespace Backend\Services\Server;

class CMD
{
    public static function getPrintersFromSystem(): array
    {
        $printers = array(); 
        $path_powershell = 'c:\Windows\System32\WindowsPowerShell\v1.0\powershell.exe'; 
        $options_exec = "-c"; 
        $space = " "; 
        $marks = '"'; 
        $command = 'get-WmiObject -class Win32_printer |ft name'; 
        exec(
            $path_powershell
                . $space
                . $options_exec
                . $space
                . $marks
                . $command
                . $marks,
            $request,
            $exit_code
        );

        if ($exit_code === 0) {
            if (is_array($request)) {
                for ($x = 3; $x < count($request); $x++) {
                    $printer = trim($request[$x]);
                    if (strlen($printer) > 0) 
                        array_push($printers, $printer);
                }
            }
        } 
        return $printers;
    }
}
