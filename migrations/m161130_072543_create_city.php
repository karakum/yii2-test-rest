<?php

use yii\db\Migration;

class m161130_072543_create_city extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%city}}', [
            'id' => $this->primaryKey(),
            'country_id' => $this->integer()->notNull(),
            'region_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('fk-city-country_id-country-id', '{{%city}}', ['country_id'], '{{%country}}', ['id'], 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk-city-region_id-region-id', '{{%city}}', ['region_id'], '{{%region}}', ['id'], 'RESTRICT', 'RESTRICT');
        $this->createIndex('idx-city-region-name', '{{%city}}', ['region_id', 'name'], true);

    }

    public function down()
    {
        $this->dropTable('{{%city}}');
    }
}
