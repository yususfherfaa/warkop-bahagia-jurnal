"""
generate_dataset.py
===================
Membuat dataset sintetis pola pemesanan Warkop Bahagia berdasarkan konteks
waktu. Data ini sintetis; bobot awal berasal dari pengetahuan pemilik warkop
dan nantinya bisa diganti data riil dari tabel orders/order_items.

Output: dataset_warkop.csv
"""

import os
import random

random.seed(42)

MENU = {
    'PRD0000001': ('Nasi Goreng', 'Makanan Berat', 16000),
    'PRD0000002': ('Indomie Goreng Telor', 'Makanan Berat', 14000),
    'PRD0000003': ('Indomie Rebus Telor', 'Makanan Berat', 14000),
    'PRD0000004': ('Bubur Kacang Ijo', 'Makanan Berat', 12000),
    'PRD0000005': ('Nasi Kucing', 'Makanan Berat', 8000),
    'PRD0000006': ('Pancong Keju', 'Cemilan', 10000),
    'PRD0000007': ('Roti Bakar Coklat', 'Cemilan', 8000),
    'PRD0000008': ('Kentang Goreng', 'Cemilan', 10000),
    'PRD0000009': ('Bakwan 1 Pcs', 'Cemilan', 2000),
    'PRD0000010': ('Tempe 1 Pcs', 'Cemilan', 2000),
    'PRD0000011': ('Tahu 1 Pcs', 'Cemilan', 2000),
    'PRD0000012': ('Dimsum Mentai', 'Cemilan', 15000),
    'PRD0000013': ('Sate Telor 1 Pcs', 'Cemilan', 3000),
    'PRD0000014': ('Sate Usus 1 Pcs', 'Cemilan', 3000),
    'PRD0000015': ('Sate Ati Ampela 1 Pcs', 'Cemilan', 3000),
    'PRD0000016': ('Milo', 'Minuman Non Kopi', 7000),
    'PRD0000017': ('Jeruk', 'Minuman Non Kopi', 6000),
    'PRD0000018': ('Teh Manis', 'Minuman Non Kopi', 5000),
    'PRD0000019': ('Lemon Tea', 'Minuman Non Kopi', 7000),
    'PRD0000021': ('Susu Putih', 'Minuman Non Kopi', 6000),
    'PRD0000022': ('Air Mineral', 'Minuman Non Kopi', 2000),
    'PRD0000023': ('Capucinno', 'Minuman Kopi', 8000),
    'PRD0000024': ('Kopi Susu', 'Minuman Kopi', 5000),
    'PRD0000025': ('Kopi Hitam', 'Minuman Kopi', 3000),
    'PRD0000026': ('Nasi Kuning', 'Makanan Berat', 10000),
    'PRD0000027': ('Nasi Uduk', 'Makanan Berat', 10000),
    'PRD0000028': ('Lontong Sayur', 'Makanan Berat', 10000),
    'PRD0000029': ('Bubur Ayam', 'Makanan Berat', 12000),
    'PRD0000030': ('Ayam Geprek + Nasi', 'Makanan Berat', 15000),
    'PRD0000031': ('ABC Susu', 'Kopi Panas', 5000),
    'PRD0000032': ('Indocafe', 'Kopi Panas', 5000),
    'PRD0000033': ('Kapal Api Special Mix', 'Kopi Panas', 5000),
    'PRD0000034': ('Good Day Biasa', 'Kopi Panas', 6000),
    'PRD0000035': ('Luwak White Coffee', 'Kopi Panas', 5000),
    'PRD0000036': ('Torabika Creamy Latte', 'Kopi Panas', 6000),
    'PRD0000037': ('Good Day Freeze', 'Es Kopi', 8000),
    'PRD0000038': ('Nescafe Ice Roast', 'Es Kopi', 7000),
    'PRD0000039': ('ABC Klepon', 'Es Kopi', 8000),
    'PRD0000040': ('Good Day Biasa', 'Es Kopi', 7000),
    'PRD0000041': ('Tora Cafe', 'Es Kopi', 7000),
    'PRD0000042': ('Es Nutrisari', 'Es Nutrisari', 5000),
}

MODEL_CATEGORY = {
    'Kopi Panas': 'Minuman Kopi',
    'Es Kopi': 'Minuman Kopi',
    'Es Nutrisari': 'Minuman Non Kopi',
}

