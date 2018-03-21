<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_logo`.
 */
class m180319_074308_create_goods_logo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('goods_logo', [
            'id' => $this->primaryKey(),
            'goods_id'=>$this->integer()->comment("商品id"),
            'logo_path'=>$this->integer()->comment("商品logo地址")

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('goods_logo');
    }
}
