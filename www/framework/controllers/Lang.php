<?php
class Lang{

  public  static $defaultLang;
  public  static $lang;
  private static $translation;

  static function trans($msg){
    if (isset(self::$translation[$msg])) return self::$translation[$msg];
    return $msg;
  }

  static function init($lang){
    global $routes;
    require_once "project/translations/".$lang.".php";                             //define $this->translations
    self::$lang        = $lang;
    self::$translation = $translation;
  }
}