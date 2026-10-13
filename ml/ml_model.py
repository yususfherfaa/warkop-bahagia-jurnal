"""
ml_model.py
===========
Pipeline Machine Learning - Sistem Rekomendasi Menu Warkop Bahagia
Algoritma: K-Nearest Neighbor (KNN)
Fitur    : jam, segmen_waktu, hari, is_weekend, kategori, harga
Target   : label_rekomendasi (1 = rekomendasikan, 0 = tidak)

Output:
  - confusion_matrix.png
  - feature_importance.png
  - model_knn.pkl
  - label_encoder.pkl
  - hasil_evaluasi.txt
"""

import pandas as pd
import numpy as np
import matplotlib
matplotlib.use('Agg')
import matplotlib.pyplot as plt
import seaborn as sns
import joblib
import warnings
warnings.filterwarnings('ignore')

import os
BASE_ML = os.path.dirname(os.path.abspath(__file__))

from sklearn.model_selection import train_test_split, cross_val_score
from sklearn.preprocessing import LabelEncoder, StandardScaler
from sklearn.neighbors import KNeighborsClassifier
from sklearn.metrics import (
    accuracy_score, classification_report,
    confusion_matrix, ConfusionMatrixDisplay
)

print("=" * 60)
print("  PIPELINE ML - WARKOP BAHAGIA")
print("  Sistem Rekomendasi Menu Berbasis Waktu")
print("=" * 60)

# ── 1. LOAD DATA ───────────────────────────────────────────────────────────────
print("\n[1/6] Loading dataset...")
df = pd.read_csv(os.path.join(BASE_ML, 'dataset_warkop.csv'))
print(f"      Shape: {df.shape}")
print(f"      Missing values: {df.isnull().sum().sum()}")

# ── 2. EDA SINGKAT ─────────────────────────────────────────────────────────────
print("\n[2/6] Exploratory Data Analysis...")
print(f"\n      Distribusi label:")
vc = df['label_rekomendasi'].value_counts()
for val, cnt in vc.items():
    label_txt = "Direkomendasikan    " if val == 1 else "Tidak Direkomendasikan"
    print(f"        {label_txt}: {cnt} ({cnt/len(df)*100:.1f}%)")

print(f"\n      Distribusi segmen waktu:")
for seg, cnt in df['segmen_waktu'].value_counts().items():
    print(f"        {seg:8s}: {cnt} transaksi")

# Plot distribusi segmen waktu
fig, axes = plt.subplots(1, 2, figsize=(12, 4))
fig.suptitle('EDA - Dataset Warkop Bahagia', fontsize=13, fontweight='bold')

df['segmen_waktu'].value_counts().plot(
    kind='bar', ax=axes[0], color=['#FF6B6B','#4ECDC4','#45B7D1','#96CEB4'],
    edgecolor='white'
)
axes[0].set_title('Distribusi Transaksi per Segmen Waktu')
axes[0].set_xlabel('Segmen Waktu')
axes[0].set_ylabel('Jumlah Transaksi')
axes[0].tick_params(axis='x', rotation=0)

df.groupby('segmen_waktu')['label_rekomendasi'].mean().reindex(
    ['pagi','siang','sore','malam']
).plot(kind='bar', ax=axes[1], color='#6C5CE7', edgecolor='white')
axes[1].set_title('Rata-rata Label Rekomendasi per Segmen')
axes[1].set_xlabel('Segmen Waktu')
axes[1].set_ylabel('Proporsi Direkomendasikan')
axes[1].tick_params(axis='x', rotation=0)
axes[1].set_ylim(0, 1)

plt.tight_layout()
plt.savefig(os.path.join(BASE_ML, 'eda_distribusi.png'), dpi=150, bbox_inches='tight')
plt.close()
print("      EDA chart disimpan → eda_distribusi.png")

# ── 3. PREPROCESSING ───────────────────────────────────────────────────────────
print("\n[3/6] Preprocessing data...")

# Encoding fitur kategorikal
le_segmen   = LabelEncoder()
le_kategori = LabelEncoder()

df['segmen_encoded']   = le_segmen.fit_transform(df['segmen_waktu'])
df['kategori_encoded'] = le_kategori.fit_transform(df['kategori'])

print(f"      Segmen encoding : {dict(zip(le_segmen.classes_, le_segmen.transform(le_segmen.classes_)))}")
print(f"      Kategori encoding: {dict(zip(le_kategori.classes_, le_kategori.transform(le_kategori.classes_)))}")

# Fitur yang dipakai untuk training
FEATURES = ['jam', 'segmen_encoded', 'hari', 'is_weekend', 'kategori_encoded', 'harga']
TARGET   = 'label_rekomendasi'

X = df[FEATURES]
y = df[TARGET]

# Feature Scaling (StandardScaler)
scaler = StandardScaler()
X_scaled = scaler.fit_transform(X)
X_scaled = pd.DataFrame(X_scaled, columns=FEATURES)

# Train-Test Split (80:20)
X_train, X_test, y_train, y_test = train_test_split(
    X_scaled, y, test_size=0.2, random_state=42, stratify=y
)
print(f"      Train size : {X_train.shape[0]} baris")
print(f"      Test size  : {X_test.shape[0]} baris")

