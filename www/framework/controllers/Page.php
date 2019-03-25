<?php

/*abstract*/ class Page {
  protected $uri  = [];

  public function __construct( $uri ) {
    $this->uri = $uri;

    //secondary route and get an html page

    // 1.  get data to include into page
    $this->data = $this->getDataPage();

    // 2. add default values
    $this->data["{{ lang }}"] = Lang::$lang;
  }

  protected function getDataPage(){
    global $routes;
    // 1. check if function is set
    if ( ! isset($routes[$this->uri[0]])) return ErrorManager::page404();

    // 2. adapt request if there is args in route
    $todo = explode ( "|" , $routes[$this->uri[0]]);
    if (!isset($todo[1])) $todo[1] = NULL;
    if (gettype($todo[1]) == "string") { // rebuild the array
      $todo[1] = explode(",", $todo[1]);
    }

    // 3.launch function
    return $this->run($todo[0], $todo[1]);
  }

  protected function run($function, $args=NULL){
    if (!is_null($args)) return call_user_func_array( [$this, ($function) ], $args );
    return call_user_func( [ $this, ($function) ]);
  }

  protected function staticPage($data){
    if ( !file_exists ( "project/staticPages/$data.php" )) {
      if (Tools::$debug) die("the asked's static page doesn't exist");
      die();
    }
    require_once "project/staticPages/$data.php";
    return $data;
  }
}