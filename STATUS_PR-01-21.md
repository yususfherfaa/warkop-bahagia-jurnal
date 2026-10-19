# Status PR-01 sampai PR-21

Status ini merangkum implementasi yang tercatat di Git dan verifikasi yang bisa dilakukan tanpa membuka `.env` atau menjalankan SQL pada database.

| PR | Status | Alasan |
| --- | --- | --- |
| PR-01 | selesai | Generator sintetis, pipeline KNN, baseline, dan metrik tersedia di riwayat. |
| PR-02 | selesai | Flask, API PHP, dan penanganan zona waktu tercatat di commit. |
| PR-03 | sebagian | Perubahan skema dan migrasi keamanan tersedia; migrasi database belum dijalankan. |
| PR-04 | selesai | Perbaikan aksi dan perlindungan CSRF tercatat di riwayat; pengujian runtime penuh termasuk verifikasi akhir. |
| PR-05 | selesai | Role filter dan hardening login tercatat di riwayat. |
| PR-06 | selesai | Validasi upload, XSS, dan input tercatat di commit PR-06. |
| PR-07 | selesai | Token akses pesanan dan pembuatan ID aman tercatat di riwayat. |
| PR-08 | selesai | Dokumentasi dan hygiene repository tercatat di riwayat. |
| PR-09 | selesai | Pembersihan skema dan status pesanan tercatat di riwayat. |
| PR-10 | selesai | Pembatasan role pada halaman admin tercatat di riwayat. |
| PR-11 | selesai | Constraint dan dokumentasi skema tercatat di riwayat. |
| PR-12 | selesai | Dokumentasi dataset sintetis dan reproduksi ML tercatat di riwayat. |
| PR-13 | sebagian | Kode pembatalan dan file migrasi tersedia; migrasi serta alur pemulihan stok belum diuji terhadap salinan database. |
| PR-14 | sebagian | 10 uji unit lulus (14 assertion); transaksi checkout/pembayaran nyata dan koneksi Flask hidup/mati belum diuji terhadap layanan/database aktif. |
| PR-15 | sebagian | Konfigurasi dan contoh pengguna database tersedia; header HTTP, honeypot, dan alur checkout belum diverifikasi lewat server. |
| PR-16 | sebagian | Pengelolaan opsi lunak, aktivasi ulang, CSRF, dan filter opsi aktif tersedia; alur UI/database belum diuji secara manual. |
| PR-17 | sebagian | Penyapuan escaping dan penghapusan berkas cadangan tercatat; payload XSS manual belum dijalankan pada aplikasi aktif. |
| PR-18 | sebagian | Ekspor dan evaluasi database telah dibuat; uji ditunda karena tidak ada konfigurasi database yang boleh digunakan dan dependensi NumPy belum tersedia. |
| PR-19 | sebagian | Ambang kepercayaan dan fallback jam sepi tercatat; evaluasi ML resmi ulang belum dapat dijalankan tanpa NumPy/scikit-learn. |
| PR-20 | sebagian | Pencatatan dan laporan admin tersedia serta migrasi SQL dibuat; tabel belum diterapkan sehingga logging tetap opsional/nonaktif sampai migrasi dijalankan. |
| PR-21 | selesai | Laporan audit lanjutan tersedia di `audit_lanjutan.md`; PR ini hanya meminta audit. |

## Gerbang rilis

PR-22 belum dapat dinyatakan lulus: migrasi dan alur manual pada salinan database, pengujian keamanan runtime, serta evaluasi ML dan endpoint Flask belum tervalidasi. Karena itu tag `v1.0.0` belum dibuat.
