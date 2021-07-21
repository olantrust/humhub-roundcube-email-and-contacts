<?php

use yii\db\Migration;

class uninstall extends Migration
{

    public function up()
    {
        // TODO : Write the SQL here to drop tables.
        $this->dropTable('{{%roundcube_user}}');
        $this->dropTable('{{%roundcube_space}}');
    }

    public function down()
    {
        echo "uninstall does not support migration down.\n";
        return false;
    }
}
