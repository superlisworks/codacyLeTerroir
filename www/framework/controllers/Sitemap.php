<?php

class Sitemap{

  /*protected $priority = [
  	"home"     => 0.6,            //home page
  	"static"   => 0.3,            //a static page
  	"article"  => 0.7,            //a dynamic page
  	"page"     => 0.7,            //pages that list articles
  ]*/

  public function __construct(){
    require "settings/sitemapConf.php";

    //1. list statics files inside /mvc/view/template/pages_$GLOBAL['lang'] and give coef following setting

    //2. check if there is articles with postModel

    //3. 


	}

/*	protected function makeSitemap($lang){

<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>http://mon-domaine.fr/</loc>
    <lastmod>2012-12-15</lastmod>
    <changefreq>daily</changefreq>
    <priority>1</priority>
  </url>
  <url>
    <loc>http://mon-domaine.fr/page-a.html</loc>
    <lastmod>2012-12-15</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.8</priority>
  </url>
</urlset>

    //make array for selected language
    // /!\ todo
    $page = [];

    //make array for selected language
    // /!\ todo

    require_once "framework/views/XMLview.php";
    $view = new XMLview($page);
    return $view->getXML(true);
  }
*/

  public function getData(){
    // die("todo : sitemap".$this->file);
    $loc = Security::filterServer("name");
    return [
      "url" => [
        "loc" => $loc,
        "lastmod" => "2012-12-15",
        "priority" => "1",
      ]
    ];
  	
  }
  // private function extractLangFromSitemapRequest($sitemap){
    
  // }

}