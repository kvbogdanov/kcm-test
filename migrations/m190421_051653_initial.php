<?php

use yii\db\Migration;

/**
 * Class m190421_051653_initial
 */
class m190421_051653_initial extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('cnt_links', [
            'id_link' => $this->primaryKey(),
            'creator_ip' => $this->integer()->unsigned(),
            'url' => $this->string(),
            'link' => $this->string(),
            'date_create' => $this->integer()->unsigned(),
            'date_delete' => $this->integer()->unsigned()
        ]);

        $this->createIndex('link_index', 'cnt_links', 'link');

        $this->createTable('cnt_history', [
            'id_history' => $this->primaryKey(),
            'id_link' => $this->integer()->unsigned(),
            'ip' => $this->integer()->unsigned(),
            'date' => $this->integer()->unsigned()
        ]);

        $this->createIndex('id_link_index', 'cnt_history', 'id_link');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('cnt_history');
        $this->dropTable('cnt_links');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190421_051653_initial cannot be reverted.\n";

        return false;
    }
    */
}
