<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

$routes->get('/', 'Auth::index');
$routes->post('/login/process', 'Auth::processLogin');
$routes->get('/logout', 'Auth::logout');


/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

$routes->get('/admin/dashboard', 'Admin\Dashboard::index', ['filter' => 'auth']);
$routes->get('/kasir/dashboard', 'Kasir\Dashboard::index', ['filter' => 'auth']);


/*
|--------------------------------------------------------------------------
| MENU KASIR
|--------------------------------------------------------------------------
*/

$routes->get('/kasir/menu', 'Kasir\Menu::index', ['filter' => 'auth']);

$routes->post('/kasir/menu/add', 'Kasir\Menu::add', ['filter' => 'auth']);

$routes->get('/kasir/menu/edit/(:segment)', 'Kasir\Menu::edit/$1', ['filter' => 'auth']);

$routes->post('/kasir/menu/update/(:segment)', 'Kasir\Menu::update/$1', ['filter' => 'auth']);

$routes->get('/kasir/menu/delete/(:segment)', 'Kasir\Menu::delete/$1', ['filter' => 'auth']);

$routes->post('/kasir/menu/options/add/(:segment)', 'Kasir\ProductOption::add/$1', ['filter' => 'auth']);
$routes->post('/kasir/menu/options/update/(:segment)', 'Kasir\ProductOption::update/$1', ['filter' => 'auth']);
$routes->post('/kasir/menu/options/delete/(:segment)', 'Kasir\ProductOption::delete/$1', ['filter' => 'auth']);


/*
|--------------------------------------------------------------------------
| ORDER CUSTOMER
|--------------------------------------------------------------------------
*/

$routes->get('/order/(:any)', 'Order::index/$1');

$routes->get('/cart/add/(:any)/(:any)', 'Cart::add/$1/$2');

$routes->post('/cart/note/(:any)/(:any)', 'Cart::note/$1/$2');

$routes->get('/cart/qty/(:any)/(:any)/(:any)', 'Cart::qty/$1/$2/$3');

$routes->get('/cart/remove/(:any)/(:any)', 'Cart::remove/$1/$2');

$routes->get('cart/reset/(:segment)', 'Cart::reset/$1');

$routes->get('/cart/(:any)', 'Cart::index/$1');

$routes->post('/checkout/(:any)', 'Checkout::index/$1');

$routes->get('/payment-qris/(:segment)/(:segment)','PaymentQris::index/$1/$2');

$routes->get('/order-success/(:any)/(:any)', 'OrderSuccess::index/$1/$2');

$routes->get('/cek-status/(:segment)', 'OrderStatus::cek/$1');

$routes->get('/reset-cart', function () {

    session()->destroy();

    return 'Session cart berhasil direset';
});


/*
|--------------------------------------------------------------------------
| PESANAN KASIR
|--------------------------------------------------------------------------
*/

$routes->get('/kasir/pesanan', 'Kasir\Pesanan::index', ['filter' => 'auth']);

$routes->get('/kasir/detail-pesanan/(:segment)', 'Kasir\DetailPesanan::index/$1', ['filter' => 'auth']);

$routes->get('/kasir/bayar/(:segment)', 'Kasir\Bayar::index/$1', ['filter' => 'auth']);

$routes->post('/kasir/bayar/process/(:segment)', 'Kasir\Bayar::process/$1', ['filter' => 'auth']);

$routes->get('/kasir/struk/(:segment)', 'Kasir\Struk::index/$1', ['filter' => 'auth']);


/*
|--------------------------------------------------------------------------
| LAPORAN
|--------------------------------------------------------------------------
*/

$routes->get('/laporan', 'Kasir\Laporan::index', ['filter' => 'auth']);

$routes->get('/laporan/pdf', 'Kasir\Laporan::pdf', ['filter' => 'auth']);

/*
|--------------------------------------------------------------------------
| LAPORAN STOK & AKTIVITAS PRODUK
|--------------------------------------------------------------------------
*/

$routes->get('/laporan-stok', 'Admin\LaporanStok::index', ['filter' => 'auth']);

$routes->get('/laporan-stok/pdf', 'Admin\LaporanStok::pdf', ['filter' => 'auth']);

/*
|--------------------------------------------------------------------------
| ADMIN KASIR MANAGEMENT
|--------------------------------------------------------------------------
*/

$routes->get('/admin/kasir', 'Admin\Kasir::index', ['filter' => 'auth']);

$routes->get('/admin/kasir/list', 'Admin\Kasir::index', ['filter' => 'auth']);

$routes->get('/admin/kasir/add', 'Admin\Kasir::add', ['filter' => 'auth']);

$routes->post('/admin/kasir/save', 'Admin\Kasir::save', ['filter' => 'auth']);

$routes->get('admin/kasir/edit/(:segment)', 'Admin\Kasir::edit/$1', ['filter' => 'auth']);

$routes->post('admin/kasir/update/(:segment)', 'Admin\Kasir::update/$1', ['filter' => 'auth']);

$routes->get('admin/kasir/delete/(:segment)', 'Admin\Kasir::delete/$1', ['filter' => 'auth']);


/*
|--------------------------------------------------------------------------
| SETTINGS
|--------------------------------------------------------------------------
*/

$routes->get('admin/qr-meja','Admin\Setting::qrMeja');

$routes->group('admin', ['filter' => 'auth'], function($routes) {

    $routes->get('settings', 'Admin\Setting::index');

    $routes->post('settings/update', 'Admin\Setting::update');

});

/*
|--------------------------------------------------------------------------
| API NOTIFICATIONS
|--------------------------------------------------------------------------
*/

$routes->get('/api/notifications', 'NotificationAPI::getNotifications', ['filter' => 'auth']);

$routes->post('/api/notifications/mark-read', 'NotificationAPI::markAsRead', ['filter' => 'auth']);

$routes->post('/api/notifications/mark-all-read', 'NotificationAPI::markAllAsRead', ['filter' => 'auth']);

/*
|--------------------------------------------------------------------------
| SETUP (untuk init database)
|--------------------------------------------------------------------------
*/

$routes->get('/setup/create-notifications', 'Setup::createNotificationsTable');

// Rekomendasi berdasarkan jam real-time
$routes->get('/api/rekomendasi', 'RekomendasiAPI::index');

// Rekomendasi berdasarkan jam tertentu (untuk testing)
// Contoh: /api/rekomendasi/jam/8  → rekomendasi pagi
$routes->get('/api/rekomendasi/jam/(:num)', 'RekomendasiAPI::byJam/$1');