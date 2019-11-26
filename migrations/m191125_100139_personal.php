<?php

use yii\db\Migration;

/**
 * Class m191125_100139_personal
 */
class m191125_100139_personal extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%personal}}', [
            'id' => $this->primaryKey(),
            'ACTIVE' => $this->string(1),
            'NAME' => $this->string(),
            'LAST_NAME' => $this->string(),
            'EMAIL' => $this->string(),
            'XML_ID' => $this->string()->unique(),
            'PERSONAL_GENDER' => $this->string(1),
            'PERSONAL_BIRTHDAY' => $this->date(),
            'WORK_POSITION' => $this->string(),
            'Region' => $this->string(),
            'City' => $this->string(),
        ]);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%personal}}');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191125_100139_personal cannot be reverted.\n";

        return false;
    }
    */
}
