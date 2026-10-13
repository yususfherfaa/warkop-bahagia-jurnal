<!doctype html>
<html lang="id">

<head>

<meta charset="utf-8">

<title>
    Dashboard Kasir - <?= esc($nama_warkop) ?>
</title>

<link rel="stylesheet"
      href="<?= base_url('assets/style.css') ?>">

<style>

body{
    margin:0;
    font-family: Arial, sans-serif;
    background:#eef5ff;
}

/* NAVBAR */
nav{
    background: linear-gradient(90deg,#007bff,#0056d6);
    color:white;
    padding:18px 30px;
    text-align:left;
    box-shadow:0 2px 10px rgba(0,0,0,0.15);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

nav h1{
    margin:0;
    font-size:38px;
    font-weight:normal;
    flex: 1;
}

nav .right{
    display: flex;
    align-items: center;
    gap: 20px;
}

nav .right span{
    font-size:18px;
}

/* NOTIFICATION BELL */
.notification-bell {
    position: relative;
    cursor: pointer;
    font-size: 24px;
}

.notification-count {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #ff4d4d;
    color: white;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: bold;
}

nav .right a{
    background:#ff4d4d;
    color:white;
    padding:10px 18px;
    border-radius:8px;
    text-decoration:none;
    font-size:17px;
}

nav .right a:hover{
    background:#e60000;
}

/* NOTIFICATION PANEL */
.notification-panel {
    position: fixed;
    top: 80px;
    right: 20px;
    width: 400px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    display: none;
    z-index: 1000;
    max-height: 500px;
    overflow-y: auto;
}

.notification-panel.show {
    display: block;
}

.notification-header {
    padding: 15px;
    background: #007bff;
    color: white;
    border-radius: 12px 12px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.notification-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.notification-item {
    padding: 15px;
    border-bottom: 1px solid #eee;
    cursor: pointer;
    transition: 0.2s;
}

.notification-item:hover {
    background: #f5f5f5;
}

.notification-item.unread {
    background: #fffacd;
    font-weight: bold;
}

.notification-item-meja {
    color: #007bff;
    font-weight: bold;
    font-size: 14px;
}

.notification-item-nama {
    color: #333;
    font-size: 14px;
    margin-top: 5px;
}

.notification-item-total {
    color: #28a745;
    font-weight: bold;
    font-size: 14px;
    margin-top: 5px;
}

.notification-item-time {
    color: #999;
    font-size: 12px;
    margin-top: 5px;
}

.notification-empty {
    padding: 20px;
    text-align: center;
    color: #999;
}

/* CONTAINER */
.container{
    max-width:1200px;
    margin:40px auto;
    padding:20px;
}

.container h2{
    text-align:center;
    color:#007bff;
    margin-bottom:35px;
    font-size:45px;
    font-weight:normal;
}

/* CARD */
.card-container{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(350px,1fr));
    gap:30px;
}

.card{
    background:white;
    border-radius:20px;
    padding:60px 40px;
    text-align:center;
    box-shadow:0 4px 15px rgba(0,0,0,0.08);
    transition:0.3s;
    min-height:220px;
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.card:hover{
    transform:translateY(-5px);
}

.card h3{
    color:#007bff;
    font-size:28px;
    margin-bottom:30px;
    font-weight:normal;
}

.card p{
    font-size:58px;
    color:#111;
    margin:0;
    font-weight:bold;
}

/* MENU BUTTON */
.menu{
    margin-top:40px;
    text-align:center;
}

.menu a{
    display:inline-block;
    background:#007bff;
    color:white;
    text-decoration:none;
    padding:12px 25px;
    margin:8px;
    border-radius:10px;
    text-align:center;
    font-size:18px;
    transition:0.3s;
    min-width:220px;
}

.menu a:hover{
    background:#0056d6;
}

/* FOOTER */
footer{
    text-align:center;
    padding:25px;
    color:#555;
    font-size:20px;
}

</style>

</head>

<body>

<nav>

    <h1>
        <?= esc($nama_warkop) ?> - Kasir
    </h1>

    <div class="right">

        <span>
            👋 Halo, <?= esc($nama_kasir) ?>
        </span>

        <div class="notification-bell" onclick="toggleNotificationPanel()">
            🔔
            <div class="notification-count" id="notif-count" style="display: none;">0</div>
        </div>

        <a href="<?= base_url('/logout') ?>">
            Logout
        </a>

    </div>

</nav>

<!-- NOTIFICATION PANEL -->
<div class="notification-panel" id="notification-panel">
    <div class="notification-header">
        <span>Pesanan Baru</span>
        <button onclick="closeNotificationPanel()" style="background: none; border: none; color: white; font-size: 18px; cursor: pointer;">✕</button>
    </div>
    <ul class="notification-list" id="notification-list">
        <li class="notification-empty">Tidak ada pesanan baru</li>
    </ul>
</div>

<div class="container">

    <h2>Dashboard Kasir</h2>

    <div class="card-container">

        <div class="card">

            <h3>Total Pesanan Hari Ini</h3>

            <p><?= $total_pesanan ?></p>

        </div>


        <div class="card">

            <h3>Total Pendapatan Hari Ini</h3>

            <p>
                Rp
                <?= number_format(
                    $total_pendapatan,
                    0,
                    ',',
                    '.'
                ) ?>
            </p>

        </div>

        <div class="card">

            <h3>Total Menu</h3>

            <p><?= $jumlah_produk ?></p>

        </div>

    </div>

    <div class="menu">

        <a href="<?= base_url('/kasir/pesanan') ?>">
            Kelola Pesanan
        </a>

        <a href="<?= base_url('/laporan') ?>">
            Laporan Penjualan
        </a>

        <a href="<?= base_url('/kasir/menu') ?>">
            Manajemen Menu
        </a>

    </div>

</div>

<footer>

© <?= date('Y') ?>

<?= esc($nama_warkop) ?>

— Dashboard Kasir

</footer>

</body>
</html>

<script>
// Notification System
function toggleNotificationPanel() {
    const panel = document.getElementById('notification-panel');
    panel.classList.toggle('show');
}

function closeNotificationPanel() {
    const panel = document.getElementById('notification-panel');
    panel.classList.remove('show');
}

// Close panel when clicking outside
document.addEventListener('click', function(event) {
    const panel = document.getElementById('notification-panel');
    const bell = document.querySelector('.notification-bell');
    
    if (!panel.contains(event.target) && !bell.contains(event.target)) {
        panel.classList.remove('show');
    }
});

// Format time
function formatTime(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diff = Math.floor((now - date) / 1000);
    
    if (diff < 60) return 'Baru saja';
    if (diff < 3600) return Math.floor(diff / 60) + ' menit lalu';
    if (diff < 86400) return Math.floor(diff / 3600) + ' jam lalu';
    return Math.floor(diff / 86400) + ' hari lalu';
}

// Fetch notifications
function fetchNotifications() {
    fetch('<?= base_url('/api/notifications') ?>')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateNotificationUI(data.data);
            }
        })
        .catch(error => console.error('Error:', error));
}

