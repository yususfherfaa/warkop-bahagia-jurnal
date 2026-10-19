# Warkop Bahagia — Sistem Rekomendasi Menu Berbasis Waktu (KNN)

Project akhir Kelompok 7 · Kelas 15.5A.05 · UBSI Kaliabang  
Mata Kuliah: Machine Learning (0322) · Kecerdasan Buatan (788) · Penelitian Ilmu Komputer (0312)

---

## Struktur Project

```
warkop_bahagia/
├── app/
│   ├── Controllers/
│   │   └── RekomendasiAPI.php      ← Controller API baru (TAMBAHKAN)
│   ├── Views/
│   │   └── customer/
│   │       └── order.php           ← View yang sudah dimodifikasi (GANTI)
│   └── Config/
│       └── routes_tambahan.php     ← Salin isinya ke Routes.php
│
└── ml/                             ← Folder ML (LETAKKAN di root project)
    ├── generate_dataset.py         ← Step 1: generate dataset
    ├── ml_model.py                 ← Step 2: training & evaluasi model
    ├── predict.py                  ← Step 3: prediksi rekomendasi
    ├── dataset_warkop.csv          ← Dataset hasil generate
    ├── model_knn.joblib            ← Model KNN terlatih & metadata
    ├── confusion_matrix.png        ← Visualisasi evaluasi Top-5 vs Aturan Pemilik
    ├── eda_distribusi.png          ← Visualisasi EDA distribusi jam & segmen
    ├── pemilihan_k.png             ← Grafik pemilihan K (Expanding Window CV)
    ├── perbandingan_metode.png     ← Grafik perbandingan metode (P@5)
    └── hasil_evaluasi.txt          ← Ringkasan lengkap hasil evaluasi
```

---

## Cara Integrasi ke Warkop yang Sudah Ada

### 1. Install Python dependencies

```bash
pip install scikit-learn pandas numpy joblib matplotlib
```

### 2. Jalankan pipeline ML (satu kali)

```bash
cd ml/
python generate_dataset.py   # buat dataset sintetis (60 hari, 24 jam)
python ml_model.py           # evaluasi & training model → hasilkan model_knn.joblib
```

### 3. Tambahkan file ke project CodeIgniter

- **Salin** `app/Controllers/RekomendasiAPI.php` ke folder Controllers proyek
- **Ganti** `app/Views/customer/order.php` dengan versi baru
- **Tambahkan** isi `routes_tambahan.php` ke bagian bawah `app/Config/Routes.php`
- **Salin** seluruh folder `ml/` ke root project (sejajar dengan folder `app/`)

### 4. Ganti nama Warkop

Cari dan ganti string berikut di seluruh project:
- `Warkop KABEHA`  →  `Warkop Bahagia`
- `warkop_kabeha`  →  `warkop_bahagia` (nama database)

### 5. Test API

Buka browser atau gunakan Postman:
```
GET http://localhost:8080/api/rekomendasi
GET http://localhost:8080/api/rekomendasi/jam/8    ← simulasi pagi
GET http://localhost:8080/api/rekomendasi/jam/20   ← simulasi malam
```

---

## Hasil Evaluasi Model

Evaluasi model pada data uji (12 hari terakhir, 279 konteks waktu jam:30):

| Metode / Metrik | Precision@5 | Recall@5 | Hit Rate@5 | Keterangan |
|-----------------|-------------|----------|------------|------------|
| **KNN (K=200)** | **0.271**   | **0.249**| **0.771**  | Fitur siklis sin/cos (24 jam) |
| Terlaris Jam    | 0.300       | 0.270    | 0.789      | Baseline frekuensi per jam |
| Terlaris Segmen | 0.299       | 0.278    | 0.803      | Baseline frekuensi per segmen |
| Rule Manual     | 0.306       | 0.279    | 0.799      | 5 menu pertama aturan pemilik |
| Terlaris Global | 0.212       | 0.185    | 0.624      | Top-5 terpopuler keseluruhan |
| Acak            | 0.125       | 0.116    | 0.473      | Pemilihan acak seragam |

