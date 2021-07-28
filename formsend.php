<?php
include "APIHelper.php";
session_start();

if(isset($_SESSION['user_access_token']) || isset($_SESSION['user_refresh_token'])){
    if ($_SESSION['user_isAdmin'] == false) {
        header('HTTP/1.1 403 Forbidden');
    }
    $token = $_SESSION['user_access_token'];
    $refreshToken = $_SESSION['user_refresh_token'];
    $inputJSON = file_get_contents('php://input');
    if(!$inputJSON){
        header('HTTP/1.1 400 Bad Request');
    }
    $response = POSTDataJSON($inputJSON,"Form/SubmitForm/",$token);
    // echo $token;
    // echo $refreshToken;
    if($response->HTTPResponseCode == 200){
        $ress = json_decode($response->HTTPResponseObject);
        header('Content-Type: application/json');
        echo(json_encode($ress));
    }
    else if($response->HTTPResponseCode == 401 || $response->HTTPResponseCode == 400){
        //try to refresh token and hit the API
        $newToken = refreshUserToken($refreshToken);
        // echo($newToken);
        $response = POSTDataJSON($inputJSON,"Form/SubmitForm/",$newToken);
        if($response->HTTPResponseCode == 200){
            $ress = json_decode($response->HTTPResponseObject);
            header('Content-Type: application/json');
            echo(json_encode($ress));
        }
        else{
            header("HTTP/1.1 500 Internal Server Error");
        }
    }
    else{
        header("HTTP/1.1 500 Internal Server Error");
    }
}
else{
    header('HTTP/1.1 401 Unauthorized');
}

?>