// Update notification UI
function updateNotificationUI(notifications) {
    const list = document.getElementById('notification-list');
    const count = document.getElementById('notif-count');
    
    if (notifications.length === 0) {
        list.innerHTML = '<li class="notification-empty">Tidak ada pesanan baru</li>';
        count.style.display = 'none';
    } else {
        count.textContent = notifications.length;
        count.style.display = 'flex';
        
        list.innerHTML = notifications.map(notif => `
            <li class="notification-item unread" onclick="handleNotificationClick(${notif.id_notif})">
                <div class="notification-item-meja">📍 ${notif.id_meja}</div>
                <div class="notification-item-nama">👤 ${notif.nama_pelanggan}</div>
                <div class="notification-item-total">💰 Rp ${parseInt(notif.total).toLocaleString('id-ID')}</div>
                <div class="notification-item-time">⏱️ ${formatTime(notif.created_at)}</div>
            </li>
        `).join('');
    }
}

// Handle notification click
function handleNotificationClick(id_notif) {
    // Mark as read
    fetch('<?= base_url('/api/notifications/mark-read') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id_notif=' + id_notif
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            fetchNotifications();
            // Refresh pesanan page jika kasir membuka halaman pesanan
            if (document.location.pathname.includes('/kasir/pesanan')) {
                location.reload();
            }
        }
    });
    
    // Navigate to pesanan page
    window.location.href = '<?= base_url('/kasir/pesanan') ?>';
}

// Polling every 3 seconds
setInterval(fetchNotifications, 3000);

// Initial fetch
fetchNotifications();

// Play sound notification (optional)
function playNotificationSound() {
    const audio = new Audio('data:audio/wav;base64,UklGRiYAAABXQVZFZm10IBAAAAABAAEAQB8AAAB9AAACABAAZGF0YQIAAAAAAA==');
    audio.play().catch(e => {});
}
</script>