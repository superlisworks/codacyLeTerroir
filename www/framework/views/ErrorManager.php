<?php

class ErrorManager {
  // static function crsf(){
  //   return "you're talking to me?";
  // }
  static function page400(){
    header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request"); 
    return [
      "{{ content }}"    => file_get_contents("mvc/view/template/400.html"),
      "{{ title }}"      => "requête mal formulée"
    ];
  }

  static function page404(){
    header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); 
    return [
      "{{ content }}"    => file_get_contents("mvc/view/template/404.html"),
      "{{ title }}"      => "page inexistante"
    ];
  }

  static function page503($information=""){
    header($_SERVER["SERVER_PROTOCOL"]." 503 Service Unavailable"); 
    return [
      "{{ content }}"    => str_replace( "{{ information }}", $information, file_get_contents("mvc/view/template/503.html") ),
      "{{ title }}"      => "service momentanément indisponible"
    ];
  }

  static function showPhpErrors(){ //debug mode => show errors 
    ini_set("display_startup_errors", 1);
    ini_set('display_errors', 1); 
    error_reporting(E_ALL);
  }
}