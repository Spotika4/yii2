<?php

use yii\db\Migration;
use spotika4\yiicore\models\ar\User;


class m200317_171356_user_init extends Migration{


	public $tableOptions = NULL;


    public function safeUp(){
	    $tableOptions = null;
	    if ($this->db->driverName === 'mysql') {
		    $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
	    }

	    // user
	    $this->createTable('{{%user}}', [
		    'id' => $this->primaryKey(),
		    'username' => $this->string()->notNull()->unique(),
		    'email' => $this->string()->notNull()->unique(),
		    'password_hash' => $this->string()->notNull(),
		    'auth_key' => $this->string(32)->notNull(),
		    'status' => $this->tinyInteger()->notNull()->defaultValue(User::STATUS_INACTIVE),
		    'created_at' => $this->integer()->notNull(),
		    'updated_at' => $this->integer()->notNull(),
	    ], $this->tableOptions);

	    // user_option
	    $this->createTable('{{%user_option}}', [
		    'user_id' => $this->integer()->notNull(),
		    'key' => $this->string()->notNull(),
		    'value' => $this->string()->notNull(),
	    ], $this->tableOptions);
	    $this->createIndex(
		    'user_id',
		    '{{%user_option}}',
		    'user_id'
	    );
	    $this->addPrimaryKey(
		    'user_id_key',
		    '{{%user_option}}',
		    ['user_id', 'key']
	    );

	    // addForeignKey user_option -> user
	    $this->addForeignKey(
		    'user_option_user',
		    '{{%user_option}}',
		    'user_id',
		    '{{%user}}',
		    'id',
		    'CASCADE'
	    );

	    // addForeignKey {{%auth_assignment}} -> user
	    $this->addForeignKey(
		    'auth_assignment_user',
		    Yii::$app->getAuthManager()->assignmentTable,
		    'user_id',
		    '{{%user}}',
		    'id',
		    'CASCADE'
	    );
    }

    public function safeDown(){
	    $this->dropForeignKey('auth_assignment_user', '{{%auth_assignment}}');
	    $this->dropForeignKey('user_option_user', '{{%user_option}}');
	    $this->dropTable('{{%user}}');
	    $this->dropTable('{{%user_option}}');
        return true;
    }
}
