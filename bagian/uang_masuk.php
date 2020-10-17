<?php
    include "../koneksi.php";
    include_once "includes/head.php";
    include_once "includes/navbar.php";
?>
<?php
$month = date('m');
$day = date('d');
$year = date('Y');
$today = $year . '-' . $month . '-' . $day;
session_start();
?>
    <div class="container text-center mt-5">
        <h2>Form Input Panjar</h2>        
    </div>
    <form method = 'post' action="simpan_data_panjar.php">
        <div class="container mt-5">
            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="date" name='tanggal' size="35" maxlength="30" id="tanggal" value="<?php echo $today; ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="rupiah">Nominal</label>
                <input type='text' name='uang_masuk' id="rupiah" size='35' maxlength='30' class="form-control" required="">
            </div>
            <input type="hidden" name='nama_bagian' size="35" maxlength="30" value="<?php echo $_SESSION['nama_bagian'];?>">
            <input type="hidden" name='uraian' size="35" maxlength="30" value="PANJAR">
            <button type="submit" name="tambah" value="Tambah" onclick="return confirm('Apakah Pengisian Sudah Benar ?')" class="btn btn-success ">Tambah</button>
            <button type='button' onclick="window.location.href = 'tampil.php'" value="Lihat" class="btn btn-dark">Lihat</button>
        </div>
    </form>
<?php include_once "includes/footer.php";?>