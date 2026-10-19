<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Menu — <?= esc($nama_warkop) ?></title>
<link rel="stylesheet" href="<?= base_url('assets/theme.css') ?>">
<style>
.container {
    padding-bottom: 112px;
}

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
.product-description {
    color: var(--taupe);
    font-size: var(--fs-xs);
    line-height: 1.5;
    margin: 4px 0 8px;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
    overflow: hidden;
}

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
.subcategory-chips { position: static; top: auto; z-index: auto; margin-top: calc(-1 * var(--sp-3)); }

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
.option-choice {
    display: flex; align-items: center; justify-content: space-between; gap: 12px;
    width: 100%; padding: 12px; margin: 8px 0; border: 1px solid var(--sand);
    border-radius: var(--r-md); background: #fff; color: var(--espresso);
    text-align: left; cursor: pointer;
}
.option-choice.selected { border-color: var(--terracotta); box-shadow: 0 0 0 2px rgba(196,127,94,.16); }

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
.rekomen-pitch {
    color: var(--mocha);
    font-size: var(--fs-xs);
    line-height: 1.45;
    margin: 2px 0 10px;
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

    <?php if (session()->getFlashdata('error')): ?>
    <div role="alert" class="badge" style="display:block; margin:12px 0; padding:12px; background:var(--brick-light); color:var(--brick);">
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
    <?php endif; ?>

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
        $coffeeCategories = ['Kopi Panas', 'Es Kopi', 'Minuman Kopi'];
        $nonCoffeeCategories = ['Es Nutrisari', 'Minuman Non Kopi'];
        foreach ($products as $p) {
            $kategori = $p['kategori'];
            if (in_array($kategori, $coffeeCategories, true)) {
                $kategori = 'Kopi';
            } elseif (in_array($kategori, $nonCoffeeCategories, true)) {
                $kategori = 'Non Kopi';
            }
            if (!isset($produk_by_kategori[$kategori])) {
                $produk_by_kategori[$kategori] = [];
            }
            $produk_by_kategori[$kategori][] = $p;
        }
    ?>
    <div class="category-chips reveal" id="categoryChips">
        <button class="chip active" onclick="filterCategory('all', this)">Semua</button>
        <button class="chip" onclick="filterCategory('panas', this)">Minuman Panas</button>
        <button class="chip" onclick="filterCategory('dingin', this)">Minuman Dingin</button>
        <?php foreach (array_keys($produk_by_kategori) as $kat): ?>
        <?php if (!in_array($kat, ['Kopi', 'Non Kopi'], true)): ?>
        <button class="chip" onclick="filterCategory('<?= esc($kat) ?>', this)"><?= esc($kat) ?></button>
        <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <div class="category-chips subcategory-chips" id="drinkSubcategoryChips" style="display:none;">
        <button class="chip active" onclick="filterDrinkType('all', this)">Semua</button>
        <button class="chip" onclick="filterDrinkType('kopi', this)">Kopi</button>
        <button class="chip" onclick="filterDrinkType('non-kopi', this)">Non Kopi</button>
    </div>

    <!-- ══ PRODUCT GRID PER KATEGORI ══════════════════════════ -->
    <?php foreach ($produk_by_kategori as $kategori => $items): ?>
    <?php
        $sectionDrinkType = $kategori === 'Kopi' ? 'kopi' : ($kategori === 'Non Kopi' ? 'non-kopi' : '');
    ?>
    <div class="kategori-section" data-kategori="<?= esc($kategori) ?>" data-jenis-minuman="<?= esc($sectionDrinkType) ?>">
        <h2 class="kategori-title reveal" data-judul-asli="<?= esc($kategori) ?>"><?= esc($kategori) ?></h2>
        <div class="grid">
            <?php foreach ($items as $p): ?>
            <?php
                $isCoffee = in_array($p['kategori'], $coffeeCategories, true);
                $isDrink = $isCoffee || in_array($p['kategori'], $nonCoffeeCategories, true);
                if (!$isDrink) {
                    $drinkTemperatures = '';
                } elseif (!empty($p['varian_suhu'])) {
                    $drinkTemperatures = 'panas,dingin';
                } elseif (($p['suhu_tetap'] ?? '') === 'panas') {
                    $drinkTemperatures = 'panas';
                } else {
                    $drinkTemperatures = 'dingin';
                }
            ?>
            <div class="card product-card reveal <?= $p['stok'] <= 0 ? 'out-of-stock' : '' ?>"
                 data-nama="<?= strtolower(esc($p['nama'])) ?>"
                 data-jenis-minuman="<?= $isDrink ? ($isCoffee ? 'kopi' : 'non-kopi') : '' ?>"
                 data-suhu-minuman="<?= esc($drinkTemperatures) ?>"
                 style="position:relative;">

                <?php if ($p['stok'] <= 0): ?>
                    <span class="oos-label">Stok Habis</span>
                <?php endif; ?>

                <img src="<?= base_url(!empty($p['gambar']) ? 'uploads/'.$p['gambar'] : 'assets/no-image.svg') ?>"
                     alt="<?= esc($p['nama']) ?>"
                     onerror="this.src='<?= base_url('assets/no-image.svg') ?>'">

                <div class="card-body">
                    <h3 class="card-title"><?= esc($p['nama']) ?></h3>
                    <?php if (!empty($p['deskripsi'])): ?>
                    <p class="product-description"><?= esc($p['deskripsi']) ?></p>
                    <?php endif; ?>
                    <div class="card-price tabular-nums" data-price="<?= (float) $p['harga'] ?>" data-es="<?= (float) ($p['tambahan_harga_es'] ?? 0) ?>">
                        Rp <?= number_format($p['harga'], 0, ',', '.') ?>
                    </div>
                    <?php if (!empty($p['suhu_tetap'])): ?>
                    <span class="badge" style="align-self:flex-start; margin-top:6px; background:var(--sand); color:var(--espresso);">
                        <?= $p['suhu_tetap'] === 'panas' ? 'Panas' : 'Es' ?>
                    </span>
                    <?php endif; ?>
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
                            <span class="badge-stok stok-tipis"><?= $p['stok'] ?> tersisa</span>
                        <?php else: ?>
                            <span class="badge-stok stok-aman"><?= $p['stok'] ?></span>
                        <?php endif; ?>
                    </p>
                    <div class="btn-add-wrap">
                        <?php if ($p['stok'] > 0): ?>
                        <?php if (!empty($p['punya_opsi'])): ?>
                        <button type="button" class="btn btn-block btn-sm" onclick="openOptionSheet('<?= esc($p['id_produk']) ?>')">
                            <?= esc($p['label_opsi'] ?: 'Pilih varian') ?>
                        </button>
                        <?php else: ?>
                        <a href="<?= base_url('/cart/add/'.$p['id_produk'].'/'.$id_meja) ?><?= !empty($p['varian_suhu']) ? '?suhu='.$defaultSuhu : '' ?>"
                           class="btn btn-success btn-block btn-sm"
                           data-add-id="<?= esc($p['id_produk']) ?>"
                           onclick="showAddToast('<?= esc($p['nama']) ?>')">
                            + Tambah
                        </a>
                        <?php endif; ?>
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
            <button type="button" class="btn btn-secondary btn-sm" onclick="closeGroupSheet()">Tutup</button>
        </div>
        <div id="groupSheetBody" style="margin-top:12px;"></div>
    </div>
</div>

<!-- ══ SCRIPTS ════════════════════════════════════════════════ -->
<script src="<?= base_url('assets/theme.js') ?>"></script>
<script>
window.variantProductData = <?= json_encode(
    array_column($products, null, 'id_produk'),
    JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
) ?>;
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
        var text = 'Selamat ' + segmen;
        var emoji = EMOJI_SEGMEN[segmen] || '☕';
        var greetEl = document.getElementById('greetingText');
        if (greetEl) {
            greetEl.textContent = text + ' ' + emoji + ' — Silahkan pilih menu';
        }
    }

    function startLiveClock() {
        var clockEl = document.getElementById('liveClockText');
        if (!clockEl) return;

        function tick() {
            var now = new Date();
            clockEl.textContent = formatWaktuWIB(now);

            var currentSeg = getSegmenByHour(getJamWIB());
            if (lastActiveSegment !== null && currentSeg !== lastActiveSegment) {
                lastActiveSegment = currentSeg;
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

    window.addEventListener('beforeunload', function () {
        if (liveClockInterval) {
            clearInterval(liveClockInterval);
            liveClockInterval = null;
        }
    });

    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
    window.formatRupiah = formatRupiah;

    function getRecommendationPitch(item, segmen, suhu) {
        var segment = segmen || 'pagi';
        var productPitches = {
            PRD0000001: 'Aroma bumbu nasi goreng yang akrab langsung bikin waktu makan terasa lebih istimewa.',
            PRD0000002: 'Mie goreng berbumbu dengan telur, pilihan praktis saat ingin sajian gurih tanpa menunggu lama.',
            PRD0000003: 'Kuah hangat dan telur menjadikannya pilihan nyaman saat ingin santapan yang berkuah.',
            PRD0000004: 'Kacang hijau yang lembut dan rasa manisnya pas untuk jeda dari menu gurih.',
            PRD0000005: 'Porsi mungil yang seru dinikmati satu per satu, apalagi ditemani sate pilihan.',
            PRD0000006: 'Pancong hangat bertabur keju menghadirkan gurih yang pas untuk teman ngopi.',
            PRD0000007: 'Roti panggang dengan cokelat manis, camilan sederhana yang selalu menggoda saat baru disajikan.',
            PRD0000008: 'Kentang goreng renyah cocok jadi teman ngobrol atau camilan untuk dinikmati bersama.',
            PRD0000009: 'Bakwan gurih dengan tekstur renyah, paling nikmat disantap selagi hangat.',
            PRD0000010: 'Tempe goreng dengan rasa gurih yang akrab, pas untuk tambahan camilan atau lauk.',
            PRD0000011: 'Tahu goreng renyah di luar dan lembut di dalam, pilihan ringan untuk menemani rehat.',
            PRD0000012: 'Dimsum lembut berbalut saus mentai yang creamy untuk kamu yang ingin camilan lebih spesial.',
            PRD0000013: 'Sate telur dengan gigitan praktis dan rasa gurih, enak dipilih sebagai teman camilan.',
            PRD0000014: 'Sate usus berbumbu menawarkan rasa gurih khas yang bikin pilihan sate makin beragam.',
            PRD0000015: 'Sate ati ampela berbumbu kuat, pas untuk pencinta lauk dengan rasa yang lebih mantap.',
            PRD0000016: 'Cokelat malt Milo memberi rasa familiar yang nikmat, baik untuk teman rehat maupun makan.',
            PRD0000017: 'Rasa jeruknya memberi pilihan berbeda saat ingin minuman dengan sentuhan buah.',
            PRD0000018: 'Teh manis klasik dengan rasa yang akrab, mudah dipadukan dengan camilan atau makanan berat.',
            PRD0000019: 'Perpaduan teh dan lemon menghadirkan rasa segar dengan sentuhan asam yang ringan.',
            PRD0000021: 'Susu putih berkarakter lembut, pilihan sederhana saat ingin minuman yang tidak terlalu kuat rasanya.',
            PRD0000022: 'Air mineral jadi pendamping netral yang pas untuk melengkapi menu apa pun.',
            PRD0000023: 'Cappuccino memadukan kopi dan susu dalam rasa creamy untuk jeda ngopi yang lebih lembut.',
            PRD0000024: 'Kopi susu menyatukan pahit kopi dan lembut susu dalam satu gelas yang seimbang.',
            PRD0000025: 'Kopi hitam cocok untuk yang ingin menikmati karakter kopi yang tegas tanpa campuran.',
            PRD0000026: 'Nasi kuning berbumbu gurih memberi pilihan sarapan yang terasa lengkap dan memuaskan.',
            PRD0000027: 'Aroma nasi uduk yang gurih membuat menu ini pas untuk mengisi waktu makan dengan nikmat.',
            PRD0000028: 'Lontong sayur dengan kuah berbumbu menghadirkan kombinasi lembut dan gurih dalam satu sajian.',
            PRD0000029: 'Bubur ayam yang hangat dan gurih cocok saat ingin makan dengan tekstur lebih lembut.',
            PRD0000030: 'Ayam geprek dan nasi menyatukan sensasi pedas serta porsi mengenyangkan dalam satu pilihan.',
            PRD0000031: 'ABC Susu menawarkan racikan kopi instan yang praktis dengan rasa kopi-susu yang akrab.',
            PRD0000032: 'Indocafe punya rasa kopi yang lembut, cocok untuk teman jeda tanpa rasa yang terlalu kuat.',
            PRD0000033: 'Kapal Api Special Mix memadukan kopi dan gula untuk rasa klasik yang langsung siap dinikmati.',
            PRD0000034: 'Good Day Biasa memberi pilihan rasa kopi yang bisa disesuaikan dengan varian favoritmu.',
            PRD0000035: 'Luwak White Coffee berkarakter creamy dan lembut, pas untuk penikmat kopi yang ringan.',
            PRD0000036: 'Torabika Creamy Latte memadukan kopi dan krimer untuk sensasi latte yang halus.',
            PRD0000037: 'Good Day Freeze hadir dengan karakter kopi dingin dan pilihan rasa yang menarik untuk dicoba.',
            PRD0000038: 'Nescafe Ice Roast menyuguhkan karakter kopi yang terasa mantap dalam sajian dingin.',
            PRD0000039: 'ABC Klepon membawa sentuhan rasa klepon ke dalam kopi dingin yang unik dan manis.',
            PRD0000040: 'Good Day Biasa versi es memberi cara berbeda menikmati rasa favorit dalam sajian dingin.',
            PRD0000041: 'Tora Cafe dingin cocok untuk yang ingin kopi praktis dengan sensasi lebih menyegarkan.',
            PRD0000042: 'Es Nutrisari dengan pilihan rasa buah memudahkanmu memilih kesegaran sesuai selera.'
        };
        var groupPitches = {
            'minuman panas': 'Pilih racikan kopi atau non-kopi sesuai selera, semuanya tersaji hangat untuk menemani jeda.',
            'minuman dingin': 'Bandingkan kopi dingin dan minuman buah, lalu pilih kesegaran yang paling kamu inginkan.',
            'gorengan': 'Pilih camilan goreng favorit untuk menambah teman di meja tanpa perlu pesan satu jenis saja.',
            'nasi kucing & sate-satean': 'Padukan porsi nasi kecil dengan sate pilihan untuk menikmati beberapa rasa sekaligus.',
            'es segar': 'Ada pilihan teh, jeruk, dan minuman dingin lain untuk disesuaikan dengan selera.',
            'kopi & teh panas': 'Temukan racikan kopi atau teh hangat yang paling pas dengan suasana jedamu.'
        };
        var groupName = String(item.nama_kelompok || '').toLowerCase();
        var pitch = item.tipe === 'kelompok'
            ? groupPitches[groupName]
            : productPitches[item.id_produk];

        if (!pitch) {
            var productName = String(item.nama_kelompok || item.nama || 'menu ini');
            pitch = 'Kenali karakter ' + productName + ' dari detail rasa dan sajian yang tertera, lalu pilih saat sesuai seleramu.';
        }

        var timeHooks = {
            pagi: [
                'Nikmati sebagai pembuka sebelum aktivitas mulai ramai.',
                'Pas dipilih saat suasana pagi masih santai.',
                'Jadikan jeda pagi lebih berkesan dengan pilihan ini.',
                'Teman yang pas sebelum melanjutkan rutinitas hari ini.'
            ],
            siang: [
                'Ambil jeda sejenak dan nikmati pilihan ini di tengah kesibukan.',
                'Cocok menemani waktu istirahat sebelum kembali beraktivitas.',
                'Beri warna pada waktu makan siang dengan sajian ini.',
                'Pilihan menarik untuk mengisi jeda di tengah hari.'
            ],
            sore: [
                'Nikmati perlahan saat waktunya mengambil rehat sore.',
                'Pas untuk menemani obrolan santai menjelang malam.',
                'Jadikan waktu santai sore punya rasa yang lebih istimewa.',
                'Teman yang cocok saat ingin berhenti sejenak dari aktivitas.'
            ],
            malam: [
                'Pilih untuk menemani waktu santai setelah aktivitas hari ini.',
                'Cocok dinikmati sambil menghabiskan waktu bersama teman.',
                'Lengkapi suasana malam dengan menu yang menggugah selera.',
                'Pas untuk menutup hari dengan jeda yang menyenangkan.'
            ]
        };
        var options = timeHooks[segment] || timeHooks.pagi;
        var idNumber = Number(String(item.id_produk || '').slice(-2));
        if (!idNumber) {
            idNumber = groupName.split('').reduce(function(total, character) {
                return total + character.charCodeAt(0);
            }, 0);
        }

        return pitch + ' ' + options[idNumber % options.length];
    }

    window.renderSuhuToggle = function(id, suhu, tambahan, scope) {
        var tambahanText = Number(tambahan) > 0 ? ' + ' + Number(tambahan).toLocaleString('id-ID') : '';
        return '<div class="suhu-toggle" data-id="' + id + '">' +
            '<button type="button" class="' + (suhu === "panas" ? "active" : "") + '" onclick="setSuhu(this,\'panas\')">Panas</button>' +
            '<button type="button" class="' + (suhu === "es" ? "active" : "") + '" onclick="setSuhu(this,\'es\')">Es' + tambahanText + '</button>' +
            '</div>';
    };

    function renderRekomendasi(data) {
        var grid = document.getElementById('rekomendasiGrid');
        var loading = document.getElementById('rekomendasiLoading');
        var emoji = document.getElementById('rekomendasiEmoji');
        var subtitle = document.getElementById('rekomendasiSubtitle');
        var methodBadge = document.getElementById('methodBadgeText');
        var box = document.getElementById('rekomendasiBox');

        if (!grid || !loading || !subtitle || !emoji) {
            return;
        }

        if (box) { box.style.opacity = '1'; }

        lastActiveSegment = data && data.segmen ? data.segmen : getSegmenByHour(getJamWIB());
        updateGreetingAndHeader(lastActiveSegment);

        emoji.textContent = EMOJI_SEGMEN[lastActiveSegment] || (data && data.emoji) || '🍽️';

        var rentangText = RENTANG_SEGMEN[lastActiveSegment] || '';
        subtitle.textContent = rentangText ? rentangText + ' · Rekomendasi menu pas untuk saat ini' : 'Rekomendasi menu pas untuk saat ini';

        var isKnn = (data && data.source && data.source.toLowerCase().indexOf('knn') !== -1);
        var srcLabel = isKnn ? 'KNN' : 'Rule-based';

        var badgeMl = document.querySelector('.badge-ml');
        if (badgeMl) {
            badgeMl.textContent = isKnn ? '✨ AI · KNN' : '📋 RULE-BASED';
        }

        if (methodBadge) {
            methodBadge.textContent = 'Metode: ' + srcLabel;
        }

        if (!data || !data.rekomendasi || data.rekomendasi.length === 0) {
            loading.innerHTML = '<p style="color:var(--taupe); text-align:center; padding:16px;">Tidak ada rekomendasi khusus untuk saat ini.</p>';
            loading.style.display = 'block';
            grid.style.display = 'none';
            return;
        }

        window.rekomendasiGroups = {};
        var html = '';
        data.rekomendasi.forEach(function (item, idx) {
            var suhuDefault = item.suhu_default || data.suhu_default || '';
            var addUrl = BASE_URL + 'cart/add/' + item.id_produk + '/' + ID_MEJA + (suhuDefault ? '?suhu=' + suhuDefault : '');
            var isHabis = (item.stok !== null && item.stok !== undefined && item.stok <= 0);
            var cardClass = 'rekomen-card reveal' + (isHabis ? ' rekomen-habis' : '');
            var imgUrl = item.gambar || (BASE_URL + 'assets/no-image.svg');

            html += '<div class="' + cardClass + '" style="--delay:' + (idx * 60) + 'ms;">';
            html += '  <div class="rank-badge">#' + (idx + 1) + '</div>';
            html += '  <div class="rekomen-img-wrap">';
            html += '    <img src="' + imgUrl + '" alt="' + item.nama + '" loading="lazy" onerror="this.onerror=null;this.src=\'' + BASE_URL + 'assets/no-image.svg\';">';
            if (isHabis) {
                html += '    <span class="rekomen-oos-badge">Habis</span>';
            }
            html += '  </div>';
            html += '  <div class="rekomen-card-body">';
            html += '    <div class="rekomen-kategori-label">' + escapeMenuHtml(item.tipe === 'kelompok' ? 'Kelompok Menu' : (item.kategori_rekomendasi || item.kategori)) + '</div>';
            html += '    <h3 class="rekomen-nama" title="' + escapeMenuHtml(item.nama_kelompok || item.nama) + '">' + escapeMenuHtml(item.nama_kelompok || item.nama) + '</h3>';
            html += '    <p class="rekomen-pitch">' + escapeMenuHtml(getRecommendationPitch(item, lastActiveSegment, suhuDefault)) + '</p>';
            if (item.tipe === 'kelompok') {
                var anggota = item.anggota || [];
                window.rekomendasiGroups['g' + idx] = item;
                if (anggota.some(function(a) { return a.subkategori; })) {
                    ['Kopi', 'Non Kopi'].forEach(function(subkategori) {
                        var pilihan = anggota.filter(function(a) { return a.subkategori === subkategori; });
                        if (!pilihan.length) return;
                        html += '    <div class="group-members"><strong>' + subkategori + ':</strong> ' + pilihan.map(function(a) {
                            return escapeMenuHtml(a.nama) + ' (' + formatRupiah(Number(a.harga || 0)) + ')';
                        }).join(', ') + '</div>';
                    });
                } else {
                    html += '    <div class="group-members">' + anggota.map(function(a) {
                        return escapeMenuHtml(a.nama) + ' (' + formatRupiah(Number(a.harga || 0)) + ')';
                    }).join(', ') + '</div>';
                }
            } else {
                window.variantProductData[item.id_produk] = item;
                if (item.deskripsi) html += '    <div class="group-members">' + escapeMenuHtml(item.deskripsi) + '</div>';
                html += '    <div class="rekomen-harga">' + formatRupiah(Number(item.harga || 0) + (suhuDefault === 'es' ? Number(item.tambahan_harga_es || 0) : 0)) + '</div>';
                if (Number(item.varian_suhu || 0) === 1) {
                    html += renderSuhuToggle(item.id_produk, suhuDefault || 'panas', item.tambahan_harga_es || 0, 'rek');
                }
                if (Number(item.punya_opsi || 0) === 1) {
                    html += '    <div class="group-members">' + getOptionLabel(item) + ' tersedia</div>';
                }
            }
            html += '    <div class="rekomen-btn-wrap">';
            if (item.tipe === 'kelompok') {
                html += '      <button class="rekomen-btn" type="button" onclick="openGroupSheet(\'g' + idx + '\')">Pilih Menu</button>';
            } else if (isHabis) {
                html += '      <button class="rekomen-btn" disabled>Habis</button>';
            } else if (Number(item.punya_opsi || 0) === 1) {
                html += '      <button class="rekomen-btn" type="button" onclick="openOptionSheet(\'' + item.id_produk + '\')">Pilih Varian</button>';
            } else {
                html += '      <a href="' + addUrl + '" class="rekomen-btn rekomen-btn-success" data-add-id="' + item.id_produk + '" onclick="showAddToast(\'' + item.nama.replace(/'/g, "\\'") + '\')">+ Tambah</a>';
            }
            html += '    </div>';
            html += '  </div>';
            html += '</div>';
        });

        loading.style.display = 'none';
        grid.innerHTML = html;
        grid.style.display = (window.innerWidth <= 520) ? 'flex' : 'grid';

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
                if (json && json.status === 'success') {
                    renderRekomendasi(json.data);
                } else {
                    var loading = document.getElementById('rekomendasiLoading');
                    if (loading) {
                        loading.innerHTML = '<p style="color:var(--taupe);font-size:var(--fs-sm); text-align:center;">Rekomendasi tidak tersedia saat ini.</p>';
                    }
                }
            })
            .catch(function () {
                var loading = document.getElementById('rekomendasiLoading');
                if (loading) {
                    loading.innerHTML = '<p style="color:var(--taupe);font-size:var(--fs-sm); text-align:center;">Gagal memuat rekomendasi.</p>';
                }
            });
    }

    window.renderRekomendasi = renderRekomendasi;
    window.loadRekomendasi = loadRekomendasi;

    function initRekomendasiWidget() {
        startLiveClock();
        loadRekomendasi();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initRekomendasiWidget);
    } else {
        initRekomendasiWidget();
    }

    setInterval(loadRekomendasi, 5 * 60 * 1000);
})();

