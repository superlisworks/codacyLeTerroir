<?php

//language by default
Lang::$defaultLang = "fr";

//database connexion
Model::$user       = 'devUser';
Model::$password   = 'devPassword';
Model::$base       = 'php-mvc';

//environnement production
Tools::$debug      = true;