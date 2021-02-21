<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contact}}`.
 */
class m210221_111539_create_contact_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contact}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'country_code' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%contact}}');
    }
}
