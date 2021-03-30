<?php

namespace App\Controller\Pages;

use App\Controller\Auth\Auth;
use App\Utils\View;


class Page
{


  /**
   * Método responsável por renderizar o topo da página
   * 
   * @return string
   */
  private static function getHeader()
  {
    return View::render('pages/header', [
      "login"    => isset($_SESSION['userLogged']) ? View::render(('pages/login/login')) : View::render(('pages/login/facebook')),
      "facebook" => Auth::getAuthUrl(),
      "photo"    => isset($_SESSION['userLogged']) ? $_SESSION['userLogged']->getPictureUrl() : ''
    ]);
  }

  /**
   * Método responsável por renderizar o rodapé da página
   * 
   * @return string
   */
  private static function getFooter()
  {
    return View::render('pages/footer');
  }

  /**
   * Método responsável por retornar os conteúdo constante e dinâmicos das páginas
   *
   * @param  string $title
   * @param  string $content Conteúdo dinâmico da página
   * @return string
   */
  public static function getPage($title, $content)
  {
    return View::render('pages/page', [
      "title"   => $title,
      "header"  => self::getHeader(),
      "footer"  => self::getFooter(),
      "content" => $content
    ]);
  }
}