// ── Category Filter ──
var activeMenuCategory = 'all';
var activeDrinkType = 'all';

function filterCategory(kat, btn) {
    document.querySelectorAll('#categoryChips .chip').forEach(function(c) { c.classList.remove('active'); });
    btn.classList.add('active');
    activeMenuCategory = kat;
    activeDrinkType = 'all';

    var subcategories = document.getElementById('drinkSubcategoryChips');
    var isDrinkCategory = kat === 'panas' || kat === 'dingin';
    subcategories.style.display = isDrinkCategory ? 'flex' : 'none';
    if (isDrinkCategory) {
        subcategories.querySelectorAll('.chip').forEach(function(chip, index) {
            chip.classList.toggle('active', index === 0);
        });
    }

    applyMenuFilters();
    if (isDrinkCategory) {
        var suhu = kat === 'panas' ? 'panas' : 'es';
        document.querySelectorAll('.product-card[data-suhu-minuman="panas,dingin"]').forEach(function(card) {
            setCatalogSuhu(card, suhu);
        });
    }
}

function filterDrinkType(type, btn) {
    document.querySelectorAll('#drinkSubcategoryChips .chip').forEach(function(chip) { chip.classList.remove('active'); });
    btn.classList.add('active');
    activeDrinkType = type;
    applyMenuFilters();
}

