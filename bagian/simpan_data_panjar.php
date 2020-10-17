<?php
include '../koneksi.php';

$tanggal    = $_POST['tanggal'];
// $kd_rek     = $_POST['kd_rek'];
$uraian     = $_POST['uraian'];
$uang_masuk = str_replace(".","",$_POST['uang_masuk']);
$bagian     = $_POST['nama_bagian'];
$waktu=strtotime(date('Y-m-d'));
$bulan=date("m",$waktu);
$tahun=date("Y",$waktu);
$data_transfer = "SELECT bagian FROM buku_kas_umum WHERE bagian = '".$bagian."'  AND MONTH(tanggal) = $bulan and YEAR(tanggal) = $tahun ";
// echo $data_transfer;
$query = mysqli_query($conn,$data_transfer);
$data = mysqli_fetch_assoc($query);
//print_r($data);exit();

if($data['bagian']==""){
    $sql = "INSERT INTO buku_kas_umum (tanggal,bagian, uraian) VALUES ('".$tanggal."','".$bagian."','".$uraian."')";
    if($conn->query($sql) === TRUE){
        $last_id = $conn->insert_id;
        $sql = "INSERT INTO panjar (id_buku_kas_umum, jumlah) VALUES($last_id, $uang_masuk)";
        // echo $sql;
    }else{
        echo "gagal";
    }
    $query = mysqli_query($conn, $sql);
    if(!$query){
    $error = mysqli_error($conn);
    $_SESSION['error'] = $error;
    header('Location: uang_masuk.php');
    echo $_SESSION['error'];
    }else{
    // echo "berhasil";
    header('Location: tampil.php');
    unset($_SESSION['error']);
    }
}else{
    echo "gagal <br>";
    echo "<a href='tampil.php'>Kembali</a>";
}