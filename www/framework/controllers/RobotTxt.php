<?php
class RobotTxt {
    public function getData(){
    $robotTxt = file_get_contents("project/views/template/robot.txt");
    die(" /!\ todo : add sitemap for all available languages in robot.txt");

    return $robotTxt;
  }
}