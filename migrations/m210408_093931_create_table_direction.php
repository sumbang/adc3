<?php

use yii\db\Migration;

/**
 * Class m210408_093931_create_table_direction
 */
class m210408_093931_create_table_direction extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('DIRECTION', [
            'ID' => $this->primaryKey(),
            'LIBELLE' => $this->string(200)->notNull(),
        ]);

        $this->alterColumn('DIRECTION', 'ID', $this->integer(10).' NOT NULL AUTO_INCREMENT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('DIRECTION');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210408_093931_create_table_direction cannot be reverted.\n";

        return false;
    }
    */
}
