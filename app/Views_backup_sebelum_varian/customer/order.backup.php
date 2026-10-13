<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Menu — <?= esc($nama_warkop) ?></title>
<link rel="stylesheet" href="<?= base_url('assets/theme.css') ?>">
<style>
/* Page-specific: product card image */
.product-card img {
    width: 100%; height: 180px; object-fit: cover;
    border-bottom: 1px solid var(--sand);
    transition: transform var(--dur) var(--ease);
}
.product-card:hover img { transform: scale(1.05); }
.product-card .card-body { padding: var(--sp-4); flex: 1; display: flex; flex-direction: column; }
.product-card { display: flex; flex-direction: column; overflow: hidden; }
.product-card .btn-add-wrap { margin-top: auto; }
/* Out of stock overlay */
.product-card.out-of-stock img { filter: grayscale(.7); opacity: .6; }
.product-card.out-of-stock .oos-label {
    position: absolute; top: var(--sp-3); right: var(--sp-3);
    background: var(--brick); color: #fff; font-size: var(--fs-xs); font-weight: 700;
    padding: 3px 10px; border-radius: var(--r-pill);
}
/* Category chips */
.category-chips {
    display: flex; gap: var(--sp-2); overflow-x: auto; padding: var(--sp-2) 0;
    -webkit-overflow-scrolling: touch; scrollbar-width: none;
    position: sticky; top: 0; z-index: 50; background: var(--cream);
    margin-bottom: var(--sp-5);
}
.category-chips::-webkit-scrollbar { display: none; }
/* Search */
.search-box {
    margin-bottom: var(--sp-4);
}
.search-box input {
    background: var(--ivory); border: 1.5px solid var(--beige); border-radius: var(--r-pill);
    padding: var(--sp-3) var(--sp-5); width: 100%; font-size: var(--fs-sm);
}
.search-box input:focus { border-color: var(--terracotta); box-shadow: 0 0 0 3px rgba(196,127,94,.15); }
/* Floating cart bar */
.floating-cart-bar {
    position: fixed; bottom: 0; left: 0; right: 0;
    background: var(--espresso); color: #fff;
    padding: var(--sp-3) var(--sp-5);
    display: flex; justify-content: space-between; align-items: center;
    box-shadow: 0 -4px 20px rgba(74,52,38,.15);
    z-index: 100; transform: translateY(100%);
    transition: transform var(--dur) var(--ease);
    border-radius: var(--r-lg) var(--r-lg) 0 0;
}
.floating-cart-bar.show { transform: translateY(0); }
.floating-cart-bar .cart-info { display: flex; align-items: center; gap: var(--sp-3); }
.floating-cart-bar .cart-count-badge {
    background: var(--terracotta); color: #fff; border-radius: 50%;
    width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: var(--fs-xs);
}
.floating-cart-bar .cart-link {
    background: var(--grad-btn); color: #fff; padding: var(--sp-2) var(--sp-5);
    border-radius: var(--r-btn); text-decoration: none; font-weight: 600; font-size: var(--fs-sm);
    transition: all var(--dur-fast) var(--ease);
}
.floating-cart-bar .cart-link:hover { filter: brightness(1.08); }
/* Rank badge on rekomen card */
.rank-badge {
    position: absolute; top: -6px; left: -6px;
    width: 28px; height: 28px; border-radius: 50%;
    background: var(--terracotta); color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 800; border: 2px solid #fff;
    box-shadow: var(--shadow-sm);
}
/* Toast add */
.add-toast {
    position: fixed; bottom: 80px; left: 50%; transform: translateX(-50%) translateY(20px);
    background: var(--espresso); color: #fff; padding: var(--sp-3) var(--sp-5);
    border-radius: var(--r-pill); font-size: var(--fs-sm); font-weight: 600;
    box-shadow: var(--shadow-lg); opacity: 0; transition: all var(--dur) var(--ease);
    z-index: 200; white-space: nowrap;
}
.add-toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }
</style>
</head>

<body>

<!-- ══ HERO HEADER ═════════════════════════════════════════════ -->
<div class="header-hero">
    <img src="<?= base_url($logo) ?>" class="logo" alt="Logo">
    <h1><?= esc($nama_warkop) ?></h1>
    <p id="greetingText">Silahkan pilih menu</p>
    <div class="badge-meja" style="margin-top:12px;">
        🍽️ <?= esc($meja['nama']) ?>
    </div>
</div>

