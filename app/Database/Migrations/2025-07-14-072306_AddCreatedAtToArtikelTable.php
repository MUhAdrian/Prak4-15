<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCreatedAtToArtikelTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('artikel', [
                    'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
                ]);
    }

    public function down()
    {
        $this->forge->dropColumn('artikel', 'created_at');
    }
}
