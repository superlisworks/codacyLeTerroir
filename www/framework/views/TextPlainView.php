<?php

class TextPlainView{
  private $data;
  public function __construct($argument){
    $this->data = $argument;
  }

  public function getTextPlain($header = false){
    if ($header) header("Content-Type: text/plain");
    return $this->data;
  }
}