<?php
  include "../koneksi.php";
  include "includes/head.php";
  session_start();
  // $sql = "SELECT no FROM buku_kas_umum ORDER BY no DESC LIMIT 1";
  // $query = mysqli_query($conn,$sql);
  // $data = mysqli_fetch_assoc($query);
  // $no = $data['no']+1;
  $no_reg = $_POST['no_reg'];
  $tanggal = $_POST['tanggal'];
  $kd_rek = $_POST['kd_rek'];
  $no_reg = $_POST['no_reg'];
  $uraian = $_POST['uraian'];
  $uang_masuk = $_POST['uang_masuk'];
  $uang_keluar = str_replace(".","",$_POST['uang_keluar']);
  $spjtunai = 0;
  $transfer = 0;
  $bagian = $_POST['bagian'];
  $waktu=strtotime($tanggal);
  $bulan=date("m",$waktu);
  $tahun=date("Y",$waktu);
  $level = $_SESSION['nama_bagian'];

  if ($uang_keluar >= 500000) {
    // echo "here";exit();
    $sql = "SELECT a.id, a.no_reg, a.tanggal, a.bagian, a.uraian, b.jumlah AS jumlah_spj,  SUM(c.jumlah) AS jumlah_transfer, a.kd_rek  FROM buku_kas_umum AS a LEFT JOIN spj_tunai AS b ON a.id = b.id_buku_kas_umum LEFT JOIN transfer AS c ON a.id = c.id_buku_kas_umum WHERE a.bagian = '".$level."' AND MONTH(a.tanggal) = $bulan and YEAR(a.tanggal) = $tahun order by a.no_reg asc ";
    $query_tf = mysqli_query($conn, $sql);
    $data_tf = mysqli_fetch_assoc($query_tf);

    $getdata_panjartf = "SELECT nominal FROM panjar_transfer WHERE id_seksi = '".$_SESSION['id_user']."' AND MONTH(date) = $bulan and YEAR(date) = $tahun ";
    $query = mysqli_query($conn,$getdata_panjartf);
    $datapanjar_tf = mysqli_fetch_assoc($query);
    $transfer += $uang_keluar;
    $saldo_spj_transfer = $datapanjar_tf['nominal'] - $data_tf['jumlah_transfer'];
    // echo $saldo_spj_transfer;exit();
    if($transfer > $datapanjar_tf['nominal']){
      echo "<br>";
      echo "Saldo Tidak Mencukupi<br>";
      echo "<a href='simpan_data.php' class='btn btn-danger'>Kembali</a>";
    }else{
      if($uang_keluar > $saldo_spj_transfer){
        echo "<br>";
        echo "Saldo Tidak Mencukupi<br>";
        echo "<a href='simpan_data.php' class='btn btn-danger'>Kembali</a>";
      }else{
        $sql = "INSERT INTO buku_kas_umum (no_reg,tanggal,bagian, uraian,kd_rek) VALUES ($no_reg,'".$tanggal."','".$bagian."','".$uraian."', '".$kd_rek."')";
        // echo $sql;
        if($conn->query($sql) === TRUE){
          $last_id = $conn->insert_id;
          $sql = "INSERT INTO transfer (id_buku_kas_umum, jumlah) VALUES($last_id, $transfer)";
          // echo $sql;
        }else{
          echo "gagal";
        }
        $query = mysqli_query($conn, $sql);
        if(!$query){
          $error = mysqli_error($conn);
          $_SESSION['error'] = $error;
          header('Location: input_data.php');
          echo $_SESSION['error'];
        }else{
          // echo "berhasil";
          header('Location: tampil.php');
          unset($_SESSION['error']);
        }
      }
    }
  }else{
    $spjtunai += $uang_keluar;
   
    $getdata = "SELECT SUM(b.jumlah) AS jumlah FROM buku_kas_umum AS a INNER JOIN panjar AS b ON a.id = b.id_buku_kas_umum WHERE a.bagian = '".$bagian."' AND MONTH(a.tanggal) = $bulan and YEAR(a.tanggal) = $tahun order by id asc";
    $query = mysqli_query($conn,$getdata);
    $datapanjar = mysqli_fetch_assoc($query);
    $getDataSpj = "SELECT SUM(b.jumlah) AS jumlah_spj FROM buku_kas_umum AS a LEFT JOIN spj_tunai AS b ON a.id = b.id_buku_kas_umum WHERE a.bagian = '".$bagian."' AND MONTH(a.tanggal) = $bulan and YEAR(a.tanggal) = $tahun order by a.tanggal asc ";
    $query2 = mysqli_query($conn,$getDataSpj);
    $spj = mysqli_fetch_assoc($query2);
    $hasil = $datapanjar['jumlah'] - $spj['jumlah_spj'];
    //berfungsi untuk mengecek apakah masih memiliki sisa saldo atau tidak
    if($spj['jumlah_spj'] > $datapanjar['jumlah']){
       echo "<br>";
        echo "Uang keluar melebihi batas<br>";
        echo "<a href='simpan_data.php' class='btn btn-danger'>Kembali</a>";
    }else{
      //berfungsi untuk mengecek apakah uang yang akan dikeluarkan tidak melebihi saldo
      if($uang_keluar > $hasil){
        echo "<br>";
        echo "Uang keluar melebihi batas<br>";
        echo "<a href='simpan_data.php' class='btn btn-danger'>Kembali</a>";
      }else{
        $sql = "INSERT INTO buku_kas_umum (no_reg,tanggal,bagian, uraian, kd_rek) VALUES ($no_reg,'".$tanggal."','".$bagian."','".$uraian."', '".$kd_rek."')";
        if($conn->query($sql) === TRUE){
          $last_id = $conn->insert_id;
          $sql = "INSERT INTO spj_tunai (id_buku_kas_umum,jumlah) VALUES($last_id, $spjtunai)";
        }else{
          echo "gagal";
        }
        $query = mysqli_query($conn, $sql);
        if(!$query){
          $error = mysqli_error($conn);
          $_SESSION['error'] = $error;
          header('Location: input_data.php');
          echo $_SESSION['error'];
        }else{
          header('Location: tampil.php');
          unset($_SESSION['error']);
        }
      }
    }
  }
include "includes/footer.php";
?>
