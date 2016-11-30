<?php

use yii\db\Migration;

class m161130_072537_create_region extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%region}}', [
            'id' => $this->primaryKey(),
            'country_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'code' => $this->string(50),
        ], $tableOptions);
        $this->addForeignKey('fk-region-country_id-country-id', '{{%region}}', ['country_id'], '{{%country}}', ['id'], 'RESTRICT', 'RESTRICT');
        $this->createIndex('idx-region-country-name', '{{%region}}', ['country_id', 'name'], true);

    }

    public function down()
    {
        $this->dropTable('{{%region}}');
    }
}
