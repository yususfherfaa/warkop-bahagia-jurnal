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
    position: absolute; top: 8px; left: 8px;
    width: 28px; height: 28px; border-radius: 50%;
    background: var(--terracotta); color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 800; border: 2px solid #fff;
    box-shadow: var(--shadow-sm);
    z-index: 3;
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

.suhu-toggle {
    display: inline-grid;
    grid-template-columns: 1fr 1fr;
    gap: 2px;
    background: var(--sand);
    border: 1px solid var(--beige);
    border-radius: var(--r-pill);
    padding: 2px;
    margin: 6px 0 10px;
    width: 100%;
}
.suhu-toggle button {
    border: 0;
    border-radius: var(--r-pill);
    background: transparent;
    color: var(--mocha);
    font-size: 12px;
    font-weight: 700;
    padding: 6px 8px;
    cursor: pointer;
}
.suhu-toggle button.active {
    background: var(--ivory);
    color: var(--espresso);
    box-shadow: var(--shadow-sm);
}
.group-members { font-size: var(--fs-xs); color: var(--taupe); line-height: 1.4; margin-bottom: 10px; }
.sheet-backdrop {
    position: fixed; inset: 0; background: rgba(48,34,24,.32);
    display: none; align-items: flex-end; z-index: 300;
}
.sheet-backdrop.show { display: flex; }
.bottom-sheet {
    background: var(--ivory); border-radius: 16px 16px 0 0; padding: 18px;
    width: 100%; max-height: 78vh; overflow: auto; box-shadow: var(--shadow-lg);
    transform: translateY(100%); transition: transform var(--dur) var(--ease);
}
.sheet-backdrop.show .bottom-sheet { transform: translateY(0); }
.sheet-row {
    display: grid; grid-template-columns: 64px 1fr auto; gap: 12px; align-items: center;
    padding: 10px 0; border-bottom: 1px solid var(--sand);
}
.sheet-row img { width: 64px; height: 52px; object-fit: cover; border-radius: 8px; }

/* ── REKOMENDASI CARD ENHANCEMENTS (REVISI 2) ── */
.rekomendasi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
    gap: var(--sp-4);
    align-items: stretch;
}

.rekomen-card {
    background: #fff;
    border: 1.5px solid rgba(226,205,177,.4);
    border-radius: 16px;
    padding: 0;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    position: relative;
    box-shadow: var(--shadow-sm);
    transition: transform var(--dur) var(--ease), box-shadow var(--dur) var(--ease), border-color var(--dur) var(--ease);
}
.rekomen-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 26px rgba(196,127,94,.18);
    border-color: var(--terracotta);
}

.rekomen-img-wrap {
    width: 100%;
    aspect-ratio: 4 / 3;
    overflow: hidden;
    position: relative;
    background: var(--sand);
}
.rekomen-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform var(--dur) var(--ease);
}
.rekomen-card:hover .rekomen-img-wrap img {
    transform: scale(1.06);
}

/* Out of stock on recommendation card */
.rekomen-card.rekomen-habis .rekomen-img-wrap img {
    filter: grayscale(0.85);
    opacity: 0.55;
}
.rekomen-oos-badge {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: var(--brick);
    color: #fff;
    font-size: 11px;
    font-weight: 800;
    padding: 4px 12px;
    border-radius: var(--r-pill);
    box-shadow: var(--shadow-md);
    letter-spacing: 0.05em;
    z-index: 2;
}

