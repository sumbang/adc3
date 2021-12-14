<?php

use yii\db\Migration;

/**
 * Class m210408_093937_create_table_service
 */
class m210408_093937_create_table_service extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('SERVICE', [
            'ID' => $this->primaryKey(),
            'LIBELLE' => $this->string(200)->notNull(),
        ]);

        $this->alterColumn('SERVICE', 'ID', $this->integer(10).' NOT NULL AUTO_INCREMENT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('SERVICE');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210408_093937_create_table_service cannot be reverted.\n";

        return false;
    }
    */
}
