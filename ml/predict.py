"""
predict.py
==========
Script prediksi rekomendasi menu Warkop Bahagia.
Support mode CLI (tampilan teks) dan mode JSON (untuk API PHP).

Penggunaan:
  python3 predict.py                  # jam sekarang, output teks
  python3 predict.py --jam 8          # simulasi jam 8, output teks
  python3 predict.py --json           # jam sekarang, output JSON
  python3 predict.py --jam 20 --json  # simulasi jam 20, output JSON
"""

import joblib
import numpy as np
import json
import argparse
from datetime import datetime

import os
BASE = os.path.dirname(os.path.abspath(__file__)) + os.sep

model_knn   = joblib.load(os.path.join(BASE, 'model_knn.pkl'))
scaler      = joblib.load(os.path.join(BASE, 'scaler.pkl'))
le_segmen   = joblib.load(os.path.join(BASE, 'le_segmen.pkl'))
le_kategori = joblib.load(os.path.join(BASE, 'le_kategori.pkl'))

MENU = [
    {'id_produk':'PRD0000001','nama':'Nasi Goreng',          'kategori':'Makanan Berat',   'harga':16000},
    {'id_produk':'PRD0000002','nama':'Indomie Goreng Telor', 'kategori':'Makanan Berat',   'harga':14000},
    {'id_produk':'PRD0000003','nama':'Indomie Rebus Telor',  'kategori':'Makanan Berat',   'harga':14000},
    {'id_produk':'PRD0000004','nama':'Bubur Kacang Ijo',     'kategori':'Makanan Berat',   'harga':12000},
    {'id_produk':'PRD0000005','nama':'Nasi Kucing',          'kategori':'Makanan Berat',   'harga': 8000},
    {'id_produk':'PRD0000006','nama':'Pancong Keju',         'kategori':'Cemilan',         'harga':10000},
    {'id_produk':'PRD0000007','nama':'Roti Bakar Coklat',    'kategori':'Cemilan',         'harga': 8000},
    {'id_produk':'PRD0000008','nama':'Kentang Goreng',       'kategori':'Cemilan',         'harga':10000},
    {'id_produk':'PRD0000009','nama':'Bakwan 1 Pcs',         'kategori':'Cemilan',         'harga': 2000},
    {'id_produk':'PRD0000010','nama':'Tempe 1 Pcs',          'kategori':'Cemilan',         'harga': 2000},
    {'id_produk':'PRD0000011','nama':'Tahu 1 Pcs',           'kategori':'Cemilan',         'harga': 2000},
    {'id_produk':'PRD0000012','nama':'Dimsum Mentai',        'kategori':'Cemilan',         'harga':15000},
    {'id_produk':'PRD0000013','nama':'Sate Telor 1 Pcs',     'kategori':'Cemilan',         'harga': 3000},
    {'id_produk':'PRD0000014','nama':'Sate Usus 1 Pcs',      'kategori':'Cemilan',         'harga': 3000},
    {'id_produk':'PRD0000015','nama':'Sate Ati Ampela 1 Pcs','kategori':'Cemilan',         'harga': 3000},
    {'id_produk':'PRD0000016','nama':'Milo',                 'kategori':'Minuman Non Kopi','harga': 7000},
    {'id_produk':'PRD0000017','nama':'Jeruk',                'kategori':'Minuman Non Kopi','harga': 6000},
    {'id_produk':'PRD0000018','nama':'Teh Manis',            'kategori':'Minuman Non Kopi','harga': 5000},
    {'id_produk':'PRD0000019','nama':'Lemon Tea',            'kategori':'Minuman Non Kopi','harga': 7000},
    {'id_produk':'PRD0000021','nama':'Susu Putih',           'kategori':'Minuman Non Kopi','harga': 6000},
    {'id_produk':'PRD0000022','nama':'Air Mineral',          'kategori':'Minuman Non Kopi','harga': 2000},
    {'id_produk':'PRD0000023','nama':'Capucinno',            'kategori':'Minuman Kopi',    'harga': 8000},
    {'id_produk':'PRD0000024','nama':'Kopi Susu',            'kategori':'Minuman Kopi',    'harga': 5000},
    {'id_produk':'PRD0000025','nama':'Kopi Hitam',           'kategori':'Minuman Kopi',    'harga': 3000},
    {'id_produk':'PRD0000026','nama':'Nasi Kuning',          'kategori':'Makanan Berat',   'harga':10000},
    {'id_produk':'PRD0000027','nama':'Nasi Uduk',            'kategori':'Makanan Berat',   'harga':10000},
    {'id_produk':'PRD0000028','nama':'Lontong Sayur',        'kategori':'Makanan Berat',   'harga':10000},
    {'id_produk':'PRD0000029','nama':'Bubur Ayam',           'kategori':'Makanan Berat',   'harga':12000},
    {'id_produk':'PRD0000030','nama':'Ayam Geprek + Nasi',   'kategori':'Makanan Berat',   'harga':15000},
    {'id_produk':'PRD0000031','nama':'ABC Susu',               'kategori':'Kopi Panas',      'kategori_model':'Minuman Kopi',    'harga': 5000},
    {'id_produk':'PRD0000032','nama':'Indocafe',               'kategori':'Kopi Panas',      'kategori_model':'Minuman Kopi',    'harga': 5000},
    {'id_produk':'PRD0000033','nama':'Kapal Api Special Mix',  'kategori':'Kopi Panas',      'kategori_model':'Minuman Kopi',    'harga': 5000},
    {'id_produk':'PRD0000034','nama':'Good Day Biasa',         'kategori':'Kopi Panas',      'kategori_model':'Minuman Kopi',    'harga': 6000},
    {'id_produk':'PRD0000035','nama':'Luwak White Coffee',     'kategori':'Kopi Panas',      'kategori_model':'Minuman Kopi',    'harga': 5000},
    {'id_produk':'PRD0000036','nama':'Torabika Creamy Latte',  'kategori':'Kopi Panas',      'kategori_model':'Minuman Kopi',    'harga': 6000},
    {'id_produk':'PRD0000037','nama':'Good Day Freeze',        'kategori':'Es Kopi',         'kategori_model':'Minuman Kopi',    'harga': 8000},
    {'id_produk':'PRD0000038','nama':'Nescafe Ice Roast',      'kategori':'Es Kopi',         'kategori_model':'Minuman Kopi',    'harga': 7000},
    {'id_produk':'PRD0000039','nama':'ABC Klepon',             'kategori':'Es Kopi',         'kategori_model':'Minuman Kopi',    'harga': 8000},
    {'id_produk':'PRD0000040','nama':'Good Day Biasa',         'kategori':'Es Kopi',         'kategori_model':'Minuman Kopi',    'harga': 7000},
    {'id_produk':'PRD0000041','nama':'Tora Cafe',              'kategori':'Es Kopi',         'kategori_model':'Minuman Kopi',    'harga': 7000},
    {'id_produk':'PRD0000042','nama':'Es Nutrisari',           'kategori':'Es Nutrisari',    'kategori_model':'Minuman Non Kopi','harga': 5000},
]

