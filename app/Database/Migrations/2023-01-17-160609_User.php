<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * 紀念品使用者帳號資料表
 */
class User extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'u_id' => [
                'type' => 'BIGINT',
                'constraint' => 255,
                'unsigned' => true,
                'auto_increment' => true,
                'comment' => 'ID'
            ],
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => '80',
                'comment' => '使用者名'
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => '80',
                'comment' => '使用者姓'
            ],
            'email' => [
                'type' => 'VARCHAR',
                'unique' => true,
                'constraint' => '60',
                'comment' => '帳號'
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'comment' => '密碼'
            ],
            'cellphone_number' => [
                'type' => 'VARCHAR',
                'constraint' => '80',
                'comment' => '手機號碼'
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'comment' => '資料建立日期'
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'comment' => '資料更新日期'
            ],
            "deleted_at" => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'comment' => '資料刪除日期'
            ]
        ]);
        $this->forge->addPrimaryKey('u_id');
        $this->forge->createTable('User', true);
    }

    public function down()
    {
        $this->forge->dropTable('User');
    }
}