<div class="container" style="max-width:900px;">

    <!-- ══ WIDGET REKOMENDASI AI ═══════════════════════════════ -->
    <div class="rekomendasi-section reveal" id="rekomendasiBox">
        <div class="rekomendasi-header">
            <div class="icon" id="rekomendasiEmoji">⏳</div>
            <div class="info">
                <h2>
                    Menu Rekomendasi
                    <span class="badge-ml">✨ AI · KNN</span>
                </h2>
                <p id="rekomendasiSubtitle">Memuat rekomendasi berdasarkan waktu sekarang…</p>
            </div>
        </div>

        <!-- Loading state (skeleton) -->
        <div class="rekomen-loading" id="rekomendasiLoading">
            <div class="spinner"></div><br>
            Menganalisis pola waktu…
        </div>

        <!-- Grid hasil rekomendasi -->
        <div class="rekomendasi-grid" id="rekomendasiGrid" style="display:none;"></div>

        <div class="rekomendasi-footer" id="rekomendasiFooter"></div>
    </div>
    <!-- ══ END WIDGET ══════════════════════════════════════════ -->

    <!-- ══ SEARCH ═════════════════════════════════════════════ -->
    <div class="search-box reveal">
        <input type="text" id="searchMenu" placeholder="🔍 Cari menu..." oninput="filterMenu()">
    </div>

    <!-- ══ CATEGORY CHIPS ═════════════════════════════════════ -->
    <?php
        $produk_by_kategori = [];
        foreach ($products as $p) {
            $kategori = $p['kategori'];
            if (!isset($produk_by_kategori[$kategori])) {
                $produk_by_kategori[$kategori] = [];
            }
            $produk_by_kategori[$kategori][] = $p;
        }
    ?>
    <div class="category-chips reveal" id="categoryChips">
        <button class="chip active" onclick="filterCategory('all', this)">Semua</button>
        <?php foreach (array_keys($produk_by_kategori) as $kat): ?>
        <button class="chip" onclick="filterCategory('<?= esc($kat) ?>', this)"><?= esc($kat) ?></button>
        <?php endforeach; ?>
    </div>

    <!-- ══ PRODUCT GRID PER KATEGORI ══════════════════════════ -->
    <?php foreach ($produk_by_kategori as $kategori => $items): ?>
    <div class="kategori-section" data-kategori="<?= esc($kategori) ?>">
        <h2 class="kategori-title reveal"><?= esc($kategori) ?></h2>
        <div class="grid">
            <?php foreach ($items as $p): ?>
            <div class="card product-card reveal <?= $p['stok'] <= 0 ? 'out-of-stock' : '' ?>"
                 data-nama="<?= strtolower(esc($p['nama'])) ?>"
                 style="position:relative;">

                <?php if ($p['stok'] <= 0): ?>
                    <span class="oos-label">Stok Habis</span>
                <?php endif; ?>

                <img src="<?= base_url('uploads/'.$p['gambar']) ?>"
                     alt="<?= esc($p['nama']) ?>"
                     onerror="this.src='<?= base_url('assets/noimage.png') ?>'">

                <div class="card-body">
                    <h3 class="card-title"><?= esc($p['nama']) ?></h3>
                    <div class="card-price tabular-nums">
                        Rp <?= number_format($p['harga'], 0, ',', '.') ?>
                    </div>
                    <p style="margin:6px 0 12px;">
                        <?php if ($p['stok'] <= 0): ?>
                            <span class="badge-stok stok-habis">Habis</span>
                        <?php elseif ($p['stok'] <= 5): ?>
                            <span class="badge-stok stok-tipis"><?= $p['stok'] ?> tersisa</span>
                        <?php else: ?>
                            <span class="badge-stok stok-aman"><?= $p['stok'] ?></span>
                        <?php endif; ?>
                    </p>
                    <div class="btn-add-wrap">
                        <?php if ($p['stok'] > 0): ?>
                        <a href="<?= base_url('/cart/add/'.$p['id_produk'].'/'.$id_meja) ?>"
                           class="btn btn-block btn-sm"
                           onclick="showAddToast('<?= esc($p['nama']) ?>')">
                            + Tambah
                        </a>
                        <?php else: ?>
                        <button class="btn btn-block btn-sm" disabled>Stok Habis</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>

</div><!-- /container -->

<!-- ══ FLOATING CART BAR ══════════════════════════════════════ -->
<div class="floating-cart-bar" id="cartBar">
    <div class="cart-info">
        <div class="cart-count-badge" id="cartCountBadge">0</div>
        <span style="font-size:var(--fs-sm);">item di keranjang</span>
    </div>
    <a href="<?= base_url('/cart/'.$id_meja) ?>" class="cart-link">
        Lihat Keranjang →
    </a>
</div>

<!-- Toast for add-to-cart -->
<div class="add-toast" id="addToast"></div>

