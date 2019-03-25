<?php
require_once "framework/controllers/Page.php";

class Front extends Page{	

  public $template = "front/main_template";

  protected function home(){
    $this->template = "/front/home";
    return [
      "{{ url1 }}"    => "/".Lang::$lang."/".Lang::trans('ou-sommes-nous'),
      "{{ text1 }}"   => Lang::trans("nous trouver"),

      "{{ url2 }}"    => "/".Lang::$lang."/".Lang::trans('produits'),
      "{{ text2 }}"   => Lang::trans("commander"),

      "{{ url3 }}"    => "/".Lang::$lang."/".Lang::trans('aujourdhui'),
      "{{ text3 }}"   => Lang::trans("mon compte"),

      "{{ url4 }}"    => "/".Lang::$lang."/".Lang::trans('social'),
      "{{ text4 }}"   => Lang::trans("social"),

      "{{ urlMentionsLegales }}" => "/".Lang::$lang."/".Lang::trans('mentions-legales'),
      "{{ mentionsLegales }}"    => Lang::trans("mentions légales"),

      "{{ urlRGPD }}"            => "/".Lang::$lang."/".Lang::trans('politique-de-confidentialite'),
      "{{ rgpd }}"               => Lang::trans("politique de confidencialité"),

      "{{ title }}"              => Lang::trans("baseLine")
    ];
  }

  protected function singlePost($specs){
    // 1. check url structure
    if( count($this->$uri) >2 ) return ErrorManager::page400();

    // 2. check specs : it should be an associative array
    if( is_string($specs) ) $specs = Tools::str2assoArray($specs);

    // 
    require_once "framework/controllers/PostCtrl.php";
    $post = new PostCtrl();
    $html = $post->getPost($specs);
    die("simplePost".var_dump($specs));
  }

  protected function debug(){

    require_once "project/controllers/Post.php";
    require_once "framework/views/HTMLview.php";

    $post = new Post( "id", 2);
    $postView = new HTMLview( $post);
    return [
      "{{ title }}"=>$post->data["{{ title }}"],
      "{{ content }}"=> $postView->html
    ];
  }
}