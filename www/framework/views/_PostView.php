<?php
require_once "framework/views/PageView.php";

class PostView extends PageView {
  
  // public function __construct($argument) {
  //   # code...
  // }

  public function insertArticles($modelData){
    //check model data
    if ( ! $modelData["succeed"] ) return ErrorManager::page503($modelData["data"]);
    
    $htmlBlock = "";
    foreach ($modelData["data"] as $post) {
      //add update date if necessary
      if ($post["{{ published }}"] != $post["updated"]) $post["{{ published }}"] .= " <em>mis à jour le ".$post['updated']."</em>";

      //reduce title length
      $post["{{ content }}"] = substr ( $post["{{ content }}"], 0, 200)."[...]";

      //add language
      $post["{{ lang }}"] = Lang::$lang;

      //merge with template
      $htmlBlock .= "\n".$this->mergeWithTemplate($post, "insertArticle");
    }
    return '<section class="posts">'.$htmlBlock.'</section>';//.$this->getPagination($pageNumber);
  }

  private function pagination($postPerPage){    
    return "-no pagination yet-";
  }

  public function singlePost($modelData){
    //check model data
    if ( ! $modelData["succeed"] ) return ErrorManager::page503($modelData["data"]);

    //simplify data's manipulation
    $modelData = $modelData["data"];

    //return view
    return [
      "{{ content }}"    => $this->mergeWithTemplate($modelData, "singlePost"),
      "{{ title }}"      => $modelData["{{ title }}"]
    ]; 
  }
}

?>