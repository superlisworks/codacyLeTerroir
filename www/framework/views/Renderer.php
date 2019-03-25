<?php

class Renderer {
  protected $data;
  public function __construct($argument){
    $this->data = $argument;
  }
  public function render(){
    if (isset($this->header)) header($this->header);
    return $this->data;
  }
}