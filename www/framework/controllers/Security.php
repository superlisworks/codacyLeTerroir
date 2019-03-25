<?php

class Security{

  public static function init() {
    session_start();
    if (!isset($_SESSION['token'])) $_SESSION['token'] = self::generateToken();
  }

  public static function decodePage($str){
    return html_entity_decode ( $str, ENT_HTML5, 'UTF-8');
  }

  /*public static function filterInputs(){
    $data=[
      'token'   => false,
      'address' => self::getAddress()
    ];

    // XSS
    if (!empty($_POST)){
      // if (isset($_POST["page"]))    $data['page']    = filter_var($_POST["page"], FILTER_SANITIZE_STRING);
      // if (isset($_POST["comment"])) $data['comment'] = filter_var($_POST["comment"], FILTER_SANITIZE_SPECIAL_CHARS,FILTER_FLAG_ENCODE_HIGH);

      // post donc faut vérifier token
      $data['token']   = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
    }

    // CRSF
    if ($data['token']){
      if ($data['token'] != $_SESSION['token']) die( ErrorManager::crsf() );
    }
    

    // retour
    return $data;
  }*/

  private static function generateToken(){
    return base64_encode( bin2hex( random_bytes(32) ) );
  }

  public static function getAddress(){
    $array = explode ( "/", filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW));
    return array_slice($array, 1);
  }

  static function filterPost(string $element){
    switch ($element) {
      case 'a definir': return filter_input(INPUT_POST, "jkjkl", FILTER_SANITIZE_URL);
        break;
      default:
        if (Tools::$debug) die($element." not planned in Security::filterPost");
        return false;
    }
  }

  static function filterServer(string $element){
    switch ($element) {
      case 'name': 
        return filter_input(INPUT_SERVER, "SERVER_NAME", FILTER_SANITIZE_URL, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
      default:
        if (Tools::$debug) die($element." not planned in Security::filterPost");
        return false;
    }
  }

}