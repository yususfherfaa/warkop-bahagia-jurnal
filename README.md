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
    ├── model_knn.pkl               ← Model KNN terlatih
    ├── scaler.pkl                  ← StandardScaler
    ├── le_segmen.pkl               ← Label encoder segmen
    ├── le_kategori.pkl             ← Label encoder kategori
    ├── confusion_matrix.png        ← Visualisasi evaluasi
    ├── eda_distribusi.png          ← Visualisasi EDA
    ├── k_optimization.png          ← Grafik pemilihan K
    └── hasil_evaluasi.txt          ← Ringkasan hasil evaluasi
```

---

## Cara Integrasi ke Warkop yang Sudah Ada

### 1. Install Python dependencies

```bash
pip install scikit-learn pandas numpy joblib matplotlib seaborn
```

### 2. Jalankan pipeline ML (satu kali)

```bash
cd ml/
python3 generate_dataset.py   # buat dataset
python3 ml_model.py           # training model → hasilkan .pkl
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

| Metrik    | Nilai   |
|-----------|---------|
| Algoritma | K-Nearest Neighbor (KNN) |
| Nilai K   | 3       |
| Akurasi   | **90.00%** |
| Precision | 90%     |
| Recall    | 90%     |
| F1-Score  | 90%     |
| Dataset   | 1.000 baris sintetis |
| Split     | 80% train / 20% test |

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

Jalankan migrasi dan seeder setelah menyiapkan database:

```bash
php spark migrate
php spark db:seed MenuMinumanSeeder
```

Seeder menyinkronkan katalog `PRD0000031` sampai `PRD0000042` beserta 18 pilihan rasa Good Day Biasa (panas dan es), Good Day Freeze, dan Es Nutrisari. Seeder juga mengisi deskripsi singkat untuk menu katalog yang tersedia. Seeder aman dijalankan ulang; stok produk yang sudah pernah dipesan tidak di-reset. Pelanggan wajib memilih rasa sebelum menambahkan produk ke keranjang. Pilihan, suhu, dan harga pesanan disimpan sebagai snapshot dan ditampilkan pada rincian kasir serta struk. Varian dapat ditambah, diubah, dinonaktifkan, atau dihapus dari halaman edit menu kasir.

Kategori katalog baru memakai label Kopi Panas, Es Kopi, Es Nutrisari, Minuman Non Kopi, Makanan Berat, dan Cemilan. Produk lama dengan kategori Minuman Kopi tetap dapat dikelola.

---

## Teknologi

- **Backend**: PHP · CodeIgniter 4
- **ML**: Python · scikit-learn (KNN) · pandas · numpy · joblib
- **Database**: MySQL
- **Integrasi**: REST API (JSON) · Fetch API (JavaScript)
