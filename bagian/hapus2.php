<?php

include("koneksi2.php");

if( isset($_GET['kd_rek']) ){

    // ambil id dari query string
    $kd_rek = $_GET['kd_rek'];

    // buat query hapus
    $sql = "DELETE FROM tbl_koderek WHERE kd_rek='$kd_rek'";
    $query = mysqli_query($conn,$sql);

    // apakah query hapus berhasil?
    if( $query ){
        header('Location: input_kdrek.php');
    } else {
        die("gagal menghapus...");
    }

} else {
    die("akses dilarang...");
}

?>
