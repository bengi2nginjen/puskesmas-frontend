<?php
include_once("formGet.php");
include_once("connection.php");
$conn = createConnection();
session_start();
if (!isset($_SESSION['user_username']) && (!isset($_SESSION['user_access_token']) || !isset($_SESSION['user_refresh_token']))) {
    header('Location:index.php');
}
if ($_SESSION['user_isAdmin'] == false) {
    header('Location:dashboard.php');
}
$form = getForm($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap core JavaScript-->
    <script src="js/jquery/jquery.min.js"></script>
    <script src="js/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="js/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script src="js/form.js"></script>

    <script src="js/FormModel.js"></script>
    <!-- Page level plugins -->
    <!-- <script src="js/chart.js/Chart.min.js"></script> -->

    <!-- Page level custom scripts -->
    <!-- <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="js/demo/chart-bar-demo.js"></script> -->
    <title>Puskesma Sentolo 2</title>

    <!-- Custom fonts for this template-->
    <link href="js/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/admin.css" rel="stylesheet">
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
            <li class="nav-item active">
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
                    <div >
                        <div class="row">
                            <div class="col-sm">
                                <h1 class="h3 mb-2 text-gray-800">
                                    <a href="daftar-form.php" class="h3 mb-2 text-gray-800">Daftar Form</a>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-compact-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M6.776 1.553a.5.5 0 0 1 .671.223l3 6a.5.5 0 0 1 0 .448l-3 6a.5.5 0 1 1-.894-.448L9.44 8 6.553 2.224a.5.5 0 0 1 .223-.671z" />
                                    </svg><?php echo $form->name; ?>
                                </h1>
                            </div>
                            <div class="col-sm">
                                
                            </div>
                            <div class="col-sm btn-group">
                                <a href="isi-form.php?id=<?php echo $form->id ?>" class="btn btn-primary" aria-current="page">Isi Form</a>
                                <a href="data-response.php?id=<?php echo $form->id ?>" class="btn btn-primary">Lihat Respon</a>
                                <?php
                                if ($_SESSION['user_isAdmin'] == true) {
                                    echo '<a href="edit-form.php?id='.$form->id.'" class="btn btn-primary active">Ubah Form</a>';
                                    echo '<a href="#" class="btn btn-danger" data-name-form="' . $form->name . '" data-idform="' . $form->id . '" data-toggle="modal" data-target="#deleteFormModal">Hapus Form</a>';
                                } else {
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-7">
                            <div class="user" id="pertanyaan">
                                <div>
                                    <input type="text" class="form-control form-control-user" id="form-title" placeholder="Judul Form" value="<?php echo $form->name ?>">
                                </div>
                                <div class="button-flex-container mt-3">
                                    <textarea type="text" class="form-control form-control-user" id="form-description" placeholder="Deskripsi Form"><?php echo $form->description ?></textarea>
                                </div>
                                <div id="question-section">
                            
                                </div>
                                <div>
                                    <div class="button-flex-container mt-3">
                                        <span class="divider">
                                        </span>
                                        <button id="add-question-edit" class='btn btn-success btn-circle ml-2 mr-2'>
                                            <i class='fas fa-plus'></i>
                                        </button>
                                        <span class="divider">
                                        </span>
                                    </div>
                                </div>
                                <div class="button-flex-container mt-3">
                                    <button id="edit-form" href="#" class="form-control btn btn-primary btn-icon-split">
                                        <span class="text">Ubah Form</span>
                                    </button>
                                </div>
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

    <!-- Hapus Modal-->
    <div class="modal fade" id="deleteFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirm-text-hapus"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih tombol "Hapus" untuk menghapus form tersebut.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-primary delbtn" href="#">Hapus</a>
                </div>
            </div>
        </div>
    </div>

</body>
<script>
    $(document).ready(function(){
        var form = <?php echo json_encode($form); ?> ;
        console.log(form);
        var questionSeqNumber = 1;
        form.questions.forEach(function(question) {
           editQuestion(question.id,question.input[0].type,question.question,question.input); 
           questionSeqNumber = question.id;
        });
        var numQuestion = questionSeqNumber+1;
        $('#add-question-edit').on('click', function () {
            addQuestion(numQuestion);
            numQuestion += 1;
        });
        $('#edit-form').on('click', function () {
            editForm(form.id);
        });
    });

    $('#deleteFormModal').on('show.bs.modal', function(event) {
        var row = $(event.relatedTarget).data('idform');
        var name = $(event.relatedTarget).data('name-form');
        $(this).find(".delbtn").attr('href', "formDelete.php?id=" + row);
        $(this).find("#confirm-text-hapus").html("Apakah anda yakin ingin menghapus form <strong>'" + name + "'</strong>?");
    });
</script>
</html>