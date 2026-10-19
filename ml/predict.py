"""
predict.py
==========
Modul prediksi rekomendasi menu Warkop Bahagia berbasis model KNN siklis waktu.
Menghasilkan Top-5 menu teratas berdasarkan kedekatan waktu pesanan di tetangga KNN.

Skor = proporsi tetangga yang memilih menu tersebut (kemunculan / K)
Source = 'knn-waktu'
Zona waktu: Asia/Jakarta
"""

import os
import sys
import json
import argparse
from datetime import datetime
from zoneinfo import ZoneInfo
from collections import Counter

if hasattr(sys.stdout, 'reconfigure'):
    try:
        sys.stdout.reconfigure(encoding='utf-8')
    except Exception:
        pass

import numpy as np
import joblib

BASE_ML = os.path.dirname(os.path.abspath(__file__))
MODEL_PATH = os.path.join(BASE_ML, 'model_knn.joblib')

# Load model dan metadata
_artifacts = joblib.load(MODEL_PATH)
_model_knn = _artifacts['model']
_k = _artifacts['k']
_y_train = _artifacts['y_train']
_global_counts = _artifacts['global_counts']

# Katalog nama produk & kategori
KATALOG = {
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

EMOJI = {'pagi': '🌅', 'siang': '☀️', 'sore': '🌤️', 'malam': '🌙'}
HARI = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']

def jam_ke_segmen(jam: int) -> str:
    if 5 <= jam <= 10:
        return 'pagi'
    elif 11 <= jam <= 14:
        return 'siang'
    elif 15 <= jam <= 17:
        return 'sore'
    else:
        return 'malam'

def prediksi(jam: int = None, menit: int = None) -> dict:
    tz = ZoneInfo('Asia/Jakarta')
    now = datetime.now(tz)

    if jam is None:
        jam = now.hour
    if menit is None:
        menit = now.minute if jam == now.hour else 30

    hari_idx = now.weekday()
    is_weekend = 1 if hari_idx in (5, 6) else 0
    segmen = jam_ke_segmen(jam)

    # Vektor query siklis waktu
    t = jam + menit / 60.0
    ang = 2.0 * np.pi * t / 24.0
    query = np.array([[np.sin(ang), np.cos(ang)]])

    _, indices = _model_knn.kneighbors(query)
    neighbor_menus = _y_train[indices[0]]
    counts = Counter(neighbor_menus)

    # Tie-break: jumlah kemunculan (desc), frekuensi global (desc), ID asc
    sorted_menus = sorted(
        counts.keys(),
        key=lambda m: (counts[m], _global_counts.get(m, 0), -int(m[3:]) if m.startswith('PRD') else 0),
        reverse=True
    )
    top5_ids = sorted_menus[:5]

    rekomendasi_items = []
    for rank, pid in enumerate(top5_ids, 1):
        nama, kategori, harga = KATALOG.get(pid, (pid, 'Menu', 0))
        proporsi = round(counts[pid] / float(_k), 4)
        rekomendasi_items.append({
            'peringkat': rank,
            'id_produk': pid,
            'nama': nama,
            'nama_produk': nama,
            'kategori': kategori,
            'harga': harga,
            'skor': proporsi,
            'confidence': round(proporsi * 100.0, 1),
            'source': 'knn-waktu'
        })

    return {
        'jam': jam,
        'menit': menit,
        'segmen': segmen,
        'emoji': EMOJI.get(segmen, '☕'),
        'hari': HARI[hari_idx],
        'is_weekend': bool(is_weekend),
        'total_rekomendasi': len(rekomendasi_items),
        'rekomendasi': rekomendasi_items,
        'source': 'knn-waktu'
    }

if __name__ == '__main__':
    parser = argparse.ArgumentParser(description="Prediksi Rekomendasi Menu Warkop Bahagia")
    parser.add_argument('--jam', type=int, default=None, help="Jam (0-23)")
    parser.add_argument('--menit', type=int, default=None, help="Menit (0-59)")
    parser.add_argument('--json', action='store_true', help="Output format JSON")
    args = parser.parse_args()

    hasil = prediksi(jam=args.jam, menit=args.menit)

    if args.json:
        print(json.dumps(hasil, ensure_ascii=False, indent=2))
    else:
        print("=" * 60)
        print(f"  REKOMENDASI MENU WARKOP BAHAGIA (Top-5 KNN Waktu)")
        print("=" * 60)
        print(f"  {hasil['emoji']} Segmen : {hasil['segmen'].upper()} (Jam {hasil['jam']:02d}:{hasil['menit']:02d} WIB)")
        print(f"  📅 Hari   : {hasil['hari']}")
        print(f"  ⚡ Model  : NearestNeighbors (K={_k})")
        print("=" * 60)
        for it in hasil['rekomendasi']:
            print(f"  #{it['peringkat']} [{it['id_produk']}] {it['nama']:<24} Rp {it['harga']:>6,}  (Skor: {it['skor']:.4f})")
        print("=" * 60)
