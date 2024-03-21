<?php
session_start();
include 'koneksi.php';
$fotoid = $_GET['fotoid'];
$userid = $_SESSION['userid'];

$ceksuka = mysqli_query($koneksi, "SELECT * FROM dislike WHERE fotoid='$fotoid' AND userid='$userid'");
if (mysqli_num_rows($ceksuka)==1) {
	while($row = mysqli_fetch_array($ceksuka)){
		$dislikeid = $row['dislikeid'];
		$query = mysqli_query($koneksi,"DELETE FROM dislike WHERE dislikeid='$dislikeid'");

		echo "<script>
		location.href ='../admin/index.php';
		</script>";
	}

}else{
	$tanggallike = date('Y-m-d');
	$query = mysqli_query($koneksi,"INSERT INTO dislike VALUES('','$fotoid','$userid','$tanggallike')");

	echo "<script>
	location.href ='../admin/index.php';
	</script>";
}

?>