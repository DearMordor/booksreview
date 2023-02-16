<?php
$pathToAppDir = '../app/';
// Load config 
require_once $pathToAppDir . 'config/config.php';

// Load session helper 
require_once $pathToAppDir . 'helpers/session_helper.php';

// Load libs
require_once $pathToAppDir . 'libs' . '/Controller.php';
require_once $pathToAppDir . 'libs' . '/Database.php';
require_once $pathToAppDir . 'libs' . '/Main.php';

// Init Main class 
$init = new Main();
