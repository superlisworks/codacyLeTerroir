<?php

class Post{

  public $data;

  public function __construct($from=null, $value=null) {

    //define a base request
    $req = [
      "data"  => [
        'title AS "{{ title }}"',
        'content AS "{{ content }}"',
        'url AS "{{ postUrl }}"',
        'DATE_FORMAT(published, \'%d/%m/%Y\') AS "{{ published }}"',
        'DATE_FORMAT(updated, \'%d/%m/%Y\') AS "updated"'
      ],
      "from"  => "posts"
    ];

    switch ($from){
      case "id" : 
        $req["where"] = [ "ID = ".$value ];
        $req["limit"] = 1;
        $this->template = "front/singlePost";
        break;
      case "slug" : 
        array_push($req['data'], "ID");
        $req["where"] = [ "slug = ".$value ];
        $this->template = "front/singlePost";
        break;
      case "list" : 
        array_push($req['data'], "ID");
        break;
      case "featured" : 
        $req["where"] = [ "type = 1" ];
        $req["order"] = "updated DESC";
        $this->template = "front/singlePost";
        break;
      default :
        if (Tools::$debug) die("can't create new post object from $from");
        break;
    }

    //make request in order to get data 
    $this->data = Model::select( $req );
    switch ($this->data["succeed"]) {
      case true:
        $this->data = $this->data['data'];
        break;
      
      default:
        if (Tools::$debug) die("/!\ you need modify PostCtrl in order to support unsuccessful request".var_dump($this->data));
        break;
    }

  }

  public function getListPostsFrom($from, $pageNumber){
    // if( count($safeData['address']) >2 ) return ErrorManager::page400();
    // return "todo : PostCtrl->getListPostsFrom()";
    return $this->view->insertArticles( $this->getLastOnes() );
  }

  public function getPagination($idPost){
    return $this->view->pagination( $this->data->getPagination($idPost) );
  }

  public function getPost($url){
    return $this->view->singlePost($this->data->getPost($url));
  }

  private function getLastOnes(){
    $req = [
      "data"  => [
        'ID',
        'title AS "{{ title }}"',
        'content AS "{{ content }}"',
        'url AS "{{ postUrl }}"',
        'DATE_FORMAT(published, \'%d/%m/%Y\') AS "{{ published }}"',
        'DATE_FORMAT(updated, \'%d/%m/%Y\') AS "updated"'
      ],
      "where" => [ "type = 1" ],
      "from"  => "posts",
      "order" => "updated DESC",
      "limit" => $this->postQty
    ];
    $this->data = Model::select( $req );
  }

  protected function singlePost($specs){
    //$specs could have key url, id



    die("simplePost".var_dump($specs));

    return $this->view->singlePost($this->data->getPost($safeData['address'][1]));
  }



}