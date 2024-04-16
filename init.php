<?php

    require 'vendor/autoload.php';
    use App\Connections\SQLConnection;
    use App\Helpers\Alert;

    $pdo = (new SQLConnection)->connect();





    $inc = "template/includes/";