<?php
//inisiasi tanggal hari ini
include ("../koneksi.php");
session_start();
$tampildata = $_POST['waktu'];
$waktu=strtotime($tampildata);
$bulan=date("m",$waktu);
$tahun=date("Y",$waktu);

$month = date('m');
$day = date('d');
$year = date('Y');
$today = 'Yogyakarta, '.$day. ' - ' . $month . ' - ' .$year ;
 $level = $_SESSION['nama_bagian'];
// memanggil library FPDF
require('../assets/plugins/fpdf181/fpdf.php');
// intance object dan memberikan pengaturan halaman PDF
$pdf = new FPDF('L','mm','A4');
// membuat halaman baru
$pdf->AddPage();
// setting jenis font yang akan digunakan
$pdf->SetFont('Arial','B',16);
// mencetak string 
$pdf->Cell(280,7,'BUKU KAS BAGIAN',0,1,'C');
$pdf->Cell(280,7,$_SESSION['nama_bagian_lengkap'],0,1,'C');
$pdf->Cell(10,7,'',0,1);
$pdf->SetFont('Arial','',12);
$pdf->Cell(280,7,'SKPD : KECAMATAN PAKUALAMAN',0,1,'L');
//$sqluser = "select nama from user where bagian = '$level'";
//$queryuser = mysqli_query($conn,$sqluser);
//$datauser = mysqli_fetch_assoc($queryuser);
$pdf->Cell(280,7,"Pengguna Anggaran : ".$_SESSION['nama'],0,1,'L');
$pdf->Cell(280,7,'Bendahara pengeluaran : Diah Hernastiti, A. Md',0,1,'L');
//$pdf->Cell(190,7,'DAFTAR SISWA KELAS IX JURUSAN REKAYASA PERANGKAT LUNAK',0,1,'C');

// Memberikan space kebawah agar tidak terlalu rapat
 $sqlpanjar = "SELECT SUM(b.jumlah) AS jumlah FROM buku_kas_umum AS a INNER JOIN panjar AS b ON a.id = b.id_buku_kas_umum WHERE a.bagian = '".$level."' AND MONTH(a.tanggal) = $bulan and YEAR(a.tanggal) = $tahun order by id asc";
$query3 = mysqli_query($conn,$sqlpanjar);
$datapanjar = mysqli_fetch_assoc($query3);

 $id_user = $_SESSION['id_user'];
$sql_transfer = "SELECT nominal FROM panjar_transfer WHERE id_seksi = $id_user  AND MONTH(date) = $bulan and YEAR(date) = $tahun ";
$query4 = mysqli_query($conn,$sql_transfer);
$data_transfer = mysqli_fetch_assoc($query4);
$pdf->Cell(283,6,"Bulan ".date("M-Y",$waktu),1,0,'C');
$pdf->Cell(10,7,'',0,1);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(214,6,'Total Anggaran : ',1,0,'C');
$pdf->Cell(69,6,number_format($datapanjar['jumlah']+$data_transfer['nominal'],0,'.','.'),1,1,'C');
$pdf->Cell(214,6,'Panjar Bulan Ini : ',1,0,'C');
$pdf->Cell(69,6,number_format($datapanjar['jumlah'],0,'.','.'),1,1,'C');
$pdf->Cell(214,6,'Anggaran Transfer : ',1,0,'C');
$pdf->Cell(69,6,number_format($data_transfer['nominal'],0,'.','.'),1,1,'C');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(10,6,'NO',1,0,'C');
$pdf->Cell(20,6,'NO REG',1,0,'C');
$pdf->Cell(27,6,'TANGGAL',1,0,'C');
$pdf->Cell(40,6,'KODE REKENING',1,0,'C');
$pdf->Cell(36,6,'BAGIAN',1,0,'C');
$pdf->Cell(70,6,'URAIAN',1,0,'C');	
$pdf->Cell(40,6,'SPJ TUNAI',1,0,'C');
$pdf->Cell(40,6,'TRANSFER',1,1,'C');

$pdf->SetFont('Arial','',12);

