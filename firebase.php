<?php 
require 'vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

$factory = (new Factory)
    ->withServiceAccount('kortambayan-firebase-adminsdk-fbsvc-7cc12d768a.json');

$auth = $factory->createAuth();
?>