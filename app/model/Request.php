<?php

class Request
{
    public static function getRuta()
    {
        $ruta='/';
        if(isset($_SERVER['REDIRECT_PATH_INFO']))
        {
            $ruta=$_SERVER['REDIRECT_PATH_INFO'];

        }else if(isset($_SERVER['REQUEST_URI']))
            {
                $ruta=$_SERVER['REQUEST_URI'];

            }else if(isset($_SERVER['SCRIPT_NAME']))
                {
                    $ruta=$_SERVER['SCRIPT_NAME'];

                }else if(isset($_SERVER['PHP_SELF']))
                    {
                        $ruta=$_SERVER['PHP_SELF'];
                    }

        return $ruta;
    }
}