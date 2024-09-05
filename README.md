# Monitoring Air Particle Concentration using PM2.5 Sensor

Proyek ini bertujuan untuk memantau konsentrasi partikel udara (PM2.5) secara real-time menggunakan sensor SPS30 dari Sensirion. Data dari sensor dikirim ke server lokal yang di-hosting menggunakan XAMPP (Apache dan MySQL) melalui koneksi WiFi menggunakan modul ESP32 dengan CircuitPython.

## Fitur Utama
- **Sensor SPS30**: Mengukur konsentrasi partikel udara (PM2.5) dengan akurasi tinggi.
- **Koneksi I2C**: Menghubungkan sensor dengan Mikrokontroller untuk komunikasi data.
- **ESP32**: Mengontrol pembacaan sensor menggunakan CircuitPython dari Adafruit.
- **XAMPP (Apache dan MySQL)**: Digunakan untuk menampilkan dan menyimpan data di server lokal.
- **HTTP GET**: Data dikirim melalui HTTP GET request menggunakan ESP32 dan CircuitPython.

## Persyaratan Hardware
- Raspberry Pi Zero 2W
- Sensor PM2.5 (SPS30) dari Sensirion
- Modul ESP32 dengan dukungan WiFi
- Kabel dan konektor I2C
- Komputer atau server lokal dengan XAMPP

## Persyaratan Software
- CircuitPython dari Adafruit
- Library CircuitPython untuk sensor SPS30
- XAMPP (Apache dan MySQL) untuk server lokal
- WiFi untuk ESP32 di CircuitPython

## Instalasi
1. **Instalasi CircuitPython di ESP32**:
   - Ikuti panduan instalasi CircuitPython [di sini](https://circuitpython.org/).
   - Pastikan ESP32 memiliki PullUp-Resistor untuk akses ke sensor melalui I2C.

2. **Instalasi XAMPP**:
   - Unduh dan instal XAMPP dari [situs resmi](https://www.apachefriends.org/index.html).
   - Konfigurasikan Apache dan MySQL untuk mengaktifkan server lokal.

3. **Instalasi Library**:
   - Unduh library yang diperlukan untuk CircuitPython, termasuk `adafruit_sps30`.

## Koneksi dan Pengaturan
1. **Koneksi I2C**:
   - Sambungkan sensor SPS30 dengan ESP32 menggunakan koneksi I2C (VCC, GND, SDA, dan SCL).

2. **Koneksi WiFi dengan ESP32**:
   - Sambungkan ESP32 dengan WiFi yg sama dengan Laptop untuk koneksi data.
   - Gunakan settings.toml pada ESP32 untuk SSID dan Password.

3. **Pengaturan Server di XAMPP**:
   - Buat database MySQL dan tabel untuk menyimpan data sensor.
   - Aktifkan Services Apache dan mySQL untuk menjalankan webserver.

## Cara Kerja
1. ESP32 membaca data dari sensor SPS30 melalui I2C.
2. Data yang diperoleh disusun menjadi URL.
3. ESP32 mengirim data ke server lokal melalui HTTP GET request.
4. Server menyimpan data di MySQL dan menampilkan hasil pengukuran melalui Apache.

## Contoh Kode
### Pembacaan Data dari Sensor SPS30
```python
import board
import busio
import adafruit_sps30

# Inisialisasi I2C
i2c = busio.I2C(board.SCL, board.SDA)
sensor = adafruit_sps30.SPS30(i2c)

while True:
    if sensor.read():
        print("PM2.5: ", sensor.pm2_5)
```

## Penggunaan
Jalankan ESP32 dan pastikan semua perangkat terhubung dengan benar.
Buka browser dan akses server lokal melalui http://localhost.
Data PM2.5 akan ditampilkan dan disimpan secara real-time.
