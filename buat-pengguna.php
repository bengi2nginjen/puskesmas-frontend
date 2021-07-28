<?php
include_once("connection.php");
$conn = createConnection();
session_start();
if (!isset($_SESSION['user_username']) && (!isset($_SESSION['user_access_token']) || !isset($_SESSION['user_refresh_token']))) {
    header('Location:index.php');
}
if ($_SESSION['user_isAdmin'] == false) {
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
                <li class="nav-item active">
                    <a class="nav-link" href="buat-pengguna.php">
                        <i class="fas fa-fw fa-user"></i>
                        <span>Buat Pengguna</span></a>
                </li>

                <!-- DATA PENGGUNA -->
                <li class="nav-item">
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
                    <h1 class="h3 mb-2 text-gray-800">Buat Pengguna</h1>
                    <!-- <p class="mb-4">Chart.js is a third party plugin that is used to generate the charts in this theme.
                        The charts below have been customized - for further customization options, please visit the <a
                            target="_blank" href="https://www.chartjs.org/docs/latest/">official Chart.js
                            documentation</a>.</p> -->

                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-xl-8 col-lg-7">
                            <div class="user">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="user-username" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="user-name" placeholder="Nama Kader">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="user-jabatan" placeholder="Jabatan">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" id="user-password" placeholder="Password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" id="user-password-confirm" placeholder="Ulangi Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="user-isadmin">
                                        <label class="custom-control-label" for="user-isadmin">Admin</label>
                                    </div>
                                </div>
                                <button href="" class="btn btn-primary btn-user btn-block" id="submit-form">
                                    Buat Pengguna
                                </button>
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
            var isAdmin = false;
            if ($('#user-isadmin').is(':checked')) {
                isAdmin = true;
            }
            var passwordConfirm = $('#user-password-confirm').val();
            var request = {
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
                    url: "https://www.puskesmas-sentolo2.com/createuser.php/",
                    data: JSON.stringify(request),
                    success: function(data) {
                        alert(data.ResponseMessage);
                        if(data.ResponseCode == "0"){
                            window.location = 'dashboard.php';
                        }
                    },
                });
            } else {
                alert("Password tidak sama!");
            }
        });
    });
</script>

</html>