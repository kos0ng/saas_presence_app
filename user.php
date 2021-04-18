<?php
@ob_start();
session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);
require_once("db/config.php");
if(isset($_POST['tambah'])){
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $tipe = filter_input(INPUT_POST, 'tipe', FILTER_SANITIZE_STRING);

    $sql = "INSERT INTO users (username,password,role) VALUES (:username, :password, :tipe)";
    $stmt = $db->prepare($sql);
    $params = array(
        ":username" => $username,
        ":password" => password_hash($password, PASSWORD_DEFAULT),
        ":tipe" => $tipe,
    );
    $saved = $stmt->execute($params);
    if($saved) header("Location: user.php");
}
elseif (isset($_POST['ubah'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $tipe = filter_input(INPUT_POST, 'tipe', FILTER_SANITIZE_STRING);
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
    if($password!=''){
        $sql = "UPDATE users set username=(:username),password=(:password),role=(:tipe) where user_id=(:id)";
        $stmt = $db->prepare($sql);
        $params = array(
            ":username" => $username,
            ":password" => password_hash($password, PASSWORD_DEFAULT),
            ":tipe" => $tipe,
            ":id" => $id,
        );
    }
    else{
        $sql = "UPDATE users set username=(:username),role=(:tipe) where user_id=(:id)";
        $stmt = $db->prepare($sql);
        $params = array(
            ":username" => $username,
            ":tipe" => $tipe,
            ":id" => $id,
        );
    }
    $saved = $stmt->execute($params);
    if($saved) header("Location: user.php");
}
elseif (isset($_POST['hapus'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

    $sql = "DELETE from users where user_id=(:id)";
    $stmt = $db->prepare($sql);
    $params = array(
        ":id" => $id,
    );
    $saved = $stmt->execute($params);
    if($saved) header("Location: user.php");
}
elseif (isset($_POST['kontrol'])) {
    $management_id = filter_input(INPUT_POST, 'management_id', FILTER_SANITIZE_STRING);
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
    $sql = "UPDATE users set management_id=(:management_id) where user_id=(:id)";
    $stmt = $db->prepare($sql);
    $params = array(
        ":management_id" => $management_id,
        ":id" => $id,
    );
    $saved = $stmt->execute($params);
    if($saved) header("Location: user.php");
}
else{
    $stmt = $db->query("SELECT * from users");
    $rows = $stmt->fetchAll(PDO::FETCH_NUM);
    $stmt = $db->query("SELECT * from fakultass");
    $fakultas = $stmt->fetchAll(PDO::FETCH_NUM);
    $stmt = $db->query("SELECT * from jurusanss");
    $jurusan = $stmt->fetchAll(PDO::FETCH_NUM);
    // print_r($rows);die();
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
    <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
            <li class="nav-item ">
                <a class="nav-link" href="index.php">
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
                <a href="jurusan.php" class="nav-link">
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
                        <a class="collapse-item" href="dac_fakultas.php">User Fakultas</a>
                        <a class="collapse-item" href="dac_jurusan.php">User Jurusan</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item active">
                <a class="nav-link" href="user.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>User</span></a>
            </li>
            <?php    
            }
            else{
?>
            <li class="nav-item">
                <a class="nav-link" href="presensi.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Presensi</span></a>
            </li>
<?php
            }
            ?>  
            

            <!-- Nav Item - Tables -->

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
                                <a class="dropdown-item" href="profile.php">
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
                            <h6 class="m-0 font-weight-bold text-primary">List User</h6>
                        </div>
                        <div class="card-body">
                            <div class="row" style="margin-bottom: 2%">
                                <div class="col-md-2">
                                  <button class="btn btn-success"  type="button" data-toggle="modal" data-target="#modalTambah">
                                        Tambah User
                                    </button>  

                                    <!-- Modal -->
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Tambah User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
            <label>Username</label>
            <input type="text" name="username" class="form-control">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
            <label>Tipe User</label>
            <select name="tipe" class="form-control">
                <option value="1">Admin</option>
                <option value="2">User Fakultas</option>
                <option value="3">User Jurusan</option>
            </select>
            <input type="submit" name="tambah" value="Tambah" class="btn btn-success" style="margin-top: 2%">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Username</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Username</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                            foreach ($rows as $row) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?=$row[0]?>
                                                    </td>
                                                    <td>
                                                        <?=$row[1]?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if($row[3]==1){
                                                            echo 'Admin';
                                                        }
                                                        elseif ($row[3]==2) {
                                                            echo 'User Fakultas';
                                                        }
                                                        else{
                                                            echo 'User Jurusan';   
                                                        }
                                                        ?>  
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-warning"  type="button" data-toggle="modal" data-target="#modalUbah<?=$row[0]?>">
                                        Ubah
                                    </button>  

<div class="modal fade" id="modalUbah<?=$row[0]?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Ubah Jurusan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?=$row[1]?>">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
            <input type="hidden" name="id" value="<?=$row[0]?>">
            <label>Tipe User</label>
            <select name="tipe" class="form-control">
                <option value="1" <?php if($row[3]==1){ echo 'selected';}?> >Admin</option>
                <option value="2" <?php if($row[3]==2){ echo 'selected';}?> >User Fakultas</option>
                <option value="3" <?php if($row[3]==3){ echo 'selected';}?> >User Jurusan</option>
            </select>
            <input type="submit" name="ubah" value="Ubah" class="btn btn-success" style="margin-top: 2%">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
                                                        <button class="btn btn-danger"  type="button" data-toggle="modal" data-target="#modalHapus<?=$row[0]?>">
                                        Hapus
                                    </button>  

<div class="modal fade" id="modalHapus<?=$row[0]?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Ubah Fakultas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
            <label>Hapus Fakultas <?=$row[1]?> ?  </label>
            <input type="hidden" name="id" value="<?=$row[0]?>">
            <input type="submit" name="hapus" value="Hapus" class="btn btn-danger" style="margin-top: 2%">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php
if($row[3]!=1){
?>
<button class="btn btn-primary"  type="button" data-toggle="modal" data-target="#modalKontrol<?=$row[0]?>">
                                        Akses Kontrol
                                    </button>  

<div class="modal fade" id="modalKontrol<?=$row[0]?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Akses</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
            <label>Tambah Akses</label>
            <input type="hidden" name="id" value="<?=$row[0]?>">
            <select name="management_id" class="form-control">
            <?php
            if($row[3]==2){
                foreach ($fakultas as $row_f) {
                 ?>
                 <option value="<?=$row_f[0]?>"><?=$row_f[1]?></option>
                 <?php   
                }
            }
            else{
             foreach ($jurusan as $row_f) {
                 ?>
                 <option value="<?=$row_f[0]?>"><?=$row_f[1]?></option>
                 <?php   
                }   
            }
            ?>
            </select>
            <input type="submit" name="kontrol" value="Ubah" class="btn btn-danger" style="margin-top: 2%">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php    
}
?>


                                                    </td>
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

    <script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="assets/js/demo/datatables-demo.js"></script>

</body>

</html>