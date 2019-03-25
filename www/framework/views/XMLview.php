<?php

require_once "framework/views/Renderer.php";

class XMLview extends Renderer {

  protected $header = "Content-type: text/xml";

  public function __construct($argument){ //override parent constructor
    $xml_data = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
    // function call to convert array to xml
    $xml_data = $this->array_to_xml($argument,$xml_data);
    $this->data = $xml_data->asXML();
  }

  private function array_to_xml( $data, &$xml_data ) { // function defination to convert array to xml
    foreach( $data as $key => $value ) {
      if( is_numeric($key) ){
        $key = 'item'.$key; //dealing with <0/>..<n/> issues
      }
      if( is_array($value) ) {
        $subnode = $xml_data->addChild($key);
        $this->array_to_xml($value, $subnode);
      } else {
        $xml_data->addChild("$key",htmlspecialchars("$value"));
      }
    }
    return $xml_data;
  }
}