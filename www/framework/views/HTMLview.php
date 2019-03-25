<?php

class HTMLview {
  public  $html;
  public function __construct($source){ //override parent constructor
    switch (gettype($source)) {
      case 'object':
        $this->html = $this->makeHtml($source->data, $source->template);
        break;
      case 'array':
        $this->html = $this->makeHtml($source['data'], $source['template']);
        break;      
      default:
        if (Tools::$debug) die("type not supported for making a new HTMLview");
        break;
    }
  }

  private function makeHtml($data,$template){
    switch (isset($array['data'][0])) {
      case true:
        return $this->mergeSeveralWithTemplate($data, $template);
        break;
      
      default:
        return $this->mergeWithTemplate($data, $template);
        break;
    };
  }

  private function mergeWithTemplate($args, $template){
    return str_replace(
      array_keys($args),
      $args,
      file_get_contents("project/views/template/$template.html")
    );
  }

  private function mergeSeveralWithTemplate($data, $template){
    $html = "";
    foreach ($data as $value) {
      $html .= "\n".$this->mergeWithTemplate($value, $template);
    }
    return $html;
  }

  public function render(){
   return $this->html;
  }
}