<!-- ══ SCRIPTS ════════════════════════════════════════════════ -->
<script src="<?= base_url('assets/theme.js') ?>"></script>
<script>
(function () {
    var ID_MEJA   = '<?= esc($id_meja) ?>';
    var BASE_URL  = '<?= base_url() ?>';
    var API_URL   = BASE_URL + 'api/rekomendasi';

    // Greeting
    var g = WarkopGreeting();
    document.getElementById('greetingText').textContent = g.text + ' ' + g.emoji + ' — Silahkan pilih menu';

    var LABEL_SEGMEN = {
        pagi:  'Rekomendasi menu untuk sarapan pagi',
        siang: 'Menu favorit untuk makan siang',
        sore:  'Cocok untuk ngemil santai sore',
        malam: 'Menu hangat untuk menemani malam',
    };

    var EMOJI_SEGMEN = {
        pagi: '🌅', siang: '☀️', sore: '🌇', malam: '🌙'
    };

    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function renderRekomendasi(data) {
        var grid     = document.getElementById('rekomendasiGrid');
        var loading  = document.getElementById('rekomendasiLoading');
        var emoji    = document.getElementById('rekomendasiEmoji');
        var subtitle = document.getElementById('rekomendasiSubtitle');
        var footer   = document.getElementById('rekomendasiFooter');

        emoji.textContent    = EMOJI_SEGMEN[data.segmen] || data.emoji || '🍽️';
        subtitle.textContent = LABEL_SEGMEN[data.segmen] || 'Rekomendasi menu untukmu';

        // Update badge text
        var badgeMl = document.querySelector('.badge-ml');
        if (badgeMl) {
            var src = data.source === 'knn-model' ? '✨ AI · KNN' : '📋 Rule-based';
            badgeMl.textContent = src;
        }

        if (!data.rekomendasi || data.rekomendasi.length === 0) {
            loading.innerHTML = '<p style="color:var(--taupe);">Tidak ada rekomendasi khusus untuk saat ini.</p>';
            return;
        }

        var html = '';
        data.rekomendasi.slice(0, 8).forEach(function (item, idx) {
            var addUrl = BASE_URL + 'cart/add/' + item.id_produk + '/' + ID_MEJA;
            html += '<div class="rekomen-card reveal" style="--delay:' + (idx * 80) + 'ms">' +
                '<div class="rank-badge">#' + (idx + 1) + '</div>' +
                '<div class="rekomen-kategori-label">' + item.kategori + '</div>' +
                '<div class="rekomen-nama">' + item.nama + '</div>' +
                '<div class="rekomen-harga">' + formatRupiah(item.harga) + '</div>' +
                '<a href="' + addUrl + '" class="rekomen-btn">+ Tambah</a>' +
                '</div>';
        });

        // Format actual time
        var now = new Date();
        var jam = now.getHours().toString().padStart(2, '0');
        var menit = now.getMinutes().toString().padStart(2, '0');
        var srcLabel = data.source === 'knn-model' ? 'Metode: KNN' : 'Metode: Rule-based';
        footer.textContent = data.hari + ', ' + jam + ':' + menit + ' · ' + srcLabel;

        loading.style.display = 'none';
        grid.innerHTML        = html;
        grid.style.display    = 'grid';

        // Re-init reveal for dynamically added cards
        setTimeout(function() {
            grid.querySelectorAll('.reveal').forEach(function(el, i) {
                setTimeout(function() {
                    el.classList.add('is-visible');
                }, i * 80);
            });
        }, 100);
    }

    function loadRekomendasi() {
        fetch(API_URL)
            .then(function (res) { return res.json(); })
            .then(function (json) {
                if (json.status === 'success') {
                    renderRekomendasi(json.data);
                } else {
                    document.getElementById('rekomendasiLoading').innerHTML =
                        '<p style="color:var(--taupe);font-size:var(--fs-sm);">Rekomendasi tidak tersedia.</p>';
                }
            })
            .catch(function () {
                document.getElementById('rekomendasiBox').style.display = 'none';
            });
    }

    document.addEventListener('DOMContentLoaded', loadRekomendasi);
    setInterval(loadRekomendasi, 30 * 60 * 1000);
})();

// ── Category Filter ──
function filterCategory(kat, btn) {
    // Update active chip
    document.querySelectorAll('#categoryChips .chip').forEach(function(c) { c.classList.remove('active'); });
    btn.classList.add('active');

    document.querySelectorAll('.kategori-section').forEach(function(sec) {
        if (kat === 'all' || sec.dataset.kategori === kat) {
            sec.style.display = '';
        } else {
            sec.style.display = 'none';
        }
    });
}

// ── Search Filter ──
function filterMenu() {
    var q = document.getElementById('searchMenu').value.toLowerCase();
    document.querySelectorAll('.product-card').forEach(function(card) {
        var nama = card.dataset.nama || '';
        card.style.display = nama.includes(q) ? '' : 'none';
    });
    // Show all categories when searching
    if (q) {
        document.querySelectorAll('.kategori-section').forEach(function(s) { s.style.display = ''; });
    }
}

// ── Add to cart toast ──
function showAddToast(name) {
    var toast = document.getElementById('addToast');
    toast.textContent = '✓ ' + name + ' ditambahkan ke keranjang';
    toast.classList.add('show');
    setTimeout(function() { toast.classList.remove('show'); }, 2000);
}

// ── Show cart bar (always show since we can't easily count items server-side) ──
document.addEventListener('DOMContentLoaded', function() {
    var bar = document.getElementById('cartBar');
    setTimeout(function() { bar.classList.add('show'); }, 500);
});
</script>

</body>
</html>
