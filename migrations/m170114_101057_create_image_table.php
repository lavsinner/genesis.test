<?php

use yii\db\Migration;

/**
 * Handles the creation of table `image`.
 */
class m170114_101057_create_image_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%image}}', [
            'id' => $this->primaryKey(),
            'path' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'type' => $this->integer()->notNull(),

            'created_at' => $this->integer()->notNull(),
            'uploaded_by' => $this->integer()->notNull()
        ], $tableOptions);

        $this->addForeignKey(
            'fk-image-uploaded_by',
            'image',
            'uploaded_by',
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
        $this->dropForeignKey(
            'fk-image-uploaded_by',
            'image'
        );

        $this->dropTable('{{%image}}');
    }
}
