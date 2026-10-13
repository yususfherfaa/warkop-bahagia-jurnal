"""
generate_dataset.py
===================
Membuat dataset sintetis pola pemesanan Warkop Bahagia
berdasarkan konteks waktu (pagi, siang, malam).

Logika pola pemesanan:
- PAGI   (05:00–10:59) → Makanan berat sarapan, kopi, teh anget
- SIANG  (11:00–14:59) → Makanan berat makan siang, es-esan segar
- SORE   (15:00–17:59) → Cemilan, minuman dingin, santai
- MALAM  (18:00–23:59) → Mie rebus/goreng anget, kopi, teh anget

Output: dataset_warkop.csv
"""

import pandas as pd
import numpy as np
import random
from datetime import datetime, timedelta

random.seed(42)
np.random.seed(42)

# ── Daftar menu dari database ──────────────────────────────────────────────────
MENU = {
    # id_produk: (nama, kategori, harga)
    'PRD0000001': ('Nasi Goreng',           'Makanan Berat',    16000),
    'PRD0000002': ('Indomie Goreng Telor',  'Makanan Berat',    14000),
    'PRD0000003': ('Indomie Rebus Telor',   'Makanan Berat',    14000),
    'PRD0000004': ('Bubur Kacang Ijo',      'Makanan Berat',    12000),
    'PRD0000005': ('Nasi Kucing',           'Makanan Berat',     8000),
    'PRD0000006': ('Pancong Keju',          'Cemilan',          10000),
    'PRD0000007': ('Roti Bakar Coklat',     'Cemilan',           8000),
    'PRD0000008': ('Kentang Goreng',        'Cemilan',          10000),
    'PRD0000009': ('Bakwan 1 Pcs',          'Cemilan',           2000),
    'PRD0000010': ('Tempe 1 Pcs',           'Cemilan',           2000),
    'PRD0000011': ('Tahu 1 Pcs',            'Cemilan',           2000),
    'PRD0000012': ('Dimsum Mentai',         'Cemilan',          15000),
    'PRD0000013': ('Sate Telor 1 Pcs',      'Cemilan',           3000),
    'PRD0000014': ('Sate Usus 1 Pcs',       'Cemilan',           3000),
    'PRD0000015': ('Sate Ati Ampela 1 Pcs', 'Cemilan',           3000),
    'PRD0000016': ('Es Milo',               'Minuman Non Kopi',  7000),
    'PRD0000017': ('Es Jeruk',              'Minuman Non Kopi',  6000),
    'PRD0000018': ('Es Teh Manis',          'Minuman Non Kopi',  5000),
    'PRD0000019': ('Es Lemon Tea',          'Minuman Non Kopi',  7000),
    'PRD0000020': ('Teh Anget Manis',       'Minuman Non Kopi',  4000),
    'PRD0000021': ('Susu Putih',            'Minuman Non Kopi',  6000),
    'PRD0000022': ('Air Mineral',           'Minuman Non Kopi',  2000),
    'PRD0000023': ('Capucinno',             'Minuman Kopi',      8000),
    'PRD0000024': ('Kopi Susu',             'Minuman Kopi',      5000),
    'PRD0000025': ('Kopi Item',             'Minuman Kopi',      3000),
}

# ── Pola probabilitas per segmen waktu ────────────────────────────────────────
# Format: {id_produk: bobot_probabilitas}
# Semakin besar bobot → semakin sering dipesan pada segmen itu

