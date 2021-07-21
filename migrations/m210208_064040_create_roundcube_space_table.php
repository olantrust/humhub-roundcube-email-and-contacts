<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%roundcube_space}}`.
 */
class m210208_064040_create_roundcube_space_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 ENGINE=InnoDB';
        }

        $this->createTable('{{%roundcube_space}}', [
            'id' => $this->primaryKey(),
            'space_id'     => $this->integer()->notNull()->comment('HH Space ID, Foreign Key reference space.id'),
            'email'        => $this->string()->notNull()->comment('Email to login to Akaunting'),
            'enc_password' => $this->string()->notNull()->comment('Encrypted Password to login to Akaunting'),
            'created_at'   => $this->integer(),
            'updated_at'   => $this->integer(),
        ], $tableOptions);

        $this->createIndex('roundcube_space_space_id_idx', '{{%roundcube_space}}', 'space_id');
        $this->addForeignKey('roundcube_space_space_id_fk', '{{%roundcube_space}}', 'space_id', '{{%space}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // $this->dropTable('{{%roundcube_space}}');

        echo "m210208_064040_create_roundcube_space_table cannot be reverted.\n";

        return false;
    }
}
