<?php
date_default_timezone_set('Asia/Jakarta');

// include ("koneksi/koneksi.php");
// $now = new DateTime();
// echo $suhu = $_POST['suhu'];
// echo $kelembaban = $_POST['kelembaban'];
// echo $ruang = $_POST['ruang'];
// echo $id_alat = $_POST['id_alat'];
// // echo $suhu2 = $_POST['suhu2'];
// // echo $kelembaban2 = $_POST['kelembaban2'];
// // $ldrvalue = $_GET['ket'];
// // Ganti Method POST untuk program alternatif DHT22

// $datenow = $now->format('Y-m-d H:i:s');

// //mysqli_query($koneksi, "INSERT INTO vi(waktu,teg,arus,daya) VALUES('$datenow', '$teg' ,'$arus','$daya')");
// $ambil = $koneksi->query("INSERT INTO suhu_kelembaban 
// 						(id, waktu, suhu, kelembaban, ruang, id_alat)
//                          VALUES (NULL, '$datenow', '$suhu', '$kelembaban', '$ruang', '$id_alat') ");

include ('config/connection.php');
$now = new DateTime();
echo $suhu = $_POST['suhu'];
echo $kelembaban = $_POST['kelembaban'];
echo $ruang = $_POST['ruang'];
echo $id_alat = $_POST['id_alat'];
echo $kd_dept = $_POST['kd_dept'];
// echo $suhu2 = $_POST['suhu2'];
// echo $kelembaban2 = $_POST['kelembaban2'];
// $ldrvalue = $_GET['ket'];
// Ganti Method POST untuk program alternatif DHT22

$datenow = $now->format('Y-m-d H:i:s');

//mysqli_query($koneksi, "INSERT INTO vi(waktu,teg,arus,daya) VALUES('$datenow', '$teg' ,'$arus','$daya')");
$ambil = $conn->query("INSERT INTO suhu_kelembaban 
						(id, waktu, suhu, kelembaban, ruang, id_alat, kd_dept)
                         VALUES (NULL, '$datenow', '$suhu', '$kelembaban', '$ruang', '$id_alat', '$kd_dept') ");
?>