.rekomen-card-body {
    padding: 12px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.rekomen-kategori-label {
    align-self: flex-start;
    font-size: 10px;
    background: rgba(196,127,94,.1);
    color: var(--terracotta);
    border-radius: 4px;
    padding: 2px 7px;
    margin-bottom: 6px;
    font-weight: 600;
}

.rekomen-nama {
    font-size: var(--fs-sm);
    font-weight: 700;
    color: var(--espresso);
    margin: 0 0 4px 0;
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 2.7em;
}

.rekomen-harga {
    font-family: var(--font-heading);
    font-size: var(--fs-sm);
    font-weight: 700;
    color: var(--mocha);
    margin-bottom: 10px;
    font-variant-numeric: tabular-nums;
}

.rekomen-btn-wrap {
    margin-top: auto;
}
.rekomen-card .rekomen-btn {
    display: block;
    width: 100%;
    box-sizing: border-box;
    text-align: center;
    background: var(--grad-btn);
    color: #fff;
    font-size: var(--fs-xs);
    font-weight: 700;
    padding: 8px 10px;
    border-radius: var(--r-btn);
    text-decoration: none;
    border: none;
    cursor: pointer;
    box-shadow: var(--shadow-btn);
    transition: all var(--dur-fast) var(--ease);
}
.rekomen-card .rekomen-btn:hover {
    filter: brightness(1.08);
    box-shadow: var(--shadow-btn-hover);
    transform: translateY(-1px);
}
.rekomen-card .rekomen-btn[disabled] {
    background: var(--sand);
    color: var(--taupe);
    box-shadow: none;
    cursor: not-allowed;
    transform: none;
}

/* Skeleton shimmer */
.rekomen-skeleton-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
    gap: var(--sp-4);
}
.rekomen-skeleton-card {
    background: #fff;
    border: 1px solid var(--sand);
    border-radius: 16px;
    overflow: hidden;
}
.skeleton-box {
    background: linear-gradient(90deg, #EFE3D3 25%, #FFFDF9 50%, #EFE3D3 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite;
}
@keyframes shimmer {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* Clock pulse animation */
.clock-icon-live {
    display: inline-block;
    animation: clockBeat 2s infinite ease-in-out;
}
@keyframes clockBeat {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.15); }
}

/* Responsive carousel snap on small screens */
@media (max-width: 520px) {
    .rekomendasi-grid {
        display: flex;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        padding-bottom: 12px;
        -webkit-overflow-scrolling: touch;
        gap: 12px;
    }
    .rekomen-card {
        flex: 0 0 175px;
        scroll-snap-align: start;
    }
}
</style>
</head>

<body>

<!-- ══ HERO HEADER ═════════════════════════════════════════════ -->
<div class="header-hero">
    <img src="<?= base_url($logo) ?>" class="logo" alt="Logo" onerror="this.src='<?= base_url('uploads/default-logo.png') ?>'">
    <h1><?= esc($nama_warkop) ?></h1>
    <p id="greetingText">Silahkan pilih menu</p>
    <div class="badge-meja" style="margin-top:12px;">
        🍽️ <?= esc($meja['nama'] ?? $id_meja) ?>
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

        <!-- Loading state with skeleton shimmer -->
        <div class="rekomen-loading" id="rekomendasiLoading" style="padding:var(--sp-4) 0;">
            <div class="rekomen-skeleton-grid">
                <?php for($i=0; $i<4; $i++): ?>
                <div class="rekomen-skeleton-card">
                    <div class="skeleton-box" style="width:100%; aspect-ratio:4/3;"></div>
                    <div style="padding:12px;">
                        <div class="skeleton-box" style="height:12px; width:45%; border-radius:4px; margin-bottom:8px;"></div>
                        <div class="skeleton-box" style="height:14px; width:80%; border-radius:4px; margin-bottom:6px;"></div>
                        <div class="skeleton-box" style="height:14px; width:60%; border-radius:4px; margin-bottom:12px;"></div>
                        <div class="skeleton-box" style="height:28px; width:100%; border-radius:8px;"></div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- Grid hasil rekomendasi -->
        <div class="rekomendasi-grid" id="rekomendasiGrid" style="display:none;"></div>

        <div class="rekomendasi-footer" id="rekomendasiFooter" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; margin-top:var(--sp-4);">
            <div id="liveClockChip" style="font-family:var(--font-body); font-variant-numeric:tabular-nums; font-weight:600; font-size:var(--fs-xs); color:var(--espresso); background:var(--sand); padding:4px 12px; border-radius:var(--r-pill); display:inline-flex; align-items:center; gap:6px;">
                <span class="clock-icon-live">⏱️</span>
                <span id="liveClockText">--:--:--</span>
            </div>
            <div id="methodBadgeText" style="font-size:var(--fs-xs); color:var(--taupe); font-weight:600;">
                Metode: Memuat...
            </div>
        </div>
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
                    <div class="card-price tabular-nums" data-price="<?= (float) $p['harga'] ?>" data-es="<?= (float) ($p['tambahan_harga_es'] ?? 0) ?>">
                        Rp <?= number_format($p['harga'], 0, ',', '.') ?>
                    </div>
                    <?php if (!empty($p['varian_suhu'])):
                        $defaultSuhu = in_array($p['id_produk'], ['PRD0000016','PRD0000017','PRD0000019'], true) ? 'es' : 'panas';
                    ?>
                    <div class="suhu-toggle" data-id="<?= esc($p['id_produk']) ?>">
                        <button type="button" class="<?= $defaultSuhu === 'panas' ? 'active' : '' ?>" onclick="setSuhu(this,'panas')">Panas</button>
                        <button type="button" class="<?= $defaultSuhu === 'es' ? 'active' : '' ?>" onclick="setSuhu(this,'es')">Es<?= !empty($p['tambahan_harga_es']) ? ' +' . number_format($p['tambahan_harga_es'], 0, ',', '.') : '' ?></button>
                    </div>
                    <?php endif; ?>
                    <p style="margin:6px 0 12px;">
                        <?php if ($p['stok'] <= 0): ?>
                            <span class="badge-stok stok-habis">Habis</span>
                        <?php elseif ($p['stok'] <= 5): ?>
                            <span class="badge-stok stok-tipis"><?= (int) $p['stok'] ?> tersisa</span>
                        <?php else: ?>
                            <span class="badge-stok stok-aman"><?= (int) $p['stok'] ?></span>
                        <?php endif; ?>
                    </p>
                    <div class="btn-add-wrap">
                        <?php if ($p['stok'] > 0): ?>
                        <a href="<?= base_url('/cart/add/'.$p['id_produk'].'/'.$id_meja) ?><?= !empty($p['varian_suhu']) ? '?suhu='.$defaultSuhu : '' ?>"
                           class="btn btn-block btn-sm"
                           data-add-id="<?= esc($p['id_produk']) ?>"
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
<div class="sheet-backdrop" id="groupSheet" onclick="closeGroupSheet(event)">
    <div class="bottom-sheet" onclick="event.stopPropagation()">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
            <h3 id="groupSheetTitle" style="margin:0;">Pilih Menu</h3>
            <button type="button" class="btn btn-sm" onclick="closeGroupSheet()">Tutup</button>
        </div>
        <div id="groupSheetBody" style="margin-top:12px;"></div>
    </div>
