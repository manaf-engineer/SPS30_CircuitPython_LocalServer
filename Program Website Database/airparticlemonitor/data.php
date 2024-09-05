<?php
  //koneksi database
  $konek = mysqli_connect("localhost", "root", "", "airparticlemonitor");

  //baca data dari tabel tb_sensor

  //baca data ID tertinggi
  $sql_ID = mysqli_query($konek, "SELECT MAX(ID) FROM tb_sensor");
  //tangkap datanya
  $data_ID = mysqli_fetch_array($sql_ID);
  //ambil data terbesar
  $ID_akhir = $data_ID['MAX(ID)'];
  $ID_awal = $ID_akhir - 49;

  /*FOR THE REFERENCE
  //baca info pm10 untuk semua data - sumbu Y di grafik
  $pm10 = mysqli_query($konek, "SELECT pm10 FROM tb_sensor ORDER BY ID ASC");
  FOR THE REFERENCE*/
  //baca info tanggal untuk 5 data terakhir - sumbu X di grafik
  $tanggal = mysqli_query($konek, "SELECT datetime FROM tb_sensor WHERE ID>='$ID_awal'
  and ID<='$ID_akhir' ORDER BY ID ASC");
  //baca info pm10 untuk 5 data terakhir - sumbu Y di grafik
  $pm10 = mysqli_query($konek, "SELECT pm10 FROM tb_sensor WHERE ID>='$ID_awal'
  and ID<='$ID_akhir' ORDER BY ID ASC");
  //baca info pm25 untuk 5 data terakhir - sumbu Y di grafik
  $pm25 = mysqli_query($konek, "SELECT pm25 FROM tb_sensor WHERE ID>='$ID_awal'
  and ID<='$ID_akhir' ORDER BY ID ASC");
  //baca info pm40 untuk 5 data terakhir - sumbu Y di grafik
  $pm40 = mysqli_query($konek, "SELECT pm40 FROM tb_sensor WHERE ID>='$ID_awal'
  and ID<='$ID_akhir' ORDER BY ID ASC");
  //baca info pm100 untuk 5 data terakhir - sumbu Y di grafik
  $pm100 = mysqli_query($konek, "SELECT pm100 FROM tb_sensor WHERE ID>='$ID_awal'
  and ID<='$ID_akhir' ORDER BY ID ASC");
?>

<!-- tampilan grafik -->
 <div class="panel panel-primary">
  <div class="panel-heading">
    <h4>Particulate Matter Sensor (µg/m³)</h4>
  </div>

  <div class="panel-body">
    <!-- siapkan canvas untuk grafik -->
     <canvas id="myChart"></canvas>

    <!-- gambar grafik -->
     <script>
      //baca ID canvas tempat grafik akan diletakkan
      var canvas = document.getElementById('myChart');
      //letak data tanggal dan pm10 dan semua data untuk grafik
      var data = {
        labels : [
          <?php
            while($data_tanggal = mysqli_fetch_array($tanggal))
            {
              echo '"'.$data_tanggal['datetime'].'",';   //["20-08-2024", "21-08-2024"]
            }
          ?>
        ],
        datasets : [
        {
          label : "PM1.0",
          fill : true,
          backgroundColor : "rgba(255, 101, 101, .3)",
          borderColor : "rgba(255, 0, 0, 1)",
          lineTension : 0.1,
          pointRadius : 5,
          data : [
            <?php
              while($data_pm10 = mysqli_fetch_array($pm10))
              {
                echo $data_pm10['pm10'].',';
              }
            ?>
          ]
        },
        {
          label : "PM2.5",
          fill : true,
          backgroundColor : "rgba(255, 225, 40, .3)",
          borderColor : "rgba(255, 225, 0, 1)",
          lineTension : 0.1,
          pointRadius : 5,
          data : [
            <?php
              while($data_pm25 = mysqli_fetch_array($pm25))
              {
                echo $data_pm25['pm25'].',';
              }
            ?>
          ]
        },
        {
          label : "PM4.0",
          fill : true,
          backgroundColor : "rgba(0, 245, 100, .3)",
          borderColor : "rgba(0, 245, 0, 1)",
          lineTension : 0.1,
          pointRadius : 5,
          data : [
            <?php
              while($data_pm40 = mysqli_fetch_array($pm40))
              {
                echo $data_pm40['pm40'].',';
              }
            ?>
          ]
        },
        {
          label : "PM10.0",
          fill : true,
          backgroundColor : "rgba(37, 134, 207, .3)",
          borderColor : "rgba(0, 0, 255, 1)",
          lineTension : 0.1,
          pointRadius : 5,
          data : [
            <?php
              while($data_pm100 = mysqli_fetch_array($pm100))
              {
                echo $data_pm100['pm100'].',';
              }
            ?>
          ]
        }
        ]
      };

      //opsion grafik
      var option = {
        showLines : true,
        animation : {duration : 0}
      };

      //cetak grafik kedalam canvas
      var myLineChart = Chart.Line(canvas, {
        data : data,
        options : option
      });

     </script>

  </div>
 </div>