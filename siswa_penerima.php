<?php
    include_once "cek.php";   
    $pdo = include "koneksi.php";
    require "function.php"; //memanggil database

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
     <!-- Kode lainnya seperti yang telah Anda berikan sebelumnya -->


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3"><?php echo  $_SESSION['user']['nama'];?></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="dasboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="datasiswa.php">
                    <i class="fas fa-fw fa-user-alt"></i>
                    <span>Data Siawa</span></a>
            </li>

            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <a class="nav-link" href="siswa_penerima.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Data Siswa Penerima Beasiswa</span></a>
            </li>


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

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <?php
                                $id_user = $_SESSION['user']['id'];
                                $query_notifikasi_count = mysqli_query($conn, "SELECT COUNT(*) AS total FROM notifikasi n, data_siswa s WHERE n.id_siswa=s.id_siswa  and s.id_user = '$id_user'");
                                $notif_count = mysqli_fetch_assoc($query_notifikasi_count)['total'];
                                ?>
                                <span class="badge badge-danger badge-counter" id="notificationCount"><?= $notif_count ?></span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <div id="notificationContent">
                                    <!-- Notifikasi akan muncul di sini -->
                                    <?php
                                        $query_notifikasi = mysqli_query($conn, "SELECT * FROM notifikasi n, data_siswa s WHERE n.id_siswa=s.id_siswa  and s.id_user = '$id_user'");
                                        while ($notif = mysqli_fetch_array($query_notifikasi)) {
                                            echo '<div class="dropdown-item d-flex align-items-center">' .
                                                '<div class="mr-3">' .
                                                '<div class="icon-circle bg-primary">' .
                                                '<i class="fas fa-file-alt text-white"></i>' .
                                                '</div>' .
                                                '</div>' .
                                                '<div>' .
                                                '<div class="small text-gray-500">' . (isset($notif['tanggal']) ? date("Y-m-d", strtotime($notif['tanggal'])) : 'Tanggal Tidak Diketahui') . '</div>' .
                                                '<span class="font-weight-bold">' . $notif['pesan'] . '</span>';
                                                
                                            // Cek jika keterangannya "Dapat Beasiswa" dan siswa terkait
                                            if ($notif['keterangan'] == 'Dapat Beasiswa') {
                                                echo '<a class="btn btn-success btn-sm ml-2" href="persyaratan.php?id=' . $notif['id_siswa'] . '">Isi Berkas Persyaratan</a>';
                                            }

                                            echo '</div>' .
                                                '</div>';
                                        }
                                        ?>
                                    </div>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>


                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <?php
                                $id_user = $_SESSION['user']['id'];
                                $query_notifikasi_count = mysqli_query($conn, "SELECT COUNT(*) AS total FROM notifikasi n, data_siswa s WHERE n.id_siswa=s.id_siswa  and s.id_user = '$id_user'");
                                $notif_count = mysqli_fetch_assoc($query_notifikasi_count)['total'];
                                ?>
                                <span class="badge badge-danger badge-counter"><?= $notif_count ?></span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <div id="notificationContent">
                                    <!-- Notifikasi akan muncul di sini -->
                                    <?php
                                        $query_notifikasi = mysqli_query($conn, "SELECT * FROM notifikasi n, data_siswa s WHERE n.id_siswa=s.id_siswa  and s.id_user = '$id_user'");
                                        while ($notif = mysqli_fetch_array($query_notifikasi)) {
                                            echo '<div class="dropdown-item d-flex align-items-center">' .
                                                '<div class="mr-3">' .
                                                '<div class="icon-circle bg-primary">' .
                                                '<i class="fas fa-file-alt text-white"></i>' .
                                                '</div>' .
                                                '</div>' .
                                                '<div>' .
                                                '<div class="small text-gray-500">' . (isset($notif['tanggal']) ? date("Y-m-d", strtotime($notif['tanggal'])) : 'Tanggal Tidak Diketahui') . '</div>' .
                                                '<span class="font-weight-bold">' . $notif['pesan'] . '</span>';
                                                
                                            // Cek jika keterangannya "Dapat Beasiswa" dan siswa terkait
                                            if ($notif['keterangan'] == 'Selesai') {
                                                echo '<a class="btn btn-success btn-sm ml-2"' . $notif['id_siswa'] . '">Kartu Ujian Bisa Diambil</a>';
                                            }

                                            echo '</div>' .
                                                '</div>';
                                        }
                                        ?>
                                    </div>                                
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo  $_SESSION['user']['nama'];?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="logout.php" >
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Siswa Penerima Beasiswa</h1>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Siswa Penerima</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                            <th>Name Beasiswa</th>
                                            <th>Kode Beasiswa</th>
                                            <th>Nama</th>
                                            <th>keterangan</th>
                                            <th>Hasil</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ambilsemuadatastock = mysqli_query($conn,"select * from p_akhir a, data_beasiswa d, bobot_beasiswa b, user u, data_siswa s where b.id_beasiswa=d.id_beasiswa and s.id_user=u.id and a.keterangan='Dapat Beasiswa'");
                                        while($user=mysqli_fetch_array($ambilsemuadatastock)){
                                        
                                        ?>

                                        <tr>
                                            <td><?php echo $user['nama_beasiswa'];?></td>
                                            <td><?php echo $user['kode_beasiswa'];?></td>
                                            <td><?php echo $user['nama'];?></td>
                                            <td><?php echo $user['keterangan'];?></td>
                                            <td><?php echo $user['hasil'];?></td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>