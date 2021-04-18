<?php
@ob_start();
session_start();
if(!isset($_SESSION['user'])){
    header('Location: login.php');
}
require_once("db/config.php");
$dbname = $_SESSION['db'];
$db = new PDO("mysql:host=$db_host;dbname=$dbname", $db_user, $db_pass);
if (isset($_POST['submit'])) {
    $length = 6;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $kode = '';
    for ($i = 0; $i < $length; $i++) {
        $kode .= $characters[rand(0, $charactersLength - 1)];
    }

    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
    $sql = "UPDATE jadwal_matakuliahs set kode=(:kode),kehadiran = kehadiran+1 where jadwal_matkul_id=(:id)";
    $stmt = $db->prepare($sql);
    $params = array(
        ":id" => $id,
        ":kode" => $kode,
    );
    // print_r($id);die();
    $saved = $stmt->execute($params);
    // die(print_r($stmt->errorInfo(), true));
    if($saved) header("Location: presensi.php");
}
elseif (isset($_POST['absen'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
    $sql = "UPDATE jadwal_matakuliahs set kehadiran = kehadiran+1 where jadwal_matkul_id=(:id)";
    $stmt = $db->prepare($sql);
    $params = array(
        ":id" => $id,
    );
    $saved = $stmt->execute($params);
    if($saved) header("Location: presensi.php");
}
elseif (isset($_POST['check'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
    $kode = $_POST['kode'];
    $stmt = $db->query("SELECT kode from jadwal_matakuliahs where jadwal_matkul_id=$id");
    $tmp = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($tmp[0]['kode']==$kode){
        print_r('asd');
        $sql = "INSERT into kehadirans (mahasiswas_id,jadwal_matkul_id,tanggal) VALUES (:mahasiswas_id, :id, now())";
        $stmt = $db->prepare($sql);
        $params = array(
            ":mahasiswas_id" => $_SESSION['user']['id'],
            ":id" => $id,
        );
        $saved = $stmt->execute($params);
        if($saved) header("Location: presensi.php");
    }
    else{
        echo '<script language="javascript">';
        echo 'alert("Kode Absen Salah!");window.location = "presensi.php"';
        echo '</script>';
    }
}
else{
    if(isset($_SESSION['mahasiswa'])){
     $user_id = $_SESSION['user']['id'];   
     $stmt = $db->query("SELECT b.matakuliahs_id,b.jadwal_matkul_id,d.nama,c.hari,c.jam_mulai,c.jam_selesai FROM ambil_matakuliahs a INNER JOIN jadwal_matakuliahs b ON a.jadwal_matkul_id = b.jadwal_matkul_id INNER JOIN jadwals c ON b.jadwals_id = c.id INNER JOIN matakuliahs d ON d.id = b.matakuliahs_id WHERE mahasiswas_id = $user_id");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    elseif(isset($_SESSION['dosen'])){
     $user_id = $_SESSION['user']['dosen_id'];      
         $stmt = $db->query("SELECT b.matakuliahs_id,b.jadwal_matkul_id,d.nama,c.hari,c.jam_mulai,c.jam_selesai FROM jadwal_matakuliahs b INNER JOIN jadwals c ON b.jadwals_id = c.id INNER JOIN matakuliahs d ON d.id = b.matakuliahs_id WHERE d.dosen_id = $user_id");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
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

    <title>Presensi - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="assets/index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Presensi</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="/">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Main Menu
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <?php
            if(!isset($_SESSION['db'])){
            ?>
            <li class="nav-item">
                <a href="fakultas.php" class="nav-link">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>List Fakultas</span>
                </a>

            </li>

            <li class="nav-item">
                <a href="fakultas.php" class="nav-link">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>List Jurusan</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Other Menu
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="assets/#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>DAC</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="assets/login.html">User Fakultas</a>
                        <a class="collapse-item" href="assets/register.html">User Jurusan</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="assets/charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>User</span></a>
            </li>
            <?php    
            }
            ?>  
            

            <!-- Nav Item - Tables -->
            <li class="nav-item active" >
                <a class="nav-link" href="presensi.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Presensi</span></a>
            </li>

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

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="assets/#" id="searchDropdown" role="button"
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

                        


                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="assets/#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?=$_SESSION['user']['username']?>
                                </span>
                                <img class="img-profile rounded-circle"
                                    src="assets/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="assets/#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="assets/#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                 <div class="container-fluid" style="padding-top: 2%">

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">List Presensi</h6>
                        </div>
                        <div class="card-body">
                            <div class="row" style="margin-bottom: 2%"></div>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>

                                        <tr>
                                            <th>No</th>
                                            <th>Mata Kuliah</th>
                                            <th>Hari</th>
                                            <th>Jam</th>
                                            <th>Jumlah Kehadiran</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Mata Kuliah</th>
                                            <th>Hari</th>
                                            <th>Jam</th>
                                            <th>Jumlah Kehadiran</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $i=1;
                                            foreach ($rows as $row) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?=$i?>
                                                    </td>
                                                    <td>
                                                        <?=$row['nama']?>
                                                    </td>
                                                    <td>
                                                       <?=$row['hari']?>
                                                    </td>
                                                    <td>
                                                        <?=$row['jam_mulai']?>-<?=$row['jam_selesai']?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if(isset($_SESSION['mahasiswa'])){
                                                            $stmt = $db->query("SELECT count(kehadiran_id) from kehadirans where jadwal_matkul_id=$row[jadwal_matkul_id] and mahasiswas_id=$user_id");
                                                        $kehadiran = $stmt->fetchAll(PDO::FETCH_NUM);
                                                        }
                                                        else{
                                                        $stmt = $db->query("SELECT kehadiran,kode from jadwal_matakuliahs where jadwal_matkul_id=$row[jadwal_matkul_id]");
                                                        $kehadiran = $stmt->fetchAll(PDO::FETCH_NUM);
                                                        }
                                                        echo $kehadiran[0][0];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        

<button class="btn btn-primary"  type="button" data-toggle="modal" data-target="#modalAbsen<?=$i?>">
                                        Absen
                                    </button>  

<div class="modal fade" id="modalAbsen<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Absen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
        if(isset($_SESSION['mahasiswa'])){
    ?>
<form action="" method="POST">
            <input type="hidden" name="id" value="<?=$row['jadwal_matkul_id']?>">
            <label>Kode Absen</label>
            <input type="text" class="form-control" name="kode">
            <input type="submit" name="check" value="Submit Kode" class="btn btn-success" style="margin-top: 2%">
        </form>
    <?php            
        }
        elseif(isset($_SESSION['dosen'])){
            ?>
<form action="" method="POST">
            <input type="hidden" name="id" value="<?=$row['jadwal_matkul_id']?>">
            <label>Kode Absen</label>
            <input type="text" class="form-control" name="kode" value="<?=$kehadiran[0][1]?>" disabled>
            <input type="submit" name="submit" value="Generate Absen" class="btn btn-success" style="margin-top: 2%">
        </form>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?=$row['jadwal_matkul_id']?>">
            <input type="submit" name="absen" value="Absen Saja" class="btn btn-warning" style="margin-top: 2%">
        </form>
            <?php
        }
        ?>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



                                                    </td>
                                                </tr>
                                                <?php
                                            $i++;
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

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="assets/#page-top">
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
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="assets/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="assets/js/demo/chart-area-demo.js"></script>
    <script src="assets/js/demo/chart-pie-demo.js"></script>

</body>

</html>