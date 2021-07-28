<?php
    include_once("connection.php");
    include_once("APIHelper.php");
    session_start();
    if (isset($_SESSION['user_username']) && (isset($_SESSION['user_access_token']) || isset($_SESSION['user_refresh_token']))) {
        header("Location: dashboard.php");
    }
    $conn=createConnection();
    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        # Our new data
        $data = array(
            'username' => $username,
            'password' => $password
        );
        $dataJson = json_encode($data);
        $response = POSTDataJSON($dataJson,'login/',"");
        // print_r($response);
        if($response->HTTPResponseCode == 200){
            $user = json_decode($response->HTTPResponseObject);
            
            if(!isset($user->access)){
                $newToken = refreshUserToken($user['refresh']);
                $user['access'] = $newToken;
            }
            $_SESSION['user_access_token'] = $user->access;
            $_SESSION['user_refresh_token'] = $user->refresh;
            $_SESSION['user_username'] = $user->username;
            $_SESSION['user_isAdmin'] = $user->isAdmin;
            $_SESSION['user_name'] = $user->nama;
            header("Location: dashboard.php");
        }
        else{
            $detail = json_decode($response->HTTPResponseObject);
            if(isset($detail->detail)){
                echo '<div class="alert alert-danger" role="alert">'.$detail->detail.'</div>';
            }
            else{
                echo '<div class="alert alert-danger" role="alert">General error</div>';
            }            
        }
        // $sql = "SELECT * FROM user WHERE username='$username' and password='$password'";
        // $result = mysqli_query($conn,$sql);
        // $count = mysqli_num_rows($result);
        // $user = mysqli_fetch_assoc($result);

        // if($count == 1){
        //     $_SESSION['name']=$user['nama'];
        //     if($user['isAdmin']==1){
        //         $_SESSION['isAdmin']=true;
        //     }else{
        //         $_SESSION['isAdmin']=false;
        //     }            
        //     header("Location: dashboard.php");
        // }else{
        }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Puskesma Sentolo 2</title>

    <!-- Custom fonts for this template-->
    <link href="js/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-6 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Selamat Datang di Pencatatan Data Puskesmas Sentolo II</h1>
                                    </div>
                                    <form action="index.php" class="user" method="POST">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="exampleInputText" 
                                                placeholder="Username" name="username" required="required">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password" 
                                                name="password" required="required">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" name="submit" class="btn btn-primary btn-user btn-block" value="MASUK">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="js/jquery/jquery.min.js"></script>
    <script src="js/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="js/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>