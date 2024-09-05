<?php
  //koneksi ke database
  $konek = mysqli_connect("localhost", "root", "", "airparticlemonitor");

  //tangkap parameter yg dikirimkan uC
  $pm10 = $_GET['pm10'];
  $pm25 = $_GET['pm25'];
  $pm40 = $_GET['pm40'];
  $pm100 = $_GET['pm100'];

  //simpan ke tabel tb_sensor
  //atur ID selalu dari 1
  mysqli_query($konek, "ALTER TABLE tb_sensor AUTO_INCREMENT=1");
  //simpan nilai ke tabel tb_sensor
  $simpan = mysqli_query($konek, "INSERT INTO tb_sensor(pm10, pm25, pm40, pm100)
  VALUES('$pm10', '$pm25', '$pm40', '$pm100')");

  //beri respon ke uC
  if($simpan)
    echo "Successful";
  else
    echo "Unsuccessful";

?>