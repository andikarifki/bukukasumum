<?php
include '../koneksi.php';
session_start();
include_once 'includes/head.php';
include_once 'includes/navbar.php';
?>
<div class="container mt-5  mb-5">
    <div class="alert alert-primary" role="alert">
        Selamat Datang Di Buku Kas Umum Kecamatan Pakualaman
    </div>
    <div class="text-center">
        <h2 >Buku Kas Bagian</h2>
        <h2 ><?php echo $_SESSION['nama_bagian_lengkap'];?></h2>
     
    </div>
    <div class="col-12 mt-5">
        <div class="float-left">
            <form method="post" action="tampil.php" id="tahunBulan">
                <input type="month" name="tahun" placeholder="Pilih Bulan Dan Tahun">
                <button type="submit" name="masuk" class="btn btn-info btn-sm" value="tampilkan">Tampil</button>
            </form>
        </div>
        <div class="float-right">
            <a href="input_data.php" class="btn btn-success"><i class="fas fa-plus mr-1"></i>Tambah Baru</a>
        </div>
    </div><br><br>
    <?php 
        if (isset($_POST['masuk'])): 
        $tampildata = $_POST['tahun'];
        $_SESSION['bulan_pilih'] = $tampildata;
        $waktu=strtotime($tampildata);
        $bulan=date("m",$waktu);
        $tahun=date("Y",$waktu);
        $level = $_SESSION['nama_bagian'];
       //echo $level;
    ?>
    <table class="table table-bordered">
        <thead>
        <?php
            $sqlpanjar = "SELECT SUM(b.jumlah) AS jumlah FROM buku_kas_umum AS a INNER JOIN panjar AS b ON a.id = b.id_buku_kas_umum WHERE a.bagian = '".$level."' AND MONTH(a.tanggal) = $bulan and YEAR(a.tanggal) = $tahun order by id asc";
            $query3 = mysqli_query($conn,$sqlpanjar);
            $datapanjar = mysqli_fetch_assoc($query3);

            $id_user = $_SESSION['id_user'];
            $sql_transfer = "SELECT nominal FROM panjar_transfer WHERE id_seksi = $id_user  AND MONTH(date) = $bulan and YEAR(date) = $tahun ";
            $query4 = mysqli_query($conn,$sql_transfer);
            $data_transfer = mysqli_fetch_assoc($query4);
            //echo $sqlpanjar;
        ?>

            <h4 class="font-weight-bold text-center"><?php echo $tampildata;?></h4> 
            <tr>
                <th scope="col" colspan="5">Total Anggaran</th>
                <th scope="col" colspan="2">Rp <?php echo number_format($datapanjar['jumlah']+$data_transfer['nominal'], 0, ".", ".");?></th>
            </tr>
            <tr>
                <th scope="col" colspan="5">Panjar Bulan Ini</th>
                <th scope="col" colspan="2">Rp <?php echo number_format($datapanjar['jumlah'], 0, ".", ".");?></th>
            </tr>
            <tr>
                <th scope="col" colspan="5">Anggaran Transfer</th>
                <th scope="col" colspan="2">Rp <?php echo number_format($data_transfer['nominal'], 0, ".", ".");?></th>
            </tr>
            <tr>
                <th scope="col">No Reg</th>
                <th scope="col" class="th-tanggal">Tanggal</th>
                <th scope="col">Kode Rek</th>
                <th scope="col">Bagian</th>
                <th scope="col">Uraian</th>
                <th scope="col">SPJ Tunai</th>
                <th scope="col">Transfer</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            $sql = "SELECT a.id, a.no_reg, a.tanggal, a.bagian, a.uraian, b.jumlah AS jumlah_spj,  c.jumlah AS jumlah_transfer, a.kd_rek  FROM buku_kas_umum AS a LEFT JOIN spj_tunai AS b ON a.id = b.id_buku_kas_umum LEFT JOIN transfer AS c ON a.id = c.id_buku_kas_umum WHERE a.bagian = '".$level."' AND MONTH(a.tanggal) = $bulan and YEAR(a.tanggal) = $tahun order by a.no_reg asc ";
            $query = mysqli_query($conn, $sql);
            $error = mysqli_error($conn);
            $uang_keluar = 0;
            $transfer = 0;
            while($data = mysqli_fetch_assoc($query)){
        ?>
            <tr>
                <?php if($data['no_reg'] != null):?>
                    <td><?php echo $data['no_reg'];?></td>
                <?php else:?>    
                    <td>-</td>
                <?php endif;?>
                <td><?php echo date("d-M-Y" ,strtotime($data['tanggal']));?></td>
                <?php if($data['kd_rek'] != null):?>
                    <td><?php echo $data['kd_rek'];?></td>
                <?php else:?>    
                    <td>-</td>
                <?php endif;?>
                <td><?php echo $data['bagian'];?></td>
                <td><?php echo $data['uraian'];?></td>
                <td><?php echo number_format($data['jumlah_spj'],0,'.','.');?></td>
                <td><?php echo number_format($data['jumlah_transfer'],0,'.','.');?></td>
            </tr>
        <?php
            $uang_keluar += $data['jumlah_spj'];
            $transfer += $data['jumlah_transfer'];
            }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6">Saldo SPJ TUNAI</td>
                <td><?php echo number_format($datapanjar['jumlah']-$uang_keluar, 0, ".", "."); ?></td>
            </tr>
            <tr>
                <td colspan="6">Saldo SPJ TRANSFER</td>
                <td><?php echo number_format($data_transfer['nominal']-$transfer, 0, ".", "."); ?></td>
            </tr>
            <tr>
                <td colspan="6">SALDO YANG TERSISA</td>
                <td><?php echo number_format(($datapanjar['jumlah']-$uang_keluar)+($data_transfer['nominal']-$transfer), 0, ".", "."); ?></td>
            </tr>
            <tr>
                <td colspan="6">Total SPJ Tunai</td>
                <td><?php echo number_format($uang_keluar, 0, ".", "."); ?></td>
            </tr>
            <tr>
                <td colspan="6">Total Transfer</td>
                <td><?php echo number_format($transfer, 0, ".", "."); ?></td>
            </tr>
        </tfoot>
    </table>
    <?php endif; ?>
    <?php if (isset($_POST['masuk'])) : ?>
        <form method='post' action='print2.php'>
            <input type='hidden' name='waktu' value="<?php echo $tahun-$bulan; ?>">
            <button type='submit' name='print' value='Print Data' class="btn btn-dark">Print Data</button>
        </form>
    <?php endif;?>
</div>
    
<?php include_once 'includes/footer.php';?>
