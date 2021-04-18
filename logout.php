<?php
session_start();
if(isset($_SESSION['mahasiswa'])){
	$redirect = 'login_mahasiswa.php';
}
elseif (isset($_SESSION['dosen'])) {
	$redirect = 'login_dosen.php';
}
else{
	$redirect = 'login.php';
}
session_destroy();
header("Location: ".$redirect);
?>