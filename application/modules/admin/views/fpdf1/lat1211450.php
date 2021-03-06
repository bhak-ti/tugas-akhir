<?php
//Koneksi
$host = "localhost";
$user = "root";
$pass = "";
$dbnm = "toko_komputer";
$conn = mysqli_connect($host,$user,$pass);
if ($conn) {
	$open = mysqli_select_db($conn,$dbnm);
	if (!$open) {
		die ("database tidak dapat dibuka".mysqli_error());
	}
} else {
	die ("Server mysql tidak terhubung".mysqli_error());
}
//akhir koneksi
//ambil data
$query = "SELECT id_brg,nm_brg,merk,stok,harga FROM tb_brg ORDER BY id_brg";
$sql = mysqli_query($conn,$query);
$data = array();
while ($row = mysqli_fetch_assoc($sql)){
	array_push($data, $row);
}
//setting judul
$judul = "Laporan Data barang";
$header = array (
	array ("label"=>"KODE","length"=>25,"align"=>"L"),
	array ("label"=>"NAMA BARANG","length"=>100,"align"=>"L"),
	array ("label"=>"MERK","length"=>25,"align"=>"L"),
	array ("label"=>"STOK","length"=>25,"align"=>"L"),
	array ("label"=>"HARGA","length"=>20,"align"=>"L"),
	
);
require_once ("cobafpdf/fpdf.php");
$pdf = new FPDF();
$pdf->AddPage();
//tampil judul
$pdf->SetFont('Arial','B','16');
$pdf->Cell(0,20,$judul,'0',1,'C');

//buat header tabel
$pdf->SetFont('Arial','','10');
$pdf->SetFillColor(255,0,0);
$pdf->SetTextColor(255);
$pdf->SetDrawColor(128,0,0);
foreach ($header as $kolom){
	$pdf->Cell($kolom['length'],5,$kolom['label'],1,'0',$kolom['align'],true);
}
$pdf->Ln();

//tampil data
$pdf->SetFillColor(224,235,255);
$pdf->SetTextColor(0);
$pdf->SetFont('');
$fill=false;
foreach ($data as $baris){
	$i=0;
	foreach ($baris as $cell){
		$pdf->Cell($header[$i]['length'],5,$cell,1,'0',$kolom['align'],$fill);
		$i++;
	}
	$fill = !$fill;
	$pdf->Ln();
}
//output
$pdf->Output();
?>