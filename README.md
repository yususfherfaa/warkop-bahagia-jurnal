# Warkop Bahagia

Aplikasi pemesanan dan kasir berbasis CodeIgniter 4 dengan API rekomendasi menu berbasis waktu menggunakan Flask dan KNN.

## Kebutuhan

- PHP beserta ekstensi yang disyaratkan CodeIgniter 4
- Composer
- MySQL atau MariaDB
- Python 3.12.6 (versi lingkungan evaluasi ML yang tercatat)

## Instalasi aplikasi

1. Pasang dependensi PHP: `composer install`.
2. Salin `.env.example` menjadi `.env`, lalu atur environment, URL aplikasi, dan kredensial database. Jangan commit `.env`.
3. Buat database kosong, misalnya `warkop_bahagia`, kemudian impor skema:

   ```sh
   mysql -u root -p warkop_bahagia < database/schema.sql
   ```

4. Jalankan migrasi CodeIgniter yang tersedia: `php spark migrate`.
5. Buat akun pengguna dan atur konfigurasi/tabel sesuai instalasi. Skema tidak menyertakan akun, password, data pelanggan, atau data awal.
6. Jalankan aplikasi: `php spark serve`.

## Menjalankan API rekomendasi

Buka terminal kedua di root proyek. Buat dan aktifkan virtual environment Python 3.12.6, pasang dependensi, lalu jalankan Flask:

```sh
python -m venv .venv
.venv/Scripts/activate
python -m pip install -r requirements.txt
python ml/app_flask.py
```

Di Linux/macOS, gunakan `source .venv/bin/activate`. Flask mendengarkan di `127.0.0.1:5001`. Model dan artefak yang dibutuhkan berada di `ml/`.

## Struktur direktori

- `app/` — konfigurasi, controller, model, migrasi, seeder, dan view CodeIgniter.
- `database/` — skema bersih dan migrasi SQL manual.
- `ml/` — API Flask, prediksi, model KNN, dataset, dan hasil evaluasi.
- `public/` — entry point web, aset statis, dan direktori upload runtime.
- `writable/` — cache, log, sesi, dan berkas runtime CodeIgniter.

## Hasil evaluasi ML

Angka berikut berasal dari `ml/hasil_evaluasi.txt`. Evaluasi memakai dataset uji yang tercatat dan tidak menjamin performa pada transaksi produksi. Lingkungan: Python 3.12.6, scikit-learn 1.8.0, pandas 2.2.3, numpy 2.1.3, joblib 1.5.3, matplotlib 3.10.9. Dataset berisi 9.017 baris (7.180 latih, 1.837 uji), dengan 279 konteks waktu; K optimum yang tercatat adalah 200.

| Metode | Precision@5 | Recall@5 | Hit Rate@5 |
| --- | ---: | ---: | ---: |
| KNN | 0.271 | 0.249 | 0.771 |
| Terlaris Jam | 0.300 | 0.270 | 0.789 |
| Terlaris Segmen | 0.299 | 0.278 | 0.803 |
| Rule Manual | 0.306 | 0.279 | 0.799 |
| Terlaris Global | 0.212 | 0.185 | 0.624 |
| Acak | 0.125 | 0.116 | 0.473 |

Bootstrap 95% (2.000 iterasi, seed 42) mencatat selisih Precision@5 KNN terhadap terlaris jam −0.029 (CI −0.047 s.d. −0.011), terlaris segmen −0.028 (−0.047 s.d. −0.009), rule manual −0.035 (−0.058 s.d. −0.013), terlaris global +0.059 (+0.032 s.d. +0.085), dan acak +0.146 (+0.118 s.d. +0.176). Sebagian data sintetis memakai bobot awal dari aturan pemilik.

## Data sintetis dan batas klaim

Dataset dibuat oleh `ml/generate_dataset.py`, bukan dikumpulkan dari transaksi pelanggan. Generator mensimulasikan 60 hari mulai 2026-08-03 dengan seed 42, intensitas pesanan Poisson berdasarkan jam, 12% pilihan menu acak, bobot menu dari aturan pemilik, dan percampuran bobot di sekitar pergantian segmen waktu. Karena aturan pemilik ikut membentuk data sintetis, skor terhadap rule manual bersifat sirkular. Hasil evaluasi hanya menggambarkan simulasi tersebut; hasilnya tidak membuktikan dampak pada penjualan nyata. Pada evaluasi tercatat, KNN berada di bawah baseline terlaris per jam, terlaris per segmen, dan rule manual pada Precision@5.

Untuk menjalankan prototipe fase 2 dari root proyek, gunakan seed dan direktori keluaran berikut:

```sh
python prototipe_fase2.py 42 out
```

`prototipe_fase2.py` tidak terdapat di checkout repository ini; perintah tersebut berlaku setelah file prototipe fase 2 disediakan. Pipeline yang tersedia di repository dapat dijalankan dengan `python ml/generate_dataset.py` lalu `python ml/ml_model.py`. Untuk angka yang dipakai dalam naskah, gunakan `ml/hasil_evaluasi.txt` sebagai satu-satunya sumber hasil evaluasi.

Versi paket yang dipatok di `requirements.txt`: scikit-learn 1.8.0, pandas 2.2.3, numpy 2.1.3, joblib 1.5.3, matplotlib 3.10.9, Flask 3.1.1, dan Flask-Cors 5.0.1. Versi Python pada evaluasi tersimpan adalah 3.12.6.

## Catatan database

`database/schema.sql` hanya memuat DDL, termasuk kolom token akses pesanan. Dump lama di root adalah arsip historis dan dapat berisi data; gunakan skema bersih untuk instalasi baru. Migrasi SQL manual di `database/` tidak dijalankan otomatis. Cadangkan database dan tinjau isi migrasi sebelum menjalankannya.

### Pengguna database aplikasi

Buat pengguna khusus aplikasi, bukan `root`. Jalankan perintah berikut melalui klien MariaDB/MySQL sebagai administrator database, ganti placeholder kata sandi, dan batasi haknya ke database aplikasi:

```sql
CREATE USER 'warkop_app'@'localhost' IDENTIFIED BY 'GANTI_DENGAN_PASSWORD_KUAT';
GRANT ALL PRIVILEGES ON `warkop_bahagia`.* TO 'warkop_app'@'localhost';
```

Atur pengguna dan kata sandi yang sama pada `.env` lokal. Berkas `.env.example` tidak berisi rahasia; `.env` tetap dikecualikan oleh `.gitignore`.
