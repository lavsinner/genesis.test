<?php

use yii\db\Migration;

class m170115_062448_add_login_token_to_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'login_token', $this->string()->unique());
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'login_token');
    }
}
