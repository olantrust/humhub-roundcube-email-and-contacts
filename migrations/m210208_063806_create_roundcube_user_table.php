<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%roundcube_user}}`.
 */
class m210208_063806_create_roundcube_user_table extends Migration
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

        $this->createTable('{{%roundcube_user}}', [
            'id'           => $this->primaryKey(),
            'user_id'      => $this->integer()->notNull()->comment('HH User ID, Foreign key references user.id'),
            'email'        => $this->string()->notNull()->comment('Email to login to Akaunting'),
            'enc_password' => $this->string()->notNull()->comment('Encrypted Password to login to Akaunting'),
            'created_at'   => $this->integer(),
            'updated_at'   => $this->integer(),
        ], $tableOptions);

        $this->createIndex('roundcube_user_user_id_idx', '{{%roundcube_user}}', 'user_id');
        $this->addForeignKey('roundcube_user_user_id_fk', '{{%roundcube_user}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // $this->dropTable('{{%roundcube_user}}');

        echo "m210208_063806_create_roundcube_user_table cannot be reverted.\n";

        return false;
    }
}
