<?php

use yii\db\Migration;
use common\components\core\models\ar\User;


class m100000_110100_core_init extends Migration{


	public $tableOptions = NULL;


    public function safeUp(){
	    $tableOptions = null;
	    if ($this->db->driverName === 'mysql') {
		    $this->tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
	    }

	    $this->execute(file_get_contents(__DIR__ . '/schema-mysql.sql'));
    }

    public function safeDown(){
	    /*$this->dropForeignKey('auth_assignment_user', '{{%auth_assignment}}');
	    $this->dropForeignKey('user_option_user', '{{%user_option}}');
	    $this->dropTable('{{%user}}');
	    $this->dropTable('{{%user_option}}');*/
        return true;
    }
}
