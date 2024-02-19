<?php
require_once 'alert.php';
    include_once "cek.php";   
    $pdo = include "koneksi.php";
    require "function.php"; //memanggil database
    
    
    function isRegisteredDataSiswa($conn, $id_user, $id_beasiswa) {
        $query = mysqli_query($conn, "SELECT * FROM data_siswa WHERE id_user='$id_user' AND id_beasiswa='$id_beasiswa'");
        return mysqli_num_rows($query) > 0;
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

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">

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
                                <span class="badge badge-danger badge-counter">0</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">0</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                
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
                                <a class="dropdown-item" href="profil.php">
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
                        <h1 class="h3 mb-0 text-gray-800">Data siswa</h1>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Isi Data Siswa</h6>
                            </div>
                                <div class="card-body">
                                    <div class="text-form">
                                    <form method="post">
                                    <div class="form-group">
                                            <label for="exampleInputname">Nama Beasiswa</label>
                                            <select name="nama_beasiswa" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp">
                                                <?php
                                                $ambilsemuadatanya = mysqli_query($conn, "select * from data_beasiswa");
                                                while ($fetcharray = mysqli_fetch_array($ambilsemuadatanya)) {
                                                    $namabarangnya = $fetcharray['nama_beasiswa'];
                                                    $idbarangnya = $fetcharray['id_beasiswa'];
                                                    $deadline_beasiswa = $fetcharray['lineb']; // Ambil deadline beasiswa dari tabel

                                                    // Bandingkan tanggal deadline dengan tanggal saat ini
                                                    $today = date("Y-m-d");
                                                    if ($today <= $deadline_beasiswa) {
                                                ?>
                                                        <option value="<?= $idbarangnya; ?>"><?= $namabarangnya; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>

                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputname">Penghasilan Orang Tua</label>
                                                <select name="p_ortu" class="form-control form-control-user"
                                                    id="exampleInputEmail" aria-describedby="emailHelp">
                                                        <option value="1">>Rp. 3.000.000 = 1</option>
                                                        <option value="2">Rp. 2.500.000 - Rp.2.900.000 = 2 </option>
                                                        <option value="3">Rp. 2.000.000 - Rp.2.400.000 = 3</option>
                                                        <option value="4">Rp. 1.500.000 - Rp.1.900.000 = 4 </option>
                                                        <option value="5">Rp. 1.000.000 - Rp.1.400.000 = 5 </option>
                                                        </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputname">Tanggungan Orang Tua</label>
                                                <select name="t_ortu" class="form-control form-control-user"
                                                    id="exampleInputEmail" aria-describedby="emailHelp">
                                                        <option value="1"> 1 Tanggungan = 1</option>
                                                        <option value="2"> 2 Tanggungan = 2 </option>
                                                        <option value="3"> 3 Tanggungan = 3</option>
                                                        <option value="4"> 4 Tanggungan = 4</option>
                                                        <option value="5"> 5 Tanggungan = 5</option>
                                                        </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputname">Sodara kandung</label>
                                                <select name="s_kandung" class="form-control form-control-user"
                                                    id="exampleInputEmail" aria-describedby="emailHelp">
                                                        <option value="1"> 1 Soadara = 1</option>
                                                        <option value="2"> 2 Soadara = 2 </option>
                                                        <option value="3"> 3 Soadara = 3</option>
                                                        <option value="4"> 4 Soadara = 4</option>
                                                        <option value="5"> 5 Soadara = 5</option>
                                                        </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputname">Niali Semester</label>
                                                <select name="n_sem" class="form-control form-control-user"
                                                    id="exampleInputEmail" aria-describedby="emailHelp">
                                                        <option value="1"> 70 - 75 = 1</option>
                                                        <option value="2"> 76 - 80 = 2 </option>
                                                        <option value="3"> 81 - 85 = 3</option>
                                                        <option value="4"> 86 - 90 = 4</option>
                                                        <option value="5"> 91 - 96 = 5</option>
                                                        </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputname">Peringkat Kelas</label>
                                                <select name="p_kelas" class="form-control form-control-user"
                                                    id="exampleInputEmail" aria-describedby="emailHelp">
                                                        <option value="1"> Peringkat 20-25 = 1</option>
                                                        <option value="2"> Peringkat 15-20 = 2 </option>
                                                        <option value="3"> Peringkat 10-15 = 3</option>
                                                        <option value="4"> Peringkat 6-10 = 4</option>
                                                        <option value="5"> Peringkat 1-5 = 5</option>
                                                        </select>
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block" name="addsiswa">Simpan</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Siswa</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Nama Beasiswa</th>
                                            <th>P Ortu</th>
                                            <th>T Ortu</th>
                                            <th>S Kandung</th>
                                            <th>N semester</th>
                                            <th>P Kelas</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                        <?php
                                        $query = $pdo->prepare("select * from data_siswa s, data_beasiswa b, user u where s.id_beasiswa=b.id_beasiswa and s.id_user=u.id and id_user=:id_user");
                                        $i = 1;
                                        $query->execute(array('id_user' => $_SESSION['user']['id']));
                                        while($user = $query->fetch()) { 
                                        ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?php echo $user['nama'];?></td>
                                            <td><?php echo $user['nama_beasiswa'];?></td>
                                            <td><?php echo $user['p_ortu'];?></td>
                                            <td><?php echo $user['t_ortu'];?></td>
                                            <td><?php echo $user['s_kandung'];?></td>
                                            <td><?php echo $user['n_sem'];?></td>                                            
                                            <td><?php echo $user['p_kelas'];?></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
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