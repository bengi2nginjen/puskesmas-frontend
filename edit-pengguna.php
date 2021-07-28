<?php
include_once("connection.php");
include_once("APIHelper.php");
$conn = createConnection();
session_start();
if (!isset($_SESSION['user_username']) && (!isset($_SESSION['user_access_token']) || !isset($_SESSION['user_refresh_token']))) {
    header('Location:index.php');
}
if ($_SESSION['user_isAdmin'] == false) {
    header('Location:dashboard.php');
}
if (isset($_GET['id'])) {
    $userid = $_GET['id'];
    $token = $_SESSION['user_access_token'];
    $refreshToken = $_SESSION['user_refresh_token'];
    $getUserResponse = GETDataJSON("User/GetUserForEdit/?userid=" . $userid, $token);
    $users = null;
    if ($getUserResponse->HTTPResponseCode == 200) {
        // print_r($getUserResponse);
        $response = json_decode($getUserResponse->HTTPResponseObject);
        if ($response->ResponseCode == 0) {
            $users = $response->ResponseObject;
            // print_r($users);
        }
    } else if ($getUserResponse->HTTPResponseCode == 401 || $getUserResponse->HTTPResponseCode == 400) {
        $newToken = refreshUserToken($refreshToken);
        $_SESSION['user_access_token'] = $newToken;
        $getUserResponseNew = GETDataJSON("User/GetUserForEdit/?userid=" . $userid, $newToken);
        if ($getUserResponseNew->HTTPResponseCode == 200) {
            $response = json_decode($getUserResponseNew->HTTPResponseObject);
            if ($response->ResponseCode == 0) {
                $users = $response->ResponseObject;
                // print_r($users);
            }
        } else {
            header('Location:500.php');
        }
    } else {
        header('Location:500.php');
    }
} else {
    header('Location:dashboard.php');
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
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-plus"></i>
                </div>
                <div class="sidebar-brand-text mx-3">PUSKESMAS SENTOLO II</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Area Pengguna
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="daftar-form.php">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Daftar Form</span></a>
            </li>

            <?php
            if ($_SESSION['user_isAdmin'] == true) { ?>
                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Area Admin
                </div>
                <!-- BUAT FORM -->
                <li class="nav-item">
                    <a class="nav-link" href="buat-form.php">
                        <i class="fas fa-fw fa-pencil-ruler"></i>
                        <span>Buat Form</span></a>
                </li>

                <!-- BUAT PENGGUNA -->
                <li class="nav-item">
                    <a class="nav-link" href="buat-pengguna.php">
                        <i class="fas fa-fw fa-user"></i>
                        <span>Buat Pengguna</span></a>
                </li>

                <!-- DATA PENGGUNA -->
                <li class="nav-item active">
                    <a class="nav-link" href="data-pengguna.php">
                        <i class="fas fa-fw fa-table"></i>
                        <span>Data Pengguna</span></a>
                </li><?php
                    }
                        ?>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- PUSKESMAS SENTOLO II -->
                    <div>
                        <h5 class="h5 mb-0 text-gray-600">PUSKESMAS SENTOLO II</h5>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <strong>
                                        <?php
                                        if ($_SESSION['user_isAdmin'] == true) {
                                            echo "ADMIN";
                                        } else {
                                            echo "KADER";
                                        }
                                        ?>
                                    </strong>
                                </span>
                            </a>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo ucwords($_SESSION['user_name']); ?>
                                </span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Keluar
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">
                        <a href="data-pengguna.php" class="h3 mb-2 text-gray-800">Data Pengguna</a>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-compact-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6.776 1.553a.5.5 0 0 1 .671.223l3 6a.5.5 0 0 1 0 .448l-3 6a.5.5 0 1 1-.894-.448L9.44 8 6.553 2.224a.5.5 0 0 1 .223-.671z" />
                        </svg>Ubah Data Pengguna
                    </h1>
                    <!-- <p class="mb-4">Chart.js is a third party plugin that is used to generate the charts in this theme.
                        The charts below have been customized - for further customization options, please visit the <a
                            target="_blank" href="https://www.chartjs.org/docs/latest/">official Chart.js
                            documentation</a>.</p> -->

                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-xl-8 col-lg-7">
                            <div class="user">
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="user-username" name="username" placeholder="Username" value=<?php echo $users->username ?>>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="user-name" name="username" placeholder="Nama Kader" value=<?php echo $users->nama ?>>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="user-jabatan" name="jabatan" placeholder="Jabatan" value=<?php echo $users->jabatan ?>>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" name="password" id="user-password" placeholder="Password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" name="password-confirm" id="user-password-confirm" placeholder="Ulangi Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <?php
                                        if ($users->isAdmin == true) {
                                            echo '<input type="checkbox" class="custom-control-input" id="user-isadmin" name="isadmin" checked>';
                                        } else {
                                            echo '<input type="checkbox" class="custom-control-input" id="user-isadmin" name="username"name="isadmin">';
                                        }
                                        ?>
                                        <label class="custom-control-label" for="user-isadmin">Admin</label>
                                    </div>
                                </div>
                                <input type="hidden" id="user-id" name="id" value="<?php echo $users->id ?>">
                                <button class="btn btn-primary btn-user btn-block" id="submit-form">
                                    Ubah Pengguna
                                </button>
                                <a href="data-pengguna.php" class="btn btn-secondary btn-user btn-block" id="batal">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Puskesmas Sentolo II 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin untuk keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih tombol "Keluar" untuk keluar dari akun anda.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-primary" href="logout.php">Keluar</a>
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
<script>
    $(document).ready(function() {
        $('#submit-form').on('click', function() {
            var nama = $('#user-name').val();
            var username = $('#user-username').val();
            var password = $('#user-password').val();
            var jabatan = $('#user-jabatan').val();
            var id = $('#user-id').val();
            var isAdmin = false;
            if ($('#user-isadmin').is(':checked')) {
                isAdmin = true;
            }
            var passwordConfirm = $('#user-password-confirm').val();
            if (password == "") {
                var request = {
                    id: id,
                    nama: nama,
                    username: username,
                    jabatan: jabatan,
                    isAdmin: isAdmin
                }
                $.ajax({
                    method: "POST",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    url: "https://www.puskesmas-sentolo2.com/edituser.php",
                    data: JSON.stringify(request),
                    success: function(data) {
                        alert(data.ResponseMessage);
                        if (data.ResponseCode == 0) {
                            window.location = 'data-pengguna.php';
                        }
                    },
                    statusCode: {
                        400: function() {
                            alert('error');
                        },
                        500: function() {
                            alert('server error');
                        }
                    }
                });
                // $("#edit-form").ajaxSubmit({url: 'edituser.php', type: 'post'})
            } else {
                var request = {
                    id: id,
                    nama: nama,
                    username: username,
                    password: password,
                    jabatan: jabatan,
                    isAdmin: isAdmin
                }
                if (password == passwordConfirm) {
                    $.ajax({
                        method: "POST",
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        url: "https://www.puskesmas-sentolo2.com/edituser.php",
                        data: JSON.stringify(request),
                        success: function(data) {
                            alert(data.ResponseMessage);
                            if (data.ResponseCode == 0) {
                                window.location = 'data-pengguna.php';
                            }
                        },
                        statusCode: {
                            400: function() {
                                alert('error');
                            },
                            500: function() {
                                alert('server error');
                            }
                        }
                    });
                    // $("#edit-form").ajaxSubmit({url: 'edituser.php', type: 'post'})
                } else {
                    alert("Password tidak sama!");
                }
            }
        });
    });
</script>

</html>