$sql = "SELECT a.id, a.no_reg, a.tanggal, a.bagian, a.uraian, b.jumlah AS jumlah_spj,  c.jumlah AS jumlah_transfer, a.kd_rek FROM buku_kas_umum AS a LEFT JOIN spj_tunai AS b ON a.id = b.id_buku_kas_umum LEFT JOIN transfer AS c ON a.id = c.id_buku_kas_umum WHERE a.bagian = '".$level."' AND MONTH(a.tanggal) = $bulan and YEAR(a.tanggal) = $tahun order by a.tanggal asc "; 
// $sqlsaldo = "SELECT sum(panjar)-(sum(spj_tunai)) as total, sum(spj_tunai) as totalpengeluaran ,sum(transfer) as totaltransfer FROM buku_kas_umum WHERE bagian = 'Seksi Ekobang' and MONTH(tanggal) = $bulan and YEAR(tanggal) = $tahun";
$query = mysqli_query($conn, $sql);
$uang_keluar = 0;
$transfer = 0;
// $query2 = mysqli_query($conn,$sqlsaldo);
$no = 1;
/**while($data = mysqli_fetch_assoc($query)){
$pdf->Cell(10,10,$no,1,0,'C');
$pdf->Cell(40,10,$data['no_reg'],1,0,'C');
$pdf->Cell(27,10,$data['tanggal'],1,0,'C');
$pdf->Cell(52,10,$data['kd_rek'],1,0,'C');
$pdf->Cell(85,10,$data['uraian'],1,0,'C');
$pdf->Cell(60,10,$data['spj_tunai'],1,1,'C');
$no++;**/
while($data=mysqli_fetch_assoc($query)){
    $cellWidth=70; //lebar sel
	$cellHeight=6; //tinggi sel satu baris normal
	
	//periksa apakah teksnya melibihi kolom?
	// if($pdf->GetStringWidth($data['uraian']) < $cellWidth){
	// 	//jika tidak, maka tidak melakukan apa-apa
	// 	$line=1;
	// }else{
		//jika ya, maka hitung ketinggian yang dibutuhkan untuk sel akan dirapikan
		//dengan memisahkan teks agar sesuai dengan lebar sel
		//lalu hitung berapa banyak baris yang dibutuhkan agar teks pas dengan sel
		$textLength=strlen($data['uraian']);	//total panjang teks
		$errMargin=5;		//margin kesalahan lebar sel, untuk jaga-jaga
		$startChar=0;		//posisi awal karakter untuk setiap baris
		$maxChar=0;			//karakter maksimum dalam satu baris, yang akan ditambahkan nanti
		$textArray=array();	//untuk menampung data untuk setiap baris
		$tmpString="";		//untuk menampung teks untuk setiap baris (sementara)	
		while($startChar < $textLength){ //perulangan sampai akhir teks
			//perulangan sampai karakter maksimum tercapai
			while( 
			$pdf->GetStringWidth( $tmpString ) < ($cellWidth-$errMargin) &&
			($startChar+$maxChar) < $textLength ) {
				$maxChar++;
				$tmpString=substr($data['uraian'],$startChar,$maxChar);
			}
			//pindahkan ke baris berikutnya
			$startChar=$startChar+$maxChar;
			//kemudian tambahkan ke dalam array sehingga kita tahu berapa banyak baris yang dibutuhkan
			array_push($textArray,$tmpString);
			//reset variabel penampung
			$maxChar=0;
			$tmpString='';
			
		}
		//dapatkan jumlah baris
		$line=count($textArray);
		// }
	
	    //tulis selnya
	    $pdf->SetFillColor(255,255,255);
		$pdf->Cell(10,($line * $cellHeight),$no++,1,0,'C',true); //sesuaikan ketinggian dengan jumlah garis
		$pdf->Cell(20,($line * $cellHeight),$data['no_reg'],1,0,'C'); //sesuaikan ketinggian dengan jumlah garis
		$pdf->Cell(27,($line * $cellHeight),$data['tanggal'],1,0);
		$pdf->Cell(40,($line * $cellHeight),$data['kd_rek'],1,0);
		$pdf->Cell(36,($line * $cellHeight),$data['bagian'],1,0);
	//memanfaatkan MultiCell sebagai ganti Cell
	//atur posisi xy untuk sel berikutnya menjadi di sebelahnya.
	//ingat posisi x dan y sebelum menulis MultiCell
	$xPos=$pdf->GetX();
	$yPos=$pdf->GetY();
	$pdf->MultiCell($cellWidth,$cellHeight,$data['uraian'],1);
	
	//kembalikan posisi untuk sel berikutnya di samping MultiCell 
    //dan offset x dengan lebar MultiCell
	$pdf->SetXY($xPos + $cellWidth , $yPos);
	if($data['jumlah_spj'] != ""){
    	$pdf->Cell(40,($line * $cellHeight),number_format($data['jumlah_spj'],0,'.','.'),1,0); //sesuaikan ketinggian dengan jumlah garis
	}else{
		$pdf->Cell(40,($line * $cellHeight),0,1,0); //sesuaikan ketinggian dengan jumlah garis
	}
   
	if($data['jumlah_transfer'] !=""){
    	$pdf->Cell(40,($line * $cellHeight),number_format($data['jumlah_transfer'],0,'.','.'),1,1); //sesuaikan ketinggian dengan jumlah garis
	}else{
		$pdf->Cell(40,($line * $cellHeight),0,1,1); //sesuaikan ketinggian dengan jumlah garis
	}
	$uang_keluar += $data['jumlah_spj'];
	$transfer += $data['jumlah_transfer'];
            
	// }   
}