POLA_WAKTU = {
    'pagi': {
        'PRD0000026': 9, 'PRD0000027': 9, 'PRD0000028': 8, 'PRD0000029': 8,
        'PRD0000024': 9, 'PRD0000025': 8, 'PRD0000018': 8,
        'PRD0000031': 8, 'PRD0000032': 8, 'PRD0000033': 8,
        'PRD0000034': 8, 'PRD0000035': 7, 'PRD0000036': 7,
        **{pid: 2 for pid in MENU if pid not in {'PRD0000026', 'PRD0000027', 'PRD0000028', 'PRD0000029', 'PRD0000024', 'PRD0000025', 'PRD0000018', 'PRD0000031', 'PRD0000032', 'PRD0000033', 'PRD0000034', 'PRD0000035', 'PRD0000036'}},
    },
    'siang': {
        'PRD0000030': 10, 'PRD0000002': 8, 'PRD0000019': 8, 'PRD0000018': 8,
        'PRD0000017': 8, 'PRD0000005': 7, 'PRD0000013': 7, 'PRD0000014': 7,
        'PRD0000015': 7, 'PRD0000009': 7, 'PRD0000010': 7, 'PRD0000011': 7,
        'PRD0000037': 8, 'PRD0000038': 7, 'PRD0000039': 6,
        'PRD0000040': 7, 'PRD0000041': 6, 'PRD0000042': 7,
        **{pid: 2 for pid in MENU if pid not in {'PRD0000030', 'PRD0000002', 'PRD0000019', 'PRD0000018', 'PRD0000017', 'PRD0000005', 'PRD0000013', 'PRD0000014', 'PRD0000015', 'PRD0000009', 'PRD0000010', 'PRD0000011', 'PRD0000037', 'PRD0000038', 'PRD0000039', 'PRD0000040', 'PRD0000041', 'PRD0000042'}},
    },
    'sore': {
        'PRD0000006': 9, 'PRD0000007': 8, 'PRD0000008': 8, 'PRD0000012': 8,
        'PRD0000034': 6, 'PRD0000037': 6, 'PRD0000040': 6, 'PRD0000042': 6,
        **{pid: 2 for pid in MENU if pid not in {'PRD0000006', 'PRD0000007', 'PRD0000008', 'PRD0000012', 'PRD0000034', 'PRD0000037', 'PRD0000040', 'PRD0000042'}},
    },
    'malam': {
        'PRD0000003': 10, 'PRD0000004': 8, 'PRD0000001': 8, 'PRD0000024': 8,
        'PRD0000025': 8, 'PRD0000023': 7, 'PRD0000016': 7, 'PRD0000021': 7,
        'PRD0000009': 7, 'PRD0000010': 7, 'PRD0000011': 7,
        'PRD0000031': 7, 'PRD0000032': 7, 'PRD0000033': 7,
        'PRD0000034': 7, 'PRD0000035': 6, 'PRD0000036': 6,
        'PRD0000037': 7, 'PRD0000038': 7, 'PRD0000039': 6,
        'PRD0000040': 7, 'PRD0000041': 6, 'PRD0000042': 7,
        **{pid: 2 for pid in MENU if pid not in {'PRD0000003', 'PRD0000004', 'PRD0000001', 'PRD0000024', 'PRD0000025', 'PRD0000023', 'PRD0000016', 'PRD0000021', 'PRD0000009', 'PRD0000010', 'PRD0000011', 'PRD0000031', 'PRD0000032', 'PRD0000033', 'PRD0000034', 'PRD0000035', 'PRD0000036', 'PRD0000037', 'PRD0000038', 'PRD0000039', 'PRD0000040', 'PRD0000041', 'PRD0000042'}},
    },
}


def jam_ke_segmen(jam: int) -> str:
    if 5 <= jam <= 10:
        return 'pagi'
    if 11 <= jam <= 14:
        return 'siang'
    if 15 <= jam <= 17:
        return 'sore'
    return 'malam'


def label_rekomendasi(id_produk: str, segmen: str) -> int:
    return 1 if POLA_WAKTU[segmen][id_produk] >= 6 else 0


print("Membuat dataset sintetis Warkop Bahagia...")

jam_distribusi = (
    [6, 7, 7, 8, 8, 8, 9, 9, 10] * 20 +
    [11, 11, 12, 12, 12, 13, 13, 14] * 30 +
    [15, 15, 16, 16, 17] * 15 +
    [18, 18, 19, 19, 20, 20, 21, 22] * 20
)

rows = []
for id_counter in range(1, 1001):
    jam = random.choice(jam_distribusi)
    menit = random.randint(0, 59)
    segmen = jam_ke_segmen(jam)
    produk_ids = list(POLA_WAKTU[segmen].keys())
    bobot = list(POLA_WAKTU[segmen].values())
    id_produk = random.choices(produk_ids, weights=bobot, k=1)[0]
    nama, kategori, harga = MENU[id_produk]
    hari_ke = random.randint(0, 6)
    kategori_model = MODEL_CATEGORY.get(kategori, kategori)

    rows.append({
        'id_transaksi': f'TRX{id_counter:06d}',
        'jam': jam,
        'menit': menit,
        'segmen_waktu': segmen,
        'hari': hari_ke,
        'is_weekend': 1 if hari_ke >= 5 else 0,
        'id_produk': id_produk,
        'nama_produk': nama,
        'kategori': kategori,
        'kategori_model': kategori_model,
        'harga': harga,
        'qty': random.choices([1, 2, 3], weights=[70, 20, 10], k=1)[0],
        'label_rekomendasi': label_rekomendasi(id_produk, segmen),
    })

columns = list(rows[0].keys())
print(f"\nTotal data        : {len(rows)} baris")
print(f"Kolom             : {columns}")

base_ml = os.path.dirname(os.path.abspath(__file__))
csv_path = os.path.join(base_ml, 'dataset_warkop.csv')
with open(csv_path, 'w', encoding='utf-8', newline='') as fh:
    fh.write(','.join(columns) + '\n')
    for row in rows:
        fh.write(','.join(str(row[col]) for col in columns) + '\n')
print("\nDataset berhasil disimpan -> dataset_warkop.csv")