*Catatan Signifikansi (Bootstrap 95% CI):*
- Selisih KNN vs Terlaris Global: **+0.059** (95% CI: +0.032 s.d. +0.085) — KNN secara signifikan mengungguli rekomendasi global tanpa konteks waktu.
- Selisih KNN vs Acak: **+0.146** (95% CI: +0.118 s.d. +0.176) — KNN jauh melampaui baseline acak.
- Selisih KNN vs Terlaris Segmen: **-0.028** (95% CI: -0.047 s.d. -0.009) — performa KNN kompetitif dan mendekati baseline frekuensi segmen.

---

## Logika Rekomendasi

| Segmen Waktu | Jam       | Rekomendasi Utama                          |
|---|---|---|
| Pagi | 05-10 | Nasi Kuning, Nasi Uduk, Lontong Sayur, Bubur Ayam, Kopi Susu, Kopi Hitam, Teh Manis |
| Siang | 11-14 | Ayam Geprek + Nasi, Indomie Goreng Telor, Lemon Tea, Teh Manis, Jeruk |
| Sore | 15-17 | Pancong Keju, Roti Bakar Coklat, Kentang Goreng, Dimsum Mentai |
| Malam | 18-04 | Indomie Rebus Telor, Bubur Kacang Ijo, Nasi Goreng, Kopi Hitam, Kopi Susu, Milo |

---

## Katalog Minuman dan Varian Rasa

### Memuat database project

Dump `db_mysql.sql` berisi skema terbaru dan data awal project. Buat database kosong lalu impor dump:

```sql
CREATE DATABASE warkop_bahagia CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```

```bash
mysql -u root -p warkop_bahagia < db_mysql.sql
```

Nilai kontak, alamat, alamat server, identitas kasir/pelanggan, dan akun pada dump sudah disamarkan untuk publik. Password akun contoh dinonaktifkan. QRIS asli tidak disertakan; atur ulang melalui halaman pengaturan sebelum menerima pembayaran.

Untuk database kosong yang dibuat menggunakan migrasi CodeIgniter, jalankan migrasi dan seeder:

```bash
php spark migrate
php spark db:seed MenuMinumanSeeder
```

Jangan jalankan migrasi pada database yang sudah diimpor dari `db_mysql.sql`; dump tersebut sudah berisi skema terbaru. `db_backup_sebelum_varian.sql` hanya arsip skema/data versi lama.

Migrasi keamanan untuk database lama tersedia terpisah di `database/migrasi_keamanan.sql`. Migrasi ini **tidak dijalankan otomatis** oleh impor dump, `php spark migrate`, atau aplikasi. Sebelum menjalankannya secara manual, buat backup database dan periksa duplikat pada `settings.nama`, `users.username`, serta `payments.id_order` sebagaimana instruksi di dalam file; selesaikan duplikat terlebih dahulu agar constraint unik dapat ditambahkan. Migrasi ini mengubah aturan foreign key, menambah indeks dan kolom `aktif`, serta menyeragamkan ID pengguna.

Seeder menyinkronkan katalog `PRD0000031` sampai `PRD0000042` beserta 18 pilihan rasa Good Day Biasa (panas dan es), Good Day Freeze, dan Es Nutrisari. Seeder juga mengisi deskripsi singkat untuk menu katalog yang tersedia. Seeder aman dijalankan ulang; stok produk yang sudah pernah dipesan tidak di-reset. Pelanggan wajib memilih rasa sebelum menambahkan produk ke keranjang. Pilihan, suhu, dan harga pesanan disimpan sebagai snapshot dan ditampilkan pada rincian kasir serta struk. Varian dapat ditambah, diubah, dinonaktifkan, atau dihapus dari halaman edit menu kasir.

Kategori katalog baru memakai label Kopi Panas, Es Kopi, Es Nutrisari, Minuman Non Kopi, Makanan Berat, dan Cemilan. Produk lama dengan kategori Minuman Kopi tetap dapat dikelola.

---

## Teknologi

- **Backend**: PHP · CodeIgniter 4
- **ML**: Python · scikit-learn (KNN) · pandas · numpy · joblib
- **Database**: MySQL
- **Integrasi**: REST API (JSON) · Fetch API (JavaScript)
