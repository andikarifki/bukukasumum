<?php
require 'koneksi2.php';
session_start();
    if( isset($_POST["tambah"]) ) {
    // var_dump($_POST);
        if( tambah($_POST) > 0){
        echo"berhasil";
    } else {
        echo"gagal";
    }
}
include_once 'includes/head.php';
include_once 'includes/navbar.php';
?>    
    <div class="container mt-5">
        <div class="text-center">
            <h2>Form Input Kode Rekening Baru</h2>
        </div>
        <form method = 'post' action="">
            <div class="form-group">
                <label for="kd_rek">Kode Rekening</label>
                <input type="text" class="form-control" id="kd_rek" name='kd_rek' size="35" maxlength="50">
                <input type="hidden" name='nama_bagian' size="35" maxlength="30" value="<?php echo $_SESSION['nama_bagian'];?>">
            </div>
            <button type="submit" class="btn btn-success" name="tambah" value="Tambah" onclick="return confirm('Apakah Pengisian Sudah Benar ?')">Tambah</button>
            <button type='button' onclick="window.location.href = 'input_data.php'" value="Lihat" class="btn btn-dark">Lihat</button>
        </form>
        
<?php include_once 'includes/footer.php';?>
