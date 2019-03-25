<?php
$routes = [
  // "articles" => "page",
  // "article"  => "showSinglePost",
  "debug"                       => "debug",
  
  ""                             => "home",
  "contact"                      => "contactPage",
  "mentions-legales"             => "singlePost|url=>mentions-legales",
  "ou-sommes-nous"               => "whereToday",
  "panier"                       => "cart",
  "politique-de-confidentialite" => "singlePost|url=>politique-de-confidentialite;test=>wizzz",
  "produits"                     => "showProduct",
  "social"                       => "staticPage|socialMedia"
];
$translation = [
  "baseLine"  => "Bio, cuisiné, à emporter"
];