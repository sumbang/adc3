<?php

use yii\db\Migration;

/**
 * Class m210415_060551_update_decision_suspension
 */
class m210415_060551_update_decision_suspension extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('SUSPENSION', 'DEJA', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('SUSPENSION', 'DEJA');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210415_060551_update_decision_suspension cannot be reverted.\n";

        return false;
    }
    */
}
