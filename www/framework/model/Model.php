<?php

class Model {

  public static  $base;
  private static $db;
  public static  $password;
  public static  $user;
  
  static function delete(){
  }

  static function init(){
    self::$db = new PDO(
      'mysql:host=localhost; dbname='.self::$base.';charset=utf8',
      self::$user,
      self::$password
    );
    if (Tools::$debug) self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    self::$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  }

  static function insert($req){
   /***********
    example of use : 
    $req = [
      "data"  => [
        'name' => $username,
        'address' => $address
      ],
      "functions" =>[
        'date' => 'NOW()'
      ],
      "into"  => "posts"
    ];
    ************/

    $value_columns    = array_keys($req["data"]);
    $value_parameters = array_map(function($col) {return (':' . $col);}, $value_columns);

    if ( isset( $req["functions"] ) ) {
      $value_columns    = array_merge( $value_columns,    array_keys($req["functions"]   ) );
      $value_parameters = array_merge( $value_parameters, array_values($req["functions"] ) );
    }

    $value_columns    = implode(', ', $value_columns);
    $value_parameters = implode(', ', $value_parameters);
    return self::request("INSERT INTO ".$req['into']." ($value_columns) VALUES ($value_parameters)", $req["data"]);
  } 

  static function select($req){              // build an sql request from args array

    // main things :
    $sql  = 'SELECT '.implode(", ", $req["data"]);
    $sql .= " FROM ".$req["from"];

    // optional things :
    // WHERE
    if (isset($req["where"])) $sql .= ' WHERE '.implode(" AND ", $req["where"]);

    // ORDER BY
    if (isset($req["order"])) $sql .= " ORDER BY ".$req["order"];

    // LIMIT
    if (isset($req["limit"])) $sql .= " LIMIT ".$req["limit"];

    // launch request and return result
    return self::request($sql);
  }

  private static function request($sql, $data=NULL) {
    try {
      if ($data == NULL) {                     // query
        $resultat = self::$db->query($sql);
      }
      else {                                   // prepare and execute
        $resultat = self::$db->prepare($sql);
        $resultat->execute($data);
      }

      if (substr ( $sql, 0, 6 ) == "SELECT" ){
        $data = $resultat->fetchAll();         // store result
        switch (count($data)) {
          case 0:
            $data = NULL;
            break;
          case 1:
            $data=$data[0];                    // if there is only one answer we keep it instead of an array
            break;          
          // default:
          //   break;
        }
      }
      else $data = NULL;                       // no data to return 
      $resultat->closeCursor();                // close request
      
      return [
        "succeed" => TRUE,
        "data"    => $data
      ];
    }
    catch(Exception $e) {
      if (Tools::$debug) die("Exception".$e);
      return [
        "succeed" => FALSE,
        "data"    => $e
      ];
    }
  }

  static function update(){

  }
}