function applyMenuFilters() {
    var query = document.getElementById('searchMenu').value.toLowerCase();
    var isDrinkCategory = activeMenuCategory === 'panas' || activeMenuCategory === 'dingin';

    document.querySelectorAll('.kategori-section').forEach(function(section) {
        var visibleCount = 0;
        section.querySelectorAll('.product-card').forEach(function(card) {
            var drinkType = card.dataset.jenisMinuman || '';
            var temperatures = (card.dataset.suhuMinuman || '').split(',');
            var matchesCategory = activeMenuCategory === 'all' || (isDrinkCategory
                ? Boolean(drinkType) && temperatures.indexOf(activeMenuCategory) !== -1
                : section.dataset.kategori === activeMenuCategory);
            var matchesType = activeDrinkType === 'all' || drinkType === activeDrinkType;
            var matchesQuery = (card.dataset.nama || '').includes(query);
            var visible = matchesCategory && matchesType && matchesQuery;
            card.style.display = visible ? '' : 'none';
            if (visible) visibleCount++;
        });

        section.style.display = visibleCount ? '' : 'none';
        var title = section.querySelector('.kategori-title');
        if (title) {
            title.textContent = isDrinkCategory && section.dataset.jenisMinuman
                ? (activeMenuCategory === 'panas' ? 'Minuman Panas' : 'Minuman Dingin') + ' · ' + (section.dataset.jenisMinuman === 'kopi' ? 'Kopi' : 'Non Kopi')
                : title.dataset.judulAsli;
        }
    });
}

