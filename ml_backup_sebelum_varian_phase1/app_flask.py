from flask import Flask, request, jsonify
from predict import prediksi
from flask_cors import CORS

app = Flask(__name__)
CORS(app)

@app.route('/api/rekomendasi', methods=['GET'])
def rekomendasi():
    jam = request.args.get('jam')
    if jam is not None:
        try:
            jam = int(jam)
            if jam < 0 or jam > 23:
                return jsonify({"status": "error", "message": "Jam tidak valid. Gunakan angka 0-23."}), 400
        except ValueError:
            return jsonify({"status": "error", "message": "Format jam tidak valid."}), 400
    
    hasil = prediksi(jam=jam)
    return jsonify({
        "status": "success",
        "data": hasil
    })

if __name__ == '__main__':
    print("Mulai Flask API Server di port 5001...")
    app.run(host='127.0.0.1', port=5001, debug=True)
