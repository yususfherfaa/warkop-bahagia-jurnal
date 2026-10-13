<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Menu - <?= esc($nama_warkop) ?></title>
<link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
<style>
/* ── BASE ───────────────────────────────────────────────────── */
body { background: var(--latte-light); }

.header-hero {
    background: linear-gradient(135deg, var(--espresso), var(--espresso-light));
    color: white;
    padding: 40px 20px;
    text-align: center;
    border-radius: 0 0 var(--radius-lg) var(--radius-lg);
    margin-bottom: 30px;
    box-shadow: var(--shadow-warm);
}
.header-hero h1 {
    font-family: var(--font-heading);
    margin: 0;
    font-size: 36px;
    letter-spacing: 1px;
}
.header-hero p { color: var(--caramel-light); margin-top: 10px; font-size: 16px; }
.meja-badge {
    display: inline-block;
    background: rgba(255,255,255,0.15);
    padding: 8px 16px;
    border-radius: 20px;
    margin-top: 15px;
    font-size: 14px;
    border: 1px solid rgba(255,255,255,0.2);
}
.kategori-title {
    font-family: var(--font-heading);
    color: var(--espresso);
    font-size: 24px;
    margin: 40px 0 20px 0;
    padding-bottom: 10px;
    border-bottom: 2px solid var(--caramel);
    display: inline-block;
}
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 24px;
}
.card {
    background: white;
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-warm);
    transition: var(--transition);
    border: 1px solid rgba(200,162,122,0.1);
    display: flex;
    flex-direction: column;
}
.card:hover { transform: translateY(-5px); box-shadow: var(--shadow-warm-lg); }
.card img { width: 100%; height: 180px; object-fit: cover; border-bottom: 1px solid rgba(200,162,122,0.1); }
.card-body { padding: 16px; flex: 1; display: flex; flex-direction: column; }
.card-title { font-weight: 600; color: var(--espresso); margin: 0 0 8px 0; font-size: 16px; }
.card-price { font-weight: 600; color: var(--caramel-dark); font-size: 16px; margin-bottom: 10px; }
.btn-add {
    background: var(--caramel); color: white; border: none;
    padding: 10px; border-radius: 8px; cursor: pointer;
    font-weight: 500; transition: var(--transition);
    margin-top: auto; width: 100%;
}
.btn-add:hover { background: var(--caramel-dark); }
.btn-add:disabled { background: #ccc; cursor: not-allowed; }
.btn-add.kosong { background: #ccc; color: #666; }
.stok-badge { font-size: 12px; padding: 4px 8px; border-radius: 4px; margin-bottom: 10px; display: inline-block; font-weight: 500; }
.stok-aman  { background: rgba(74,124,89,0.15);  color: var(--matcha); }
.stok-tipis { background: rgba(200,162,122,0.15); color: var(--caramel-dark); }
.stok-habis { background: rgba(192,57,43,0.1);   color: var(--brick-red); }

/* ── FLOATING CART ──────────────────────────────────────────── */
.floating-cart {
    position: fixed; bottom: 30px; right: 30px;
    background: var(--matcha); color: white;
    width: 60px; height: 60px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    text-decoration: none;
    box-shadow: 0 4px 15px rgba(74,124,89,0.4);
    font-size: 24px; transition: var(--transition); z-index: 100;
}
.floating-cart:hover { transform: scale(1.1); background: var(--matcha-dark); }
.cart-badge {
    position: absolute; top: -5px; right: -5px;
    background: var(--brick-red); color: white; border-radius: 50%;
    width: 24px; height: 24px;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: bold; border: 2px solid white;
}

/* ── WIDGET REKOMENDASI ML ──────────────────────────────────── */
.rekomendasi-section {
    background: linear-gradient(135deg, #fff8f0, #fff3e6);
    border: 2px solid var(--caramel);
    border-radius: var(--radius-lg);
    padding: 24px;
    margin-bottom: 36px;
    box-shadow: var(--shadow-warm);
}
.rekomendasi-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 18px;
}
.rekomendasi-header .icon {
    font-size: 28px;
    line-height: 1;
}
.rekomendasi-header .info h2 {
    margin: 0;
    font-size: 20px;
    font-family: var(--font-heading);
    color: var(--espresso);
}
.rekomendasi-header .info p {
    margin: 4px 0 0;
    font-size: 13px;
    color: #888;
}
.badge-ml {
    display: inline-block;
    background: var(--espresso);
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1px;
    padding: 3px 8px;
    border-radius: 20px;
    margin-left: 8px;
    vertical-align: middle;
    text-transform: uppercase;
}
.rekomendasi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: 14px;
}
.rekomen-card {
    background: #fff;
    border: 1px solid rgba(200,162,122,0.25);
    border-radius: 12px;
    padding: 14px 12px;
    text-align: center;
    transition: var(--transition);
    cursor: pointer;
    position: relative;
    text-decoration: none;
    display: block;
    color: inherit;
}
.rekomen-card:hover {
    border-color: var(--caramel);
    box-shadow: 0 4px 12px rgba(200,162,122,0.3);
    transform: translateY(-3px);
}
.rekomen-card .rekomen-nama {
    font-size: 13px;
    font-weight: 600;
    color: var(--espresso);
    margin-bottom: 6px;
    line-height: 1.3;
}
.rekomen-card .rekomen-harga {
    font-size: 13px;
    font-weight: 700;
    color: var(--caramel-dark);
    margin-bottom: 8px;
}
.rekomen-card .rekomen-btn {
    display: block;
    background: var(--caramel);
    color: white;
    font-size: 12px;
    font-weight: 600;
    padding: 6px 10px;
    border-radius: 8px;
    text-decoration: none;
    transition: var(--transition);
}
.rekomen-card .rekomen-btn:hover { background: var(--caramel-dark); }
.rekomen-kategori-label {
    display: inline-block;
    font-size: 10px;
    background: rgba(200,162,122,0.12);
    color: var(--caramel-dark);
    border-radius: 4px;
    padding: 2px 7px;
    margin-bottom: 6px;
    font-weight: 500;
}
.rekomen-loading {
    text-align: center;
    padding: 30px;
    color: #aaa;
    font-size: 14px;
}
.rekomen-loading .spinner {
    display: inline-block;
    width: 28px; height: 28px;
    border: 3px solid #eee;
    border-top-color: var(--caramel);
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
    margin-bottom: 10px;
}
@keyframes spin { to { transform: rotate(360deg); } }

.rekomendasi-footer {
    margin-top: 14px;
    font-size: 11px;
    color: #bbb;
    text-align: right;
}
</style>
</head>

<body>

<!-- ══ HEADER ══════════════════════════════════════════════════ -->
<div class="header-hero">
    <img src="<?= base_url($logo) ?>"
         class="logo" style="width:120px; border-radius:50%; border:4px solid var(--latte); margin-bottom:15px;">
    <h1><?= esc($nama_warkop) ?> - <?= esc($meja['nama']) ?></h1>
    <p>Silahkan pilih menu</p>
</div>

<div class="container">

    <!-- ══ WIDGET REKOMENDASI ML ═══════════════════════════════ -->
    <div class="rekomendasi-section" id="rekomendasiBox">
        <div class="rekomendasi-header">
            <div class="icon" id="rekomendasiEmoji">⏳</div>
            <div class="info">
                <h2>
                    Menu Rekomendasi
                    <span class="badge-ml">AI · KNN</span>
                </h2>
                <p id="rekomendasiSubtitle">Memuat rekomendasi berdasarkan waktu sekarang…</p>
            </div>
        </div>

        <!-- Loading state -->
        <div class="rekomen-loading" id="rekomendasiLoading">
            <div class="spinner"></div><br>
            Menganalisis pola waktu…
        </div>

        <!-- Grid hasil rekomendasi -->
        <div class="rekomendasi-grid" id="rekomendasiGrid" style="display:none;"></div>

        <div class="rekomendasi-footer" id="rekomendasiFooter"></div>
    </div>
    <!-- ══ END WIDGET ══════════════════════════════════════════ -->

    <?php
        // Kelompokkan produk berdasarkan kategori
        $produk_by_kategori = [];
        foreach ($products as $p) {
            $kategori = $p['kategori'];
            if (!isset($produk_by_kategori[$kategori])) {
                $produk_by_kategori[$kategori] = [];
            }
            $produk_by_kategori[$kategori][] = $p;
        }
    ?>

    <?php foreach ($produk_by_kategori as $kategori => $items): ?>
    <div class="kategori-section">
        <h2 class="kategori-title"><?= esc($kategori) ?></h2>
        <div class="grid">
            <?php foreach ($items as $p): ?>
            <div class="card">
                <img src="<?= base_url('uploads/'.$p['gambar']) ?>">
                <div class="card-body">
                    <h3 class="card-title"><?= esc($p['nama']) ?></h3>
                    <div class="card-price">
                        Rp <?= number_format($p['harga'], 0, ',', '.') ?>
                    </div>
                    <p style="margin:5px 0 14px;">
                        Stok:
                        <?php if ($p['stok'] <= 0): ?>
                            <span class="stok-badge stok-habis">Habis</span>
                        <?php elseif ($p['stok'] <= 5): ?>
                            <span class="stok-badge stok-tipis"><?= $p['stok'] ?> tersisa</span>
                        <?php else: ?>
                            <span class="stok-badge stok-aman"><?= $p['stok'] ?></span>
                        <?php endif; ?>
                    </p>
                    <?php if ($p['stok'] > 0): ?>
                    <a href="<?= base_url('/cart/add/'.$p['id_produk'].'/'.$id_meja) ?>" class="btn">
                        Tambah
                    </a>
                    <?php else: ?>
                    <button class="btn btn-add kosong" disabled>Stok Habis</button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>

    <div class="cart-btn">
        <a href="<?= base_url('/cart/'.$id_meja) ?>">Lihat Keranjang</a>
    </div>

</div><!-- /container -->

<!-- ══ SCRIPT REKOMENDASI ══════════════════════════════════════ -->
<script>
(function () {
    const ID_MEJA   = '<?= esc($id_meja) ?>';
    const BASE_URL  = '<?= base_url() ?>';
    const API_URL   = BASE_URL + 'api/rekomendasi';

    const LABEL_SEGMEN = {
        pagi:  'Selamat pagi! Ini rekomendasi menu untuk sarapan',
        siang: 'Selamat siang! Menu favorit untuk makan siang',
        sore:  'Selamat sore! Cocok untuk ngemil santai',
        malam: 'Selamat malam! Menu hangat untuk menemani malam',
    };

    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function renderRekomendasi(data) {
        const grid     = document.getElementById('rekomendasiGrid');
        const loading  = document.getElementById('rekomendasiLoading');
        const emoji    = document.getElementById('rekomendasiEmoji');
        const subtitle = document.getElementById('rekomendasiSubtitle');
        const footer   = document.getElementById('rekomendasiFooter');

        emoji.textContent    = data.emoji || '🍽️';
        subtitle.textContent = LABEL_SEGMEN[data.segmen] || 'Rekomendasi menu untukmu';

        if (!data.rekomendasi || data.rekomendasi.length === 0) {
            loading.innerHTML = '<p style="color:#aaa;">Tidak ada rekomendasi khusus untuk saat ini.</p>';
            return;
        }

        let html = '';
        data.rekomendasi.slice(0, 8).forEach(function (item) {
            const addUrl = BASE_URL + 'cart/add/' + item.id_produk + '/' + ID_MEJA;
            const conf   = item.confidence ? ' · ' + item.confidence + '%' : '';
            html += `
                <div class="rekomen-card">
                    <div class="rekomen-kategori-label">${item.kategori}</div>
                    <div class="rekomen-nama">${item.nama}</div>
                    <div class="rekomen-harga">${formatRupiah(item.harga)}</div>
                    <a href="${addUrl}" class="rekomen-btn">+ Tambah</a>
                </div>
            `;
        });

        const jam  = data.jam.toString().padStart(2, '0');
        const src  = data.source === 'knn-model' ? 'Model KNN · Akurasi 90%' : 'Rule-based';
        footer.textContent = `${data.hari}, ${jam}:xx · ${src}`;

        loading.style.display = 'none';
        grid.innerHTML        = html;
        grid.style.display    = 'grid';
    }

    function loadRekomendasi() {
        fetch(API_URL)
            .then(function (res) { return res.json(); })
            .then(function (json) {
                if (json.status === 'success') {
                    renderRekomendasi(json.data);
                } else {
                    document.getElementById('rekomendasiLoading').innerHTML =
                        '<p style="color:#ccc;font-size:13px;">Rekomendasi tidak tersedia.</p>';
                }
            })
            .catch(function () {
                // Fallback: sembunyikan widget kalau API gagal
                document.getElementById('rekomendasiBox').style.display = 'none';
            });
    }

    // Jalankan saat halaman siap
    document.addEventListener('DOMContentLoaded', loadRekomendasi);

    // Refresh rekomendasi tiap 30 menit (kalau halaman dibuka lama)
    setInterval(loadRekomendasi, 30 * 60 * 1000);
})();
</script>

</body>
</html>
