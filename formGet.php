<?php
include_once("APIHelper.php");
function getForm($formID){
    if (!isset($_SESSION['user_username']) && (!isset($_SESSION['user_access_token']) || !isset($_SESSION['user_refresh_token']))) {
        header('Location:index.php');
    }
    $token = $_SESSION['user_access_token'];
    $refreshToken = $_SESSION['user_refresh_token'];
    $getUserResponse = GETDataJSON("Form/GetForm/?FormId=".$formID, $token);
    $forms = null;
    if ($getUserResponse->HTTPResponseCode == 200) {
        // print_r($getUserResponse);
        $response = json_decode($getUserResponse->HTTPResponseObject);
        if ($response->ResponseCode == 0) {
            $forms = $response->ResponseObject;
            return $forms;
            // print_r($users);
        }
    } else if ($getUserResponse->HTTPResponseCode == 401 || $getUserResponse->HTTPResponseCode == 400) {
        $newToken = refreshUserToken($refreshToken);
        $getUserResponseNew = GETDataJSON("Form/GetForm/?FormId=".$formID, $newToken);
        if ($getUserResponseNew->HTTPResponseCode == 200) {
            $response = json_decode($getUserResponseNew->HTTPResponseObject);
            if ($response->ResponseCode == 0) {
                $forms = $response->ResponseObject;
                return $forms;
                // print_r($users);
            }
        } else {
            header('Location:500.php');
        }
    } else {
        header('Location:500.php');
    }
}
function getAllForms(){
    if (!isset($_SESSION['user_username']) && (!isset($_SESSION['user_access_token']) || !isset($_SESSION['user_refresh_token']))) {
        header('Location:index.php');
    }
    $token = $_SESSION['user_access_token'];
    $refreshToken = $_SESSION['user_refresh_token'];
    $getUserResponse = GETDataJSON("Form/GetAll/", $token);
    $forms = null;
    if ($getUserResponse->HTTPResponseCode == 200) {
        // print_r($getUserResponse);
        $response = json_decode($getUserResponse->HTTPResponseObject);
        if ($response->ResponseCode == 0) {
            $forms = $response->ResponseObject;
            return $forms;
            // print_r($users);
        }
    } else if ($getUserResponse->HTTPResponseCode == 401 || $getUserResponse->HTTPResponseCode == 400) {
        $newToken = refreshUserToken($refreshToken);
        $getUserResponseNew = GETDataJSON("Form/GetAll/", $newToken);
        if ($getUserResponseNew->HTTPResponseCode == 200) {
            $response = json_decode($getUserResponseNew->HTTPResponseObject);
            if ($response->ResponseCode == 0) {
                $forms = $response->ResponseObject;
                return $forms;
                // print_r($users);
            }
        } else {
            header('Location:500.php');
        }
    } else {
        header('Location:500.php');
    }
}
?>