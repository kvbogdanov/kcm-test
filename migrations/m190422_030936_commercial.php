<?php

use yii\db\Migration;

/**
 * Class m190422_030936_commercial
 */
class m190422_030936_commercial extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('cnt_links', 'commercial', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('cnt_links', 'commercial');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190422_030936_commercial cannot be reverted.\n";

        return false;
    }
    */
}