EMOJI = {'pagi':'🌅','siang':'☀️','sore':'🌤️','malam':'🌙'}
HARI  = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu']

def jam_ke_segmen(j):
    if 5 <= j <= 10:   return 'pagi'
    elif 11 <= j <= 14: return 'siang'
    elif 15 <= j <= 17: return 'sore'
    else:               return 'malam'

def prediksi(jam=None):
    now    = datetime.now()
    jam    = jam if jam is not None else now.hour
    hari   = now.weekday()
    is_wknd = 1 if hari >= 5 else 0
    segmen  = jam_ke_segmen(jam)
    seg_enc = le_segmen.transform([segmen])[0]

    hasil = []
    for m in MENU:
        kat_enc  = le_kategori.transform([m.get('kategori_model', m['kategori'])])[0]
        fitur    = np.array([[jam, seg_enc, hari, is_wknd, kat_enc, m['harga']]])
        fitur_s  = scaler.transform(fitur)
        pred     = model_knn.predict(fitur_s)[0]
        proba    = model_knn.predict_proba(fitur_s)[0][1]
        if pred == 1:
            hasil.append({**m, 'confidence': round(proba*100,1)})

    hasil.sort(key=lambda x: x['confidence'], reverse=True)
    return {
        'jam': jam, 'segmen': segmen, 'emoji': EMOJI[segmen],
        'hari': HARI[hari], 'is_weekend': bool(is_wknd),
        'total_rekomendasi': len(hasil),
        'rekomendasi': hasil, 'source': 'knn-model',
    }

if __name__ == '__main__':
    parser = argparse.ArgumentParser()
    parser.add_argument('--jam',  type=int, default=None)
    parser.add_argument('--json', action='store_true')
    args = parser.parse_args()

    hasil = prediksi(jam=args.jam)

    if args.json:
        print(json.dumps(hasil, ensure_ascii=False))
    else:
        print(f"\n{'='*55}")
        print(f"  REKOMENDASI MENU WARKOP BAHAGIA")
        print(f"{'='*55}")
        print(f"  {hasil['emoji']}  Segmen : {hasil['segmen'].upper()} (jam {hasil['jam']:02d}:xx)")
        print(f"  📅  Hari   : {hasil['hari']}")
        print(f"  ✅  Total  : {hasil['total_rekomendasi']} menu direkomendasikan")
        print(f"{'='*55}")
        kat_saat_ini = None
        for item in hasil['rekomendasi']:
            if item['kategori'] != kat_saat_ini:
                kat_saat_ini = item['kategori']
                print(f"\n  📂 {item['kategori']}")
            print(f"     • {item['nama']:<28} Rp {item['harga']:>6,}  [{item['confidence']}%]")
        print(f"\n{'='*55}\n")
