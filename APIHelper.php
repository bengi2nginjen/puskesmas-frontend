<?php

class HttpApiResponse{
    public $HTTPResponseCode;
    public $HTTPResponseObject;
}

function POSTDataJSON($data, $url, $JWTToken)
{
    $BASE_URL = "https://puskesmas-sentolo2-api.herokuapp.com/api/";
    # Create a connection
    $url = $BASE_URL . $url;
    $ch = curl_init($url);
    # Form data string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    // Set HTTP Header for POST request 
    if ($JWTToken == "") {
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
    } else {
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data),
                'Authorization: Bearer '. $JWTToken
            )
        );
    }

    # Get the response
    $response = curl_exec($ch);
    if ($response === false)
{
    // throw new Exception('Curl error: ' . curl_error($crl));
    print_r('Curl error: ' . curl_error($ch));
}

    $responseModel = new HttpApiResponse();
    $responseModel->HTTPResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $responseModel->HTTPResponseObject = $response;
    curl_close($ch);
    return $responseModel;
}
function GETDataJSON($url, $JWTToken)
{
    $BASE_URL = "https://puskesmas-sentolo2-api.herokuapp.com/api/";
    # Create a connection
    $url = $BASE_URL . $url;
    $ch = curl_init($url);
    # Form data string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);

    // Set HTTP Header for GET request 
    if ($JWTToken == "") {
        // curl_setopt(
        //     $ch,
        //     CURLOPT_HTTPHEADER,
        //     array(
        //         'Content-Type: application/json',
        //         'Content-Length: ' . strlen($data)
        //     )
        // );
    } else {
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                // 'Content-Type: application/json',
                // 'Content-Length: ' . strlen($data),
                'Authorization: Bearer '. $JWTToken
            )
        );
    }

    # Get the response
    $response = curl_exec($ch);
    $responseModel = new HttpApiResponse();
    $responseModel->HTTPResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $responseModel->HTTPResponseObject = $response;
    curl_close($ch);
    return $responseModel;
}

function refreshUserToken($refreshTokenStr){
    $data = array(
        'refresh' => $refreshTokenStr,
    );
    $request = json_encode($data);
    $response = POSTDataJSON($request,"token/refresh/","");
    if($response->HTTPResponseCode == 200){
        $token = json_decode($response->HTTPResponseObject);
        // session_start();
        $_SESSION['user_access_token'] = $token->access;
        return $token->access;
    }
}