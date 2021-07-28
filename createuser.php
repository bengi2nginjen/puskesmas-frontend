<?php
include_once("connection.php");
include_once("APIHelper.php");
// $conn = createConnection();
session_start();
if (!isset($_SESSION['user_username']) && (!isset($_SESSION['user_access_token']) || !isset($_SESSION['user_refresh_token']))) {
    header('HTTP/1.1 401 Unauthorized');
}
if ($_SESSION['user_isAdmin'] == false) {
    header('HTTP/1.1 403 Forbidden');
}
$inputJSON = file_get_contents('php://input');
if(!$inputJSON){
    header('HTTP/1.1 400 Bad Request');
}
$token = $_SESSION['user_access_token'];
$refreshToken = $_SESSION['user_refresh_token'];
$getUserResponse = POSTDataJSON($inputJSON, "User/CreateUser/", $token);
if ($getUserResponse->HTTPResponseCode == 200) {
    // print_r($getUserResponse);
    $response = json_decode($getUserResponse->HTTPResponseObject);
    if ($response->ResponseCode == 0) {
        $ress = $response->ResponseMessage;
        header('Content-Type: application/json');
        echo(json_encode($response));
        // print_r($users);
    }
} else if ($getUserResponse->HTTPResponseCode == 401 || $getUserResponse->HTTPResponseCode == 400) {
    $newToken = refreshUserToken($refreshToken);
    $getUserResponseNew = POSTDataJSON($inputJSON, "User/CreateUser/", $newToken);
    if ($getUserResponseNew->HTTPResponseCode == 200) {
        $response = json_decode($getUserResponseNew->HTTPResponseObject);
        if ($response->ResponseCode == 0) {
            // $users = $response->ResponseObject;
            // // print_r($users);
            $ress = $response->ResponseMessage;
            header('Content-Type: application/json');
            echo(json_encode($response));
        }
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
} else {
    header("HTTP/1.1 500 Internal Server Error");
}
