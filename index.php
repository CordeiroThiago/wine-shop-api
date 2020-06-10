<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/Database.php';

if (isset($_GET['url'])) {
    $method = strtolower($_SERVER['REQUEST_METHOD']);
    $folder = "./api/".$_GET['url'];
    $page = $folder."/".$method.".php";
    
    if (file_exists($page)) {
        include($page);
    } else {
        if (is_dir($folder)) {
            if ($method != "options") {
                http_response_code(405);
            }
        } else {
            http_response_code(400);
        }
    }
} else {
    http_response_code(400);
}