// ── Search Filter ──
function filterMenu() {
    applyMenuFilters();
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

function setCatalogSuhu(card, suhu) {
    var wrap = card.querySelector('.suhu-toggle');
    if (!wrap) return;
    var buttons = wrap.querySelectorAll('button');
    buttons.forEach(function(button, index) {
        button.classList.toggle('active', index === (suhu === 'panas' ? 0 : 1));
    });
    var link = card.querySelector('[data-add-id]');
    if (link) link.href = link.href.split('?')[0] + '?suhu=' + suhu;
    var priceEl = card.querySelector('.card-price');
    if (priceEl) {
        var basePrice = Number(priceEl.dataset.price || 0);
        var es = Number(priceEl.dataset.es || 0);
        priceEl.textContent = 'Rp ' + (basePrice + (suhu === 'es' ? es : 0)).toLocaleString('id-ID');
    }
}

function openGroupSheet(key) {
    var data = window.rekomendasiGroups && window.rekomendasiGroups[key];
    if (!data) return;
    document.getElementById('groupSheetTitle').textContent = data.nama_kelompok || 'Pilih Menu';
    var body = document.getElementById('groupSheetBody');
    var html = '';
    var anggota = data.anggota || [];
    var subkategoriAktif = '';
    anggota.forEach(function(item) {
        if (item.subkategori && item.subkategori !== subkategoriAktif) {
            subkategoriAktif = item.subkategori;
            html += '<h4 style="margin:16px 0 4px;color:var(--espresso);">' + escapeMenuHtml(subkategoriAktif) + '</h4>';
        }
        window.variantProductData[item.id_produk] = item;
        var suhu = data.suhu_default || item.suhu_default || '';
        var addUrl = '<?= base_url() ?>cart/add/' + item.id_produk + '/<?= esc($id_meja) ?>' + (suhu ? '?suhu=' + suhu : '');
        html += '<div class="sheet-row">';
        html += '<img src="' + escapeMenuHtml(item.gambar || '<?= base_url('assets/no-image.svg') ?>') + '" onerror="this.src=&quot;<?= base_url('assets/no-image.svg') ?>&quot;">';
        html += '<div><strong>' + escapeMenuHtml(item.nama) + '</strong><div style="font-size:12px;color:var(--taupe);">' + escapeMenuHtml(item.kategori) + ' - ' + window.formatRupiah(Number(item.harga || 0)) + '</div>';
        if (item.deskripsi) html += '<div style="font-size:12px;color:var(--taupe);margin-top:4px;">' + escapeMenuHtml(item.deskripsi) + '</div>';
        if (Number(item.varian_suhu || 0) === 1) html += renderSuhuToggle(item.id_produk, suhu || 'panas', item.tambahan_harga_es || 0, 'sheet');
        html += '</div>';
        if (item.stok <= 0) {
            html += '<button class="btn btn-sm" disabled>Habis</button>';
        } else if (Number(item.punya_opsi || 0) === 1) {
            html += '<button class="btn btn-sm" type="button" onclick="openOptionSheet(\'' + item.id_produk + '\')">Pilih Varian</button>';
        } else {
            html += '<a class="btn btn-success btn-sm" data-add-id="' + item.id_produk + '" href="' + addUrl + '" onclick="showAddToast(' + escapeMenuHtml(JSON.stringify(String(item.nama))) + ')">+ Tambah</a>';
        }
        html += '</div>';
    });
    body.innerHTML = html;
    document.getElementById('groupSheet').classList.add('show');
}

function openOptionSheet(productId) {
    var product = window.variantProductData && window.variantProductData[productId];
    if (!product || !Array.isArray(product.options) || product.options.length === 0) {
        return;
    }

    var title = document.getElementById('groupSheetTitle');
    var body = document.getElementById('groupSheetBody');
    var optionLabel = getOptionLabel(product);
    title.textContent = optionLabel;

    var selectedOption = null;
    var options = product.options.filter(function(option) {
        return Number(option.aktif === undefined ? 1 : option.aktif) === 1;
    });
    var html = '<p style="margin:4px 0 12px;color:var(--taupe);">' + product.nama + ' — ' + (product.suhu_tetap === 'dingin' ? 'Es' : 'Panas') + '</p>';
    options.forEach(function(option) {
        html += '<button type="button" class="option-choice" data-option-id="' + option.id_opsi + '">' +
            '<span><strong>' + escapeMenuHtml(option.nama_opsi) + '</strong></span>' +
            '<span>' + (Number(option.tambahan_harga || 0) > 0 ? '+ ' + window.formatRupiah(Number(option.tambahan_harga)) : '') + '</span>' +
            '</button>';
    });
    html += '<label style="display:block;margin-top:16px;font-weight:600;">Jumlah ' +
        '<input id="variantQty" type="number" min="1" max="' + Math.max(1, Number(product.stok || 1)) + '" value="1" style="width:80px;margin-left:8px;padding:6px;border:1px solid var(--sand);border-radius:8px;"></label>';
    html += '<button type="button" id="addVariantButton" class="btn btn-block" disabled style="margin-top:14px;opacity:.55;">' + optionLabel + ' terlebih dahulu</button>';
    body.innerHTML = html;

    body.querySelectorAll('.option-choice').forEach(function(button) {
        button.addEventListener('click', function() {
            body.querySelectorAll('.option-choice').forEach(function(choice) {
                choice.classList.remove('selected');
            });
            button.classList.add('selected');
            selectedOption = button.dataset.optionId;
            var submit = document.getElementById('addVariantButton');
            submit.disabled = false;
            submit.style.opacity = '1';
            submit.textContent = '+ Tambah ' + product.nama;
        });
    });

    document.getElementById('addVariantButton').addEventListener('click', function() {
        if (!selectedOption) return;
        var quantity = Math.max(1, Number(document.getElementById('variantQty').value || 1));
        quantity = Math.min(quantity, Number(product.stok || 1), 50);
        var url = '<?= base_url() ?>cart/add/' + encodeURIComponent(productId) + '/<?= esc($id_meja) ?>?opsi=' +
            encodeURIComponent(selectedOption) + '&qty=' + quantity;
        window.location.href = url;
    });

    document.getElementById('groupSheet').classList.add('show');
}

function getOptionLabel(product) {
    if (['Makanan Berat', 'Cemilan'].indexOf(product.kategori) !== -1) {
        return 'Pilih varian';
    }
    return product.label_opsi || 'Pilih varian';
}

function escapeMenuHtml(value) {
    return String(value == null ? '' : value).replace(/[&<>"']/g, function(character) {
        return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[character];
    });
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