POLA_WAKTU = {
    'pagi': {
        'PRD0000001': 8,   # Nasi Goreng - populer sarapan
        'PRD0000002': 6,   # Indomie Goreng Telor
        'PRD0000003': 7,   # Indomie Rebus Telor - cocok pagi anget
        'PRD0000004': 9,   # Bubur Kacang Ijo - makanan pagi banget
        'PRD0000005': 5,   # Nasi Kucing
        'PRD0000006': 4,   # Pancong Keju
        'PRD0000007': 5,   # Roti Bakar Coklat - sarapan ringan
        'PRD0000008': 2,
        'PRD0000009': 3,
        'PRD0000010': 2,
        'PRD0000011': 2,
        'PRD0000012': 1,
        'PRD0000013': 2,
        'PRD0000014': 2,
        'PRD0000015': 2,
        'PRD0000016': 2,
        'PRD0000017': 2,
        'PRD0000018': 2,
        'PRD0000019': 1,
        'PRD0000020': 9,   # Teh Anget Manis - minuman pagi
        'PRD0000021': 6,   # Susu Putih
        'PRD0000022': 3,
        'PRD0000023': 8,   # Cappuccino - kopi pagi
        'PRD0000024': 9,   # Kopi Susu - favorit pagi
        'PRD0000025': 7,   # Kopi Item
    },
    'siang': {
        'PRD0000001': 10,  # Nasi Goreng - makan siang utama
        'PRD0000002': 8,
        'PRD0000003': 5,
        'PRD0000004': 3,
        'PRD0000005': 7,   # Nasi Kucing
        'PRD0000006': 5,
        'PRD0000007': 3,
        'PRD0000008': 6,   # Kentang Goreng - cocok siang
        'PRD0000009': 5,
        'PRD0000010': 4,
        'PRD0000011': 4,
        'PRD0000012': 6,
        'PRD0000013': 5,
        'PRD0000014': 5,
        'PRD0000015': 5,
        'PRD0000016': 9,   # Es Milo - minuman siang seger
        'PRD0000017': 10,  # Es Jeruk - favorit siang
        'PRD0000018': 9,   # Es Teh Manis
        'PRD0000019': 8,   # Es Lemon Tea
        'PRD0000020': 2,
        'PRD0000021': 4,
        'PRD0000022': 7,   # Air Mineral
        'PRD0000023': 4,
        'PRD0000024': 5,
        'PRD0000025': 3,
    },
    'sore': {
        'PRD0000001': 3,
        'PRD0000002': 3,
        'PRD0000003': 3,
        'PRD0000004': 2,
        'PRD0000005': 4,
        'PRD0000006': 9,   # Pancong Keju - cemilan sore
        'PRD0000007': 8,   # Roti Bakar Coklat
        'PRD0000008': 9,   # Kentang Goreng
        'PRD0000009': 7,   # Bakwan
        'PRD0000010': 6,   # Tempe
        'PRD0000011': 6,   # Tahu
        'PRD0000012': 8,   # Dimsum Mentai
        'PRD0000013': 7,   # Sate Telor
        'PRD0000014': 7,   # Sate Usus
        'PRD0000015': 7,   # Sate Ati Ampela
        'PRD0000016': 7,   # Es Milo
        'PRD0000017': 6,   # Es Jeruk
        'PRD0000018': 6,   # Es Teh
        'PRD0000019': 7,   # Es Lemon Tea
        'PRD0000020': 3,
        'PRD0000021': 4,
        'PRD0000022': 5,
        'PRD0000023': 5,
        'PRD0000024': 5,
        'PRD0000025': 4,
    },
    'malam': {
        'PRD0000001': 7,   # Nasi Goreng - makan malam
        'PRD0000002': 5,
        'PRD0000003': 10,  # Indomie Rebus Telor - favorit malam anget
        'PRD0000004': 3,
        'PRD0000005': 5,
        'PRD0000006': 5,
        'PRD0000007': 4,
        'PRD0000008': 6,
        'PRD0000009': 5,
        'PRD0000010': 4,
        'PRD0000011': 4,
        'PRD0000012': 6,
        'PRD0000013': 5,
        'PRD0000014': 5,
        'PRD0000015': 5,
        'PRD0000016': 3,
        'PRD0000017': 2,
        'PRD0000018': 3,
        'PRD0000019': 2,
        'PRD0000020': 9,   # Teh Anget - minuman malam
        'PRD0000021': 5,
        'PRD0000022': 4,
        'PRD0000023': 8,   # Cappuccino malam
        'PRD0000024': 8,   # Kopi Susu malam
        'PRD0000025': 9,   # Kopi Item - kopi tubruk malam
    },
}

def jam_ke_segmen(jam: int) -> str:
    if 5 <= jam <= 10:
        return 'pagi'
    elif 11 <= jam <= 14:
        return 'siang'
    elif 15 <= jam <= 17:
        return 'sore'
    else:
        return 'malam'

def label_rekomendasi(id_produk: str, segmen: str) -> int:
    """Label 1 = direkomendasikan, 0 = tidak direkomendasikan.
    Menu dengan bobot >= 6 pada segmen tersebut = direkomendasikan."""
    return 1 if POLA_WAKTU[segmen][id_produk] >= 6 else 0

# ── Generate data ──────────────────────────────────────────────────────────────
print("Membuat dataset sintetis Warkop Bahagia...")

# Distribusi jam pemesanan (lebih realistis)
# Pagi banyak, siang paling rame, sore sedang, malam sedang
JAM_DISTRIBUSI = (
    [6, 7, 7, 8, 8, 8, 9, 9, 10] * 20 +    # pagi
    [11, 11, 12, 12, 12, 13, 13, 14] * 30 + # siang (paling rame)
    [15, 15, 16, 16, 17] * 15 +              # sore
    [18, 18, 19, 19, 20, 20, 21, 22] * 20   # malam
)

rows = []
id_counter = 1

# Generate 1000 baris transaksi
for _ in range(1000):
    jam = random.choice(JAM_DISTRIBUSI)
    menit = random.randint(0, 59)
    segmen = jam_ke_segmen(jam)

    # Pilih produk berdasarkan bobot probabilitas segmen waktu
    produk_ids = list(POLA_WAKTU[segmen].keys())
    bobot = list(POLA_WAKTU[segmen].values())
    id_produk = random.choices(produk_ids, weights=bobot, k=1)[0]

    nama, kategori, harga = MENU[id_produk]
    qty = random.choices([1, 2, 3], weights=[70, 20, 10], k=1)[0]

    # Fitur hari (weekday vs weekend)
    hari_ke = random.randint(0, 6)  # 0=Senin, 6=Minggu
    is_weekend = 1 if hari_ke >= 5 else 0

    label = label_rekomendasi(id_produk, segmen)

    rows.append({
        'id_transaksi':    f'TRX{id_counter:06d}',
        'jam':             jam,
        'menit':           menit,
        'segmen_waktu':    segmen,
        'hari':            hari_ke,
        'is_weekend':      is_weekend,
        'id_produk':       id_produk,
        'nama_produk':     nama,
        'kategori':        kategori,
        'harga':           harga,
        'qty':             qty,
        'label_rekomendasi': label,
    })
    id_counter += 1

df = pd.DataFrame(rows)

# ── Validasi & Simpan ──────────────────────────────────────────────────────────
print(f"\nTotal data        : {len(df)} baris")
print(f"Kolom             : {list(df.columns)}")
print(f"\nDistribusi segmen waktu:")
print(df['segmen_waktu'].value_counts())
print(f"\nDistribusi label rekomendasi:")
print(df['label_rekomendasi'].value_counts())
print(f"\nTop 10 menu terpopuler:")
print(df['nama_produk'].value_counts().head(10))

import os as _os
BASE_ML = _os.path.dirname(_os.path.abspath(__file__))
df.to_csv(_os.path.join(BASE_ML, 'dataset_warkop.csv'), index=False)
print("\nDataset berhasil disimpan → dataset_warkop.csv")
