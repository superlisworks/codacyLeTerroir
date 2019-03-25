<?php
class Tools{

  static $debug = false;                                                  //pointer for enable debugging

  static function rewriteURL($url){
    $port = "";
    if (self::$debug) $port = ":".$_SERVER['SERVER_PORT'];
    header("LOCATION: http://".$_SERVER['SERVER_NAME'].$port."/".$url);
  }

  static function routeExists($lang){
    return file_exists("project/translations/".$lang.".php");
  }

  static function str2assoArray($str){
    $tab = [];
    $rows = explode(";", $str);
    foreach($rows as $row) {
      list($key, $value) = explode("=>", $row);
      $tab[$key] = $value;
    }
    return $tab;
  }
}