# ── 4. TRAINING KNN ────────────────────────────────────────────────────────────
print("\n[4/6] Training model KNN...")

# Cari nilai K terbaik
k_scores = []
k_range  = range(1, 21)

for k in k_range:
    knn = KNeighborsClassifier(n_neighbors=k, metric='euclidean')
    scores = cross_val_score(knn, X_train, y_train, cv=5, scoring='accuracy')
    k_scores.append(scores.mean())

best_k = k_range[np.argmax(k_scores)]
best_cv_score = max(k_scores)
print(f"      K terbaik  : {best_k} (CV Accuracy: {best_cv_score:.4f})")

# Plot K vs Accuracy
plt.figure(figsize=(8, 4))
plt.plot(k_range, k_scores, 'bo-', markersize=6)
plt.axvline(x=best_k, color='red', linestyle='--', label=f'K terbaik = {best_k}')
plt.xlabel('Nilai K')
plt.ylabel('Cross-Validation Accuracy')
plt.title(f'Pemilihan Nilai K Optimal - KNN\n(K terbaik = {best_k}, Accuracy = {best_cv_score:.4f})')
plt.legend()
plt.grid(True, alpha=0.3)
plt.tight_layout()
plt.savefig(os.path.join(BASE_ML, 'k_optimization.png'), dpi=150, bbox_inches='tight')
plt.close()
print("      K optimization chart → k_optimization.png")

# Training model final dengan K terbaik
model_knn = KNeighborsClassifier(n_neighbors=best_k, metric='euclidean')
model_knn.fit(X_train, y_train)
print(f"      Model KNN (K={best_k}) berhasil dilatih!")

# ── 5. EVALUASI ────────────────────────────────────────────────────────────────
print("\n[5/6] Evaluasi model...")

y_pred = model_knn.predict(X_test)
acc    = accuracy_score(y_test, y_pred)

print(f"\n      ┌─────────────────────────────┐")
print(f"      │  HASIL EVALUASI MODEL KNN   │")
print(f"      ├─────────────────────────────┤")
print(f"      │  Accuracy  : {acc:.4f} ({acc*100:.2f}%) │")
print(f"      └─────────────────────────────┘")
print(f"\n      Classification Report:")
print(classification_report(y_test, y_pred,
      target_names=['Tidak Rekomen', 'Direkomendasikan']))

# Confusion Matrix
cm = confusion_matrix(y_test, y_pred)
fig, ax = plt.subplots(figsize=(6, 5))
disp = ConfusionMatrixDisplay(confusion_matrix=cm,
                               display_labels=['Tidak Rekomen', 'Direkomendasikan'])
disp.plot(ax=ax, colorbar=False, cmap='Blues')
ax.set_title(f'Confusion Matrix - KNN (K={best_k})\nAkurasi: {acc*100:.2f}%',
             fontsize=12, fontweight='bold')
plt.tight_layout()
plt.savefig(os.path.join(BASE_ML, 'confusion_matrix.png'), dpi=150, bbox_inches='tight')
plt.close()
print("\n      Confusion Matrix disimpan → confusion_matrix.png")

# ── 6. SIMPAN MODEL ────────────────────────────────────────────────────────────
print("\n[6/6] Menyimpan model & encoder...")

joblib.dump(model_knn,    os.path.join(BASE_ML, 'model_knn.pkl'))
joblib.dump(scaler,       os.path.join(BASE_ML, 'scaler.pkl'))
joblib.dump(le_segmen,    os.path.join(BASE_ML, 'le_segmen.pkl'))
joblib.dump(le_kategori,  os.path.join(BASE_ML, 'le_kategori.pkl'))

print("      model_knn.pkl   → disimpan")
print("      scaler.pkl      → disimpan")
print("      le_segmen.pkl   → disimpan")
print("      le_kategori.pkl → disimpan")

# Simpan hasil evaluasi ke file teks
report = classification_report(y_test, y_pred,
         target_names=['Tidak Rekomen', 'Direkomendasikan'])

with open(os.path.join(BASE_ML, 'hasil_evaluasi.txt'), 'w') as f:
    f.write("=" * 50 + "\n")
    f.write("HASIL EVALUASI MODEL KNN - WARKOP BAHAGIA\n")
    f.write("=" * 50 + "\n\n")
    f.write(f"Algoritma    : K-Nearest Neighbor\n")
    f.write(f"Nilai K      : {best_k}\n")
    f.write(f"Metric       : Euclidean Distance\n")
    f.write(f"Train Size   : {X_train.shape[0]} baris (80%)\n")
    f.write(f"Test Size    : {X_test.shape[0]} baris (20%)\n")
    f.write(f"Fitur        : {', '.join(FEATURES)}\n\n")
    f.write(f"Accuracy     : {acc:.4f} ({acc*100:.2f}%)\n\n")
    f.write("Classification Report:\n")
    f.write(report)
    f.write("\nConfusion Matrix:\n")
    f.write(str(cm))

print("      hasil_evaluasi.txt → disimpan")

print("\n" + "=" * 60)
print(f"  SELESAI! Akurasi Model: {acc*100:.2f}%")
print("=" * 60)
