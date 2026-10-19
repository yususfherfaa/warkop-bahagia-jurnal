import os
import sys
from flask import Flask, request, jsonify
from flask_cors import CORS
from predict import prediksi

app = Flask(__name__)

# Batasi CORS hanya untuk origin aplikasi lokal (bukan wildcard '*')
CORS(app, origins=[
    'http://localhost:8080',
    'http://127.0.0.1:8080',
    'http://localhost',
    'http://127.0.0.1'
])

@app.route('/api/rekomendasi', methods=['GET'])
def rekomendasi():
    jam = request.args.get('jam')
    menit = request.args.get('menit')

    jam_val = None
    menit_val = None

    if jam is not None:
        try:
            jam_val = int(jam)
            if jam_val < 0 or jam_val > 23:
                return jsonify({"status": "error", "message": "Jam tidak valid. Gunakan angka 0-23."}), 400
        except ValueError:
            return jsonify({"status": "error", "message": "Format jam tidak valid."}), 400

    if menit is not None:
        try:
            menit_val = int(menit)
            if menit_val < 0 or menit_val > 59:
                return jsonify({"status": "error", "message": "Menit tidak valid. Gunakan angka 0-59."}), 400
        except ValueError:
            return jsonify({"status": "error", "message": "Format menit tidak valid."}), 400

    hasil = prediksi(jam=jam_val, menit=menit_val)
    return jsonify({
        "status": "success",
        "data": hasil
    })

if __name__ == '__main__':
    print("Mulai Flask API Server di port 5001 (host 127.0.0.1, debug=False)...")
    app.run(host='127.0.0.1', port=5001, debug=False)
