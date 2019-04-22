<?php

use yii\db\Migration;

/**
 * Class m190422_034326_adv_image
 */
class m190422_034326_adv_image extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('cnt_history', 'image', $this->string('500'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('cnt_history', 'image');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190422_034326_adv_image cannot be reverted.\n";

        return false;
    }
    */
}
