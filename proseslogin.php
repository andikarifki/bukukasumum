<?php 
include 'koneksi.php';

$username = $_POST['username'];
$password = md5($_POST['password']);

$login = mysqli_query($conn,"select * from user where username='$username' and password='$password'");
$cek = mysqli_num_rows($login);
$data = mysqli_fetch_assoc($login);
if($cek > 0){
	if($data['bagian'] == "Seksi Perekonomian dan Pembangunan"){
	session_start();
	$_SESSION['username'] = $username;
	$_SESSION['status'] = "login";
	$_SESSION['level']	= "ekobang";
	$_SESSION['nama_bagian'] = "Seksi Ekobang";
	$_SESSION['nama_bagian_lengkap'] = "Seksi Perekonomian dan Pembangunan";
	$_SESSION['nama'] = "Suhardi, S.IP, M.SI";
	$_SESSION['nip'] = "19640727 198603 1 019";
	$_SESSION['id_user'] = 1;
	header("location:bagian/tampil.php");
}else if($data['bagian'] == "Sub Bagian Umum dan Kepegawaian"){
	session_start();
	$_SESSION['username'] = $username;
	$_SESSION['status'] = "login";
	$_SESSION['level'] = "subagumum";
	$_SESSION['nama_bagian'] = "Subagumum";
	$_SESSION['nama_bagian_lengkap'] = "Sub Bagian Umum dan Kepegawaian";
	$_SESSION['nama'] = "Avo Dito Hendra, S.H";
	$_SESSION['nip'] = "19700303 199703 1 008";
	$_SESSION['id_user'] = 2;
	header("location:bagian/tampil.php");
}else if($data['bagian'] == "Bendahara Bagian Keuangan Perencanaan Evaluasi dan Pelaporan Kecamatan"){
	session_start();
	$_SESSION['username'] = $username;
	$_SESSION['status'] = "login";
	$_SESSION['level'] = "keuangan";
	$_SESSION['nama_bagian'] = "Keuangan";
	$_SESSION['nama_bagian_lengkap'] = "Bendahara Bagian Keuangan Perencanaan Evaluasi dan Pelaporan Kecamatan";
	$_SESSION['nama'] = "Cahya Wijayanta, S.Sos";
	$_SESSION['nip'] = "19701119 199603 1 003";
	header("location:keuangan/tampil.php");
}
}else{
	header("location:alert.php");	
}

?>