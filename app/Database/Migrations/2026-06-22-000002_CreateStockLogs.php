<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStockLogs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_log' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'id_produk' => [
                'type' => 'VARCHAR',
                'constraint' => '11',
                'null' => false,
            ],
            'change_qty' => [
                'type' => 'INT',
                'null' => false,
            ],
            'id_order' => [
                'type' => 'VARCHAR',
                'constraint' => '11',
                'null' => true,
            ],
            'keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('id_log', true);
        $this->forge->addForeignKey('id_produk', 'products', 'id_produk', '', 'CASCADE');
        $this->forge->createTable('stock_logs');
    }

    public function down()
    {
        $this->forge->dropTable('stock_logs', true);
    }
}