</div>

<!-- ══ SCRIPTS ════════════════════════════════════════════════ -->
<script src="<?= base_url('assets/theme.js') ?>"></script>
<script>
// ── LIVE REAL-TIME CLOCK (WIB Asia/Jakarta) & SEGMENT MANAGER ──
var liveClockInterval = null;
var lastActiveSegment = null;

var NAMA_HARI = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
var NAMA_BULAN = [
    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
];

/**
 * Format date in Asia/Jakarta (WIB) timezone:
 * Format exact: [hari]-[tanggal]-[bulan]-[tahun], [jam]:[menit].[detik]
 * Contoh output: "Selasa-13-Oktober-2026, 08:09.32"
 */
function formatWaktuWIB(date) {
    var parts = {};
    try {
        var dtf = new Intl.DateTimeFormat('id-ID', {
            timeZone: 'Asia/Jakarta',
            weekday: 'long',
            day: '2-digit',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        });
        dtf.formatToParts(date).forEach(function (p) {
            parts[p.type] = p.value;
        });
        
        // Capitalize hari & bulan
        var hari = parts.weekday ? parts.weekday.charAt(0).toUpperCase() + parts.weekday.slice(1) : '';
        var tgl = (parts.day || '').padStart(2, '0');
        var bln = parts.month ? parts.month.charAt(0).toUpperCase() + parts.month.slice(1) : '';
        var thn = parts.year || '';
        var jam = (parts.hour || '').padStart(2, '0');
        var mnt = (parts.minute || '').padStart(2, '0');
        var dtk = (parts.second || '').padStart(2, '0');

        return hari + '-' + tgl + '-' + bln + '-' + thn + ', ' + jam + ':' + mnt + '.' + dtk;
    } catch (e) {
        // Fallback manual UTC+7 calculation
        var utc = date.getTime() + (date.getTimezoneOffset() * 60000);
        var wib = new Date(utc + (7 * 3600000));
        var d = wib.getDay();
        var dd = String(wib.getDate()).padStart(2, '0');
        var mm = wib.getMonth();
        var yyyy = wib.getFullYear();
        var hh = String(wib.getHours()).padStart(2, '0');
        var ii = String(wib.getMinutes()).padStart(2, '0');
        var ss = String(wib.getSeconds()).padStart(2, '0');
        return NAMA_HARI[d] + '-' + dd + '-' + NAMA_BULAN[mm] + '-' + yyyy + ', ' + hh + ':' + ii + '.' + ss;
    }
}

