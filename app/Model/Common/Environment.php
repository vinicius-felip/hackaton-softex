<?php

namespace App\Model\Common;

class Environment  
{    
    /**
     * Método responsável por carregar as variavéis de ambiente no projeto
     *
     * @param  string $dir caminho absoluto da pasta onde encontra-se o arquivo .env
     */
    public static function load($dir)
    {
        //VERIFICA SE ARQUIVO EXISTE
        if (!file_exists($dir.'/.env')){
            return false;
        }
        
        //DEFINE AS VÁRIAVEIS DE AMBIENTE
        $lines = file($dir.'/.env');
        foreach ($lines as $line){
            putenv((trim($line)));
        }
    }
}
