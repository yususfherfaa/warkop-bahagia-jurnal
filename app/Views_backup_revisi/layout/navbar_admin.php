<nav style="
    background:linear-gradient(90deg,#007bff,#0056d2);
    padding:15px 25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 2px 8px rgba(0,0,0,0.1);
">

    <div style="
        color:white;
        font-size:22px;
    ">
        Admin Warkop
    </div>

    <div style="
        display:flex;
        gap:15px;
        align-items:center;
    ">

        <span style="
            color:white;
        ">
            👑 Administrator
        </span>

        <a href="<?= base_url('admin/dashboard') ?>"
           style="
                color:white;
                text-decoration:none;
                transition:0.3s;
           "
           onmouseover="this.style.opacity='0.7'"
           onmouseout="this.style.opacity='1'">
            Dashboard
        </a>

        <a href="<?= base_url('admin/kasir') ?>"
           style="
                color:white;
                text-decoration:none;
                transition:0.3s;
           "
           onmouseover="this.style.opacity='0.7'"
           onmouseout="this.style.opacity='1'">
            Kelola Kasir
        </a>

        <a href="<?= base_url('laporan') ?>"
           style="
                color:white;
                text-decoration:none;
                transition:0.3s;
           "
           onmouseover="this.style.opacity='0.7'"
           onmouseout="this.style.opacity='1'">
            Laporan Penjualan
        </a>

        <a href="<?= base_url('laporan-stok') ?>"
            style="
                color:white;
                text-decoration:none;
                transition:0.3s;
            "
            onmouseover="this.style.opacity='0.7'"
            onmouseout="this.style.opacity='1'">
            Laporan Stok
        </a>

        <a href="<?= base_url('admin/settings') ?>"
           style="
                color:white;
                text-decoration:none;
                transition:0.3s;
           "
           onmouseover="this.style.opacity='0.7'"
           onmouseout="this.style.opacity='1'">
            Pengaturan
        </a>

        <a href="<?= base_url('logout') ?>"
           style="
                background:#dc3545;
                color:white;
                padding:10px 16px;
                border-radius:8px;
                text-decoration:none;
                transition:0.3s;
                box-shadow:0 2px 8px rgba(220,53,69,0.3);
           "
           onmouseover="
                this.style.boxShadow='0 0 15px rgba(255,0,0,0.8)';
                this.style.transform='translateY(-2px)';
                this.style.background='#ff1f1f';
           "
           onmouseout="
                this.style.boxShadow='0 2px 8px rgba(220,53,69,0.3)';
                this.style.transform='translateY(0)';
                this.style.background='#dc3545';
           ">
            Logout
        </a>

    </div>

</nav>

<script>
let idleTime = 0;

// reset timer jika ada aktivitas
function resetIdle() {
    idleTime = 0;
}

document.addEventListener('mousemove', resetIdle);
document.addEventListener('keypress', resetIdle);
document.addEventListener('click', resetIdle);
document.addEventListener('scroll', resetIdle);
document.addEventListener('touchstart', resetIdle);

// cek tiap 1 menit
setInterval(function(){

    idleTime++;

    // 1 menit tidak ada aktivitas
    if(idleTime >= 1){

        window.location.href =
        "<?= base_url('admin/dashboard') ?>";

    }

}, 60000);
</script>