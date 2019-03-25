<?php

require_once "framework/controllers/Lang.php";                       //class for translation
require_once "framework/controllers/Security.php";                   //class for having safe data
require_once "framework/controllers/Tools.php";                      //static collection of tool's functions 
require_once "framework/model/Model.php";                            //static model
require_once "framework/views/ErrorManager.php";                     //static functions for showing error
require_once "project/conf.php";                                     //configuration file - after static class


if (Tools::$debug) ErrorManager::showPhpErrors();                    //debug mode
Model::init();                                                       //init PDO connection

// data security
Security::init();
$uri = Security::getAddress();

// check url structure
if ( $uri[0] == "" ) {                                               //only domain's name address
  Tools::rewriteURL(Lang::$defaultLang."/");                         // we reroute to default language
}

$address = explode(".", strtolower($uri[0]));

// first routing
if ( substr( $address[0], 0, 8 ) == "sitemap_" ) {
  Lang::init(explode( "_" , $address[0] )[1]);
  $address[0] = "sitemap";
}
switch ($address[0]) {
  case 'api':
    if ( !isset($address[1]) ) $address[1] = "json";                 //for the moment by default in api mode we return json (because no rest support yet)
    // require_once "framework/controllers/APIview.php";
    // $renderer = new APIview();
    break;

  case 'sitemap':
    if ( !Tools::routeExists(Lang::$lang) ) define404();            //language not supported
    else {
      require_once "framework/controllers/Sitemap.php";
      $page = new Sitemap();
    }
    break;

  case 'robot':
    require_once "framework/controllers/RobotTxt.php";
    $page = new RobotTxt();
    break;

  default:
    if ( !Tools::routeExists($address[0]) ) define404();            //language not supported
    else Lang::init($address[0]);

    //check if it's front or back
    if ( isset($uri[1]) && $uri[1] == "admin" ) {
      require_once "project/controllers/Back.php";
      $page = new Back(arrar_slice($uri,2), "admin/main_template");
    }
    else {
      require_once "project/controllers/Front.php";
      $page = new Front(array_slice($uri,1));
    }
    break;
}

unset($uri);                                                        //clean useless var


//choose the right renderer following extension
if ( !isset($address[1]) ) $address[1] = NULL;                      //avoid having error
switch ($address[1]) {
  case 'json':
    // require_once "framework/views/JSONview.php";
    // $renderer = new JSONview( $page->getData() );
    break;
  case 'txt':
    require_once "framework/views/TXTview.php";
    $renderer = new TXTview( $page );   // a reprendre
    break;

  case 'xml':
    require_once "framework/views/XMLview.php";
    $renderer = new XMLview( $page );   // a reprendre
    break;

  default:
    require_once "framework/views/HTMLview.php";
    $renderer = new HTMLview( $page );
    break;
}

// show a securized page
echo Security::decodePage($renderer->render());

function define404(){
  Lang::init(Lang::$defaultLang);
  $address[0]      = "/!\ 404";
  $address[1]      = "html";                                          // change renderer to standard view for showing 404
}

// /!\ merge ErrorManager into standard html render
// /!\ finish robot.txt
// /!\ make sitemap.php