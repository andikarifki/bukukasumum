<?php
    session_start();
    include "../koneksi.php";
    include_once 'includes/head.php';
    include_once 'includes/navbar.php';
    $month = date('m');
    $day = date('d');
    $year = date('Y');
    $today = $year . '-' . $month . '-' . $day;
    $query = "SELECT * FROM kode_rekening";
    $result = mysqli_query($conn, $query);
?>
    <div class="container">
        <div class="text-center mt-2">
            <h2>Form Input Data Transaksi Baru</h2>
            <a href="uang_masuk.php"> Pengisian Kas Masuk</a> |
            <a href="input_kdrek.php"> Pengisian kode rekening</a>
        </div></br></br>
        <form method = 'post' action="simpan_data.php">
            <div class="col-12 mx-auto container mb-5">
                <div class="form-group">
                    <label for="no_reg">No Registrasi</label>
                    <input type="text" class="form-control" id="no_reg" name='no_reg' size="35" maxlength="6" placeholder="Masukkan Nomor Registrasi">
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name='tanggal' size="35" maxlength="6" value="<?php echo $today; ?>">
                </div>
                <div class="form-group">
                    <label for="kd_rek">Kode Rekening</label>
                    <select name="kd_rek" id="kd_rek" class="form-control">
                        <?php while($data = mysqli_fetch_assoc($result) ){?>
                            <option value="<?php echo $data['kd_rek']; ?>"><?php echo $data['kd_rek']; ?>&nbsp;<?php echo $data['nama_bagian']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="uraian">Uraian</label>
                    <textarea name="uraian" id="uraian" class="form-control" placeholder="Masukkan Uraian"></textarea>
                </div>
                <div class="form-group">
                    <label for="rupiah">Kas Keluar</label>
                    <input type="text" class="form-control" id="rupiah" name="uang_keluar" placeholder="Masukkan Kas Keluar">  
                </div>
                <input type="hidden" name='bagian' size="35" maxlength="30" value="<?php echo $_SESSION['nama_bagian'];?>">
                <input type="hidden" name='uang_masuk' size="35" maxlength="30" value="0">
                <button type="submit" name="tambah" value="Tambah" class="btn btn-success mr-4" onclick="return confirm('Apakah Pengisian Sudah Benar ?')">Tambah</button>
                <button type='button' onclick="window.location.href = 'tampil.php'" value="Lihat" class="btn btn-dark">Lihat</button>
            </div>
        </form>
    </div>
<?php include_once 'includes/footer.php';?>
