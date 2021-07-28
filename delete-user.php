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
if (isset($_GET['id'])) {
    $data = array(
        'userid' => $_GET['id']
    );
    $dataJson = json_encode($data);
    $token = $_SESSION['user_access_token'];
    $refreshToken = $_SESSION['user_refresh_token'];
    $getUserResponse = POSTDataJSON($dataJson, "User/DeleteUser/", $token);
    if ($getUserResponse->HTTPResponseCode == 200) {
        // print_r($getUserResponse);
        $response = json_decode($getUserResponse->HTTPResponseObject);
        if ($response->ResponseCode == 0) {
            $ress = $response->ResponseMessage;
            header('location:data-pengguna.php');
            // print_r($users);
        }
    } else if ($getUserResponse->HTTPResponseCode == 401 || $getUserResponse->HTTPResponseCode == 400) {
        $newToken = refreshUserToken($refreshToken);
        $getUserResponseNew = POSTDataJSON($dataJson, "User/DeleteUser/", $newToken);
        if ($getUserResponseNew->HTTPResponseCode == 200) {
            $response = json_decode($getUserResponseNew->HTTPResponseObject);
            if ($response->ResponseCode == 0) {
                // $users = $response->ResponseObject;
                // // print_r($users);
                $ress = $response->ResponseMessage;
                header('location:data-pengguna.php');
            }
        } else {
            header("HTTP/1.1 500 Internal Server Error");
        }
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
}
else{
    header('HTTP/1.1 400 Bad Request');
}
