<?php

namespace App\Controllers;

class Setup extends BaseController
{
    public function migrate()
    {
        $migrate = \Config\Services::migrations();
        
        try {
            $migrate->latest();
            return 'Migrations berhasil dijalankan!';
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function createNotificationsTable()
    {
        $db = \Config\Database::connect();

        $query = "CREATE TABLE IF NOT EXISTS notifications (
          id_notif INT AUTO_INCREMENT PRIMARY KEY,
          id_order VARCHAR(11) NOT NULL,
          id_meja VARCHAR(11) NOT NULL,
          nama_pelanggan VARCHAR(100) NOT NULL,
          total DECIMAL(12,2) DEFAULT 0,
          status ENUM('unread', 'read') DEFAULT 'unread',
          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
          
          CONSTRAINT fk_notif_order
            FOREIGN KEY (id_order)
            REFERENCES orders(id_order)
            ON UPDATE CASCADE
            ON DELETE CASCADE,
            
          CONSTRAINT fk_notif_meja
            FOREIGN KEY (id_meja)
            REFERENCES tables_meja(id_meja)
            ON UPDATE CASCADE
            ON DELETE CASCADE
        ) ENGINE=InnoDB";

        try {
            $db->query($query);
            return '✓ Tabel notifications berhasil dibuat!';
        } catch (\Exception $e) {
            return '✗ Error: ' . $e->getMessage();
        }
    }
}
