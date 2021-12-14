<?php

use yii\db\Migration;

/**
 * Class m210414_132317_update_decision_abscense
 */
class m210414_132317_update_decision_abscense extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('ABSENCEPONCTUEL', 'DEJA', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('ABSENCEPONCTUEL', 'DEJA');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210414_132317_update_decision_abscense cannot be reverted.\n";

        return false;
    }
    */
}