/**
 * Dapatkan jam sekarang dalam zona WIB (0-23)
 */
function getJamWIB() {
    try {
        var dtf = new Intl.DateTimeFormat('id-ID', {
            timeZone: 'Asia/Jakarta',
            hour: 'numeric',
            hour12: false
        });
        return parseInt(dtf.format(new Date()), 10);
    } catch (e) {
        var utc = new Date().getTime() + (new Date().getTimezoneOffset() * 60000);
        var wib = new Date(utc + (7 * 3600000));
        return wib.getHours();
    }
}

/**
 * Dapatkan kode segmen berdasarkan jam WIB
 */
function getSegmenByHour(h) {
    if (h >= 5 && h <= 10) return 'pagi';
    if (h >= 11 && h <= 14) return 'siang';
    if (h >= 15 && h <= 17) return 'sore';
    return 'malam';
}

(function () {
    var ID_MEJA   = '<?= esc($id_meja) ?>';
    var BASE_URL  = '<?= base_url() ?>';
    var API_URL   = BASE_URL + 'api/rekomendasi';

    var RENTANG_SEGMEN = {
        pagi:  'Pagi · 05.00–10.59',
        siang: 'Siang · 11.00–14.59',
        sore:  'Sore · 15.00–17.59',
        malam: 'Malam · 18.00–04.59'
    };

    var EMOJI_SEGMEN = {
        pagi: '🌅', siang: '☀️', sore: '🌤️', malam: '🌙'
    };

    function updateGreetingAndHeader(segmen) {
        var h = getJamWIB();
        var text = 'Selamat ' + segmen;
        var emoji = EMOJI_SEGMEN[segmen] || '☕';
        var greetEl = document.getElementById('greetingText');
        if (greetEl) {
            greetEl.textContent = text + ' ' + emoji + ' — Silahkan pilih menu';
        }
    }

    // Start live clock
    function startLiveClock() {
        var clockEl = document.getElementById('liveClockText');
        if (!clockEl) return;

        function tick() {
            var now = new Date();
            clockEl.textContent = formatWaktuWIB(now);

            // Periksa perpindahan segmen (05:00:00, 11:00:00, 15:00:00, 18:00:00)
            var currentSeg = getSegmenByHour(getJamWIB());
            if (lastActiveSegment !== null && currentSeg !== lastActiveSegment) {
                lastActiveSegment = currentSeg;
                // Fade reload rekomendasi tanpa refresh halaman
                var box = document.getElementById('rekomendasiBox');
                if (box) {
                    box.style.opacity = '0.5';
                    box.style.transition = 'opacity 0.3s ease';
                }
                loadRekomendasi();
            }
        }

        tick();
        liveClockInterval = setInterval(tick, 1000);
    }

    // Bersihkan interval saat berpindah/unload
    window.addEventListener('beforeunload', function () {
        if (liveClockInterval) {
            clearInterval(liveClockInterval);
            liveClockInterval = null;
        }
    });

    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    window.renderSuhuToggle = function(id, suhu, tambahan, scope) {
        return "<div class=\"suhu-toggle\" data-id=\"" + id + "\">" +
            "<button type=\"button\" class=\"" + (suhu === "panas" ? "active" : "") + "\" onclick=\"setSuhu(this,'panas')\">Panas</button>" +
            "<button type=\"button\" class=\"" + (suhu === "es" ? "active" : "") + "\" onclick=\"setSuhu(this,'es')\">Es" + (Number(tambahan) > 0 ? " +" + Number(tambahan).toLocaleString("id-ID") : "") + "</button>" +
            "</div>";
    };

    function renderRekomendasi(data) {
        var grid        = document.getElementById('rekomendasiGrid');
        var loading     = document.getElementById('rekomendasiLoading');
        var emoji       = document.getElementById('rekomendasiEmoji');
        var subtitle    = document.getElementById('rekomendasiSubtitle');
        var methodBadge = document.getElementById('methodBadgeText');
        var box         = document.getElementById('rekomendasiBox');

        if (box) { box.style.opacity = '1'; }

        lastActiveSegment = data.segmen || getSegmenByHour(getJamWIB());
        updateGreetingAndHeader(lastActiveSegment);

        emoji.textContent = EMOJI_SEGMEN[lastActiveSegment] || data.emoji || '🍽️';
        
        // Tampilkan rentang segmen aktif di subtitle
        var rentangText = RENTANG_SEGMEN[lastActiveSegment] || '';
        subtitle.textContent = rentangText ? rentangText + ' · Rekomendasi menu pas untuk saat ini' : 'Rekomendasi menu pas untuk saat ini';

        // Deteksi metode (KNN vs Rule-based)
        var isKnn = (data.source && data.source.toLowerCase().indexOf('knn') !== -1);
        var srcLabel = isKnn ? 'KNN' : 'Rule-based';

        var badgeMl = document.querySelector('.badge-ml');
        if (badgeMl) {
            badgeMl.textContent = isKnn ? '✨ AI · KNN' : '📋 RULE-BASED';
        }

        if (methodBadge) {
            methodBadge.textContent = 'Metode: ' + srcLabel;
        }

        if (!data.rekomendasi || data.rekomendasi.length === 0) {
            loading.innerHTML = '<p style="color:var(--taupe); text-align:center; padding:16px;">Tidak ada rekomendasi khusus untuk saat ini.</p>';
            loading.style.display = 'block';
            grid.style.display    = 'none';
            return;
        }

        window.rekomendasiGroups = {};
        var html = '';
        data.rekomendasi.forEach(function (item, idx) {
            var suhuDefault = item.suhu_default || data.suhu_default || '';
            var addUrl = BASE_URL + 'cart/add/' + item.id_produk + '/' + ID_MEJA + (suhuDefault ? '?suhu=' + suhuDefault : '');
            var isHabis = (item.stok !== null && item.stok !== undefined && item.stok <= 0);
            var cardClass = 'rekomen-card reveal' + (isHabis ? ' rekomen-habis' : '');
            var imgUrl = item.gambar || (BASE_URL + 'assets/noimage.png');

            html += '<div class="' + cardClass + '" style="--delay:' + (idx * 60) + 'ms;">';
            html += '  <div class="rank-badge">#' + (idx + 1) + '</div>';
            
            // Image wrapper
            html += '  <div class="rekomen-img-wrap">';
            html += '    <img src="' + imgUrl + '" alt="' + item.nama + '" loading="lazy" onerror="this.onerror=null;this.src=\'' + BASE_URL + 'assets/noimage.png\';">';
            if (isHabis) {
                html += '    <span class="rekomen-oos-badge">Habis</span>';
            }
            html += '  </div>';

            // Card Body
            html += '  <div class="rekomen-card-body">';
            html += '    <div class="rekomen-kategori-label">' + (item.tipe === 'kelompok' ? 'Kelompok Menu' : item.kategori) + '</div>';
            html += '    <h3 class="rekomen-nama" title="' + (item.nama_kelompok || item.nama) + '">' + (item.nama_kelompok || item.nama) + '</h3>';
            if (item.tipe === 'kelompok') {
                var anggota = item.anggota || [];
                window.rekomendasiGroups['g' + idx] = item;
                html += '    <div class="group-members">' + anggota.map(function(a){ return a.nama; }).join(', ') + '</div>';
            } else {
                html += '    <div class="rekomen-harga">' + formatRupiah(Number(item.harga || 0) + (suhuDefault === 'es' ? Number(item.tambahan_harga_es || 0) : 0)) + '</div>';
                if (Number(item.varian_suhu || 0) === 1) {
                    html += renderSuhuToggle(item.id_produk, suhuDefault || 'panas', item.tambahan_harga_es || 0, 'rek');
                }
            }
            
            html += '    <div class="rekomen-btn-wrap">';
            if (item.tipe === 'kelompok') {
                html += '      <button class="rekomen-btn" type="button" onclick="openGroupSheet(\'g' + idx + '\')">Pilih Menu</button>';
            } else if (isHabis) {
                html += '      <button class="rekomen-btn" disabled>Habis</button>';
            } else {
                html += '      <a href="' + addUrl + '" class="rekomen-btn" data-add-id="' + item.id_produk + '" onclick="showAddToast(\'' + item.nama.replace(/'/g, "\\'") + '\')">+ Tambah</a>';
            }
            html += '    </div>';

            html += '  </div>';
            html += '</div>';
        });

        loading.style.display = 'none';
        grid.innerHTML        = html;
        grid.style.display    = (window.innerWidth <= 520) ? 'flex' : 'grid';

        // Stagger fade-up reveal (60ms)
        setTimeout(function() {
            grid.querySelectorAll('.reveal').forEach(function(el, i) {
                setTimeout(function() {
                    el.classList.add('is-visible');
                }, i * 60);
            });
        }, 80);
    }

    function loadRekomendasi() {
        fetch(API_URL)
            .then(function (res) { return res.json(); })
            .then(function (json) {
                if (json.status === 'success') {
                    renderRekomendasi(json.data);
                } else {
                    document.getElementById('rekomendasiLoading').innerHTML =
                        '<p style="color:var(--taupe);font-size:var(--fs-sm); text-align:center;">Rekomendasi tidak tersedia saat ini.</p>';
                }
            })
            .catch(function () {
                document.getElementById('rekomendasiLoading').innerHTML =
                    '<p style="color:var(--taupe);font-size:var(--fs-sm); text-align:center;">Gagal memuat rekomendasi.</p>';
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        startLiveClock();
        loadRekomendasi();
    });

    // Auto-refresh rekomendasi tiap 5 menit
    setInterval(loadRekomendasi, 5 * 60 * 1000);
})();

// ── Category Filter ──
function filterCategory(kat, btn) {
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
    if (q) {
        document.querySelectorAll('.kategori-section').forEach(function(s) { s.style.display = ''; });
    }
}

function setSuhu(btn, suhu) {
    var wrap = btn.closest('.suhu-toggle');
    if (!wrap) return;
    wrap.querySelectorAll('button').forEach(function(b) { b.classList.remove('active'); });
    btn.classList.add('active');
    var id = wrap.dataset.id;
    document.querySelectorAll('[data-add-id="' + id + '"]').forEach(function(link) {
        var base = link.href.split('?')[0];
        link.href = base + '?suhu=' + suhu;
    });
    var card = wrap.closest('.product-card');
    if (card) {
        var priceEl = card.querySelector('.card-price');
        if (priceEl) {
            var basePrice = Number(priceEl.dataset.price || 0);
            var es = Number(priceEl.dataset.es || 0);
            priceEl.textContent = 'Rp ' + (basePrice + (suhu === 'es' ? es : 0)).toLocaleString('id-ID');
        }
    }
}

function openGroupSheet(key) {
    var data = window.rekomendasiGroups && window.rekomendasiGroups[key];
    if (!data) return;
    document.getElementById('groupSheetTitle').textContent = data.nama_kelompok || 'Pilih Menu';
    var body = document.getElementById('groupSheetBody');
    var html = '';
    (data.anggota || []).forEach(function(item) {
        var suhu = data.suhu_default || item.suhu_default || '';
        var addUrl = '<?= base_url() ?>cart/add/' + item.id_produk + '/<?= esc($id_meja) ?>' + (suhu ? '?suhu=' + suhu : '');
        html += '<div class="sheet-row">';
        html += '<img src="' + (item.gambar || '<?= base_url('assets/noimage.png') ?>') + '" onerror="this.src=&quot;<?= base_url('assets/noimage.png') ?>&quot;">';
        html += '<div><strong>' + item.nama + '</strong><div style="font-size:12px;color:var(--taupe);">' + item.kategori + ' - Rp ' + Number(item.harga || 0).toLocaleString('id-ID') + '</div>';
        if (Number(item.varian_suhu || 0) === 1) html += renderSuhuToggle(item.id_produk, suhu || 'panas', item.tambahan_harga_es || 0, 'sheet');
        html += '</div>';
        html += item.stok <= 0 ? '<button class="btn btn-sm" disabled>Habis</button>' : '<a class="btn btn-sm" data-add-id="' + item.id_produk + '" href="' + addUrl + '" onclick="showAddToast(\\'' + item.nama.replace(/'/g, "\\'") + '\\')">+ Tambah</a>';
        html += '</div>';
    });
    body.innerHTML = html;
    document.getElementById('groupSheet').classList.add('show');
}

function closeGroupSheet(event) {
    if (event && event.target && event.target.id !== 'groupSheet') return;
    document.getElementById('groupSheet').classList.remove('show');
}

// ── Add to cart toast ──
function showAddToast(name) {
    var toast = document.getElementById('addToast');
    if (!toast) return;
    toast.textContent = '✓ ' + name + ' ditambahkan ke keranjang';
    toast.classList.add('show');
    setTimeout(function() { toast.classList.remove('show'); }, 2000);
}

// ── Show cart bar ──
document.addEventListener('DOMContentLoaded', function() {
    var bar = document.getElementById('cartBar');
    if (bar) {
        setTimeout(function() { bar.classList.add('show'); }, 500);
    }
});
</script>

</body>
</html>
