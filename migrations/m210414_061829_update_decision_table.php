<?php

use yii\db\Migration;

/**
 * Class m210414_061829_update_decision_table
 */
class m210414_061829_update_decision_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('DECISIONCONGES', 'TYPE_DEC', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('DECISIONCONGES', 'TYPE_DEC');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210414_061829_update_decision_table cannot be reverted.\n";

        return false;
    }
    */
}