$pdf->SetFont('Arial','B',12);
$pdf->Cell(214,6,'Saldo SPJ Tunai: ',1,0,'C');
$pdf->Cell(69,6,number_format($datapanjar['jumlah']-$uang_keluar, 0, ".", "."),1,1,'C');
$pdf->Cell(214,6,'Saldo SPJ Transfer : ',1,0,'C');
$pdf->Cell(69,6,number_format($data_transfer['nominal']-$transfer, 0, ".", "."),1,1,'C');
$pdf->Cell(214,6,'Saldo Yang Tersisa : ',1,0,'C');
$pdf->Cell(69,6,number_format(($datapanjar['jumlah']-$uang_keluar)+($data_transfer['nominal']-$transfer), 0, ".", "."),1,1,'C');
$pdf->Cell(214,6,'Total Spj Tunai : ',1,0,'C');
$pdf->Cell(69,6,number_format($uang_keluar, 0, ".", "."),1,1,'C');
$pdf->Cell(214,6,'Total Transfer : ',1,0,'C');
$pdf->Cell(69,6,number_format($transfer, 0, ".", "."),1,1,'C');

$pdf->SetFont('Arial','',12);
$pdf->Cell(10,7,'',0,1);


$pdf->Cell(260,6,$today,0,1,'R');
$pdf->Cell(10,7,'',0,1);
$pdf->Cell(100,6,'Mengetahui :',0,1,'C');
$pdf->Cell(100,6,'Pengguna Anggaran',0,0,'C');
$pdf->Cell(90,6,'',0,0,'C');
$pdf->Cell(87,6,'Bendahara Pengeluaran',0,1,'C');
$pdf->Cell(90,6,'',0,1,'C');
$pdf->Cell(90,6,'',0,1,'C');
$pdf->Cell(90,6,'',0,1,'C');
$pdf->Cell(90,6,'',0,1,'C');
$pdf->Cell(100,6,$_SESSION['nama'],0,0,'C');
$pdf->Cell(90,6,'',0,0,'C');
$pdf->Cell(87,6,'Diah Hernastiti, A. Md',0,1,'C');
$pdf->Cell(100,6,"NIP ".$_SESSION['nip'],0,0,'C');
$pdf->Cell(90,6,'',0,0,'C');
$pdf->Cell(87,6,'NIP. 19890819 201502 2 003',0,1,'C');



$pdf->Output();
?>