<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_data`.
 */
class m170115_090238_create_user_data_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%user_data}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(32)->notNull(),
            'surname' => $this->string(64),
            'mobile' => $this->string(14),
            'address' => $this->string(),
            'user_id' => $this->integer(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk-user_data-user_id',
            'user_data',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-user_data-user_id', 'user_data');

        $this->dropTable('{{%user_data}}');
    }
}
