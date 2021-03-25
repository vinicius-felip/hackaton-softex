<?php

namespace App\Controller\Pages;

use App\Utils\View;


class Home extends Page{
    
    /**
     * Método responsável por retornar o conteudo da /home
     *  
     * @return string
     */
    public static function getHome(){
      //VIEW DA HOME
      
      $content = View::render('pages/home',[
        "name"        => 'teste',
        "description" => 'teste5'
      ]);


      //RETORNA A VIEW DA PAGINA
      return parent::getPage('TITULO', $content);
    }
}