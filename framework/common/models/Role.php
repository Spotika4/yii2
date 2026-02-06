<?php

namespace common\models;


class Role extends \common\models\base\ActiveRecord {


	public $parent_name;


	public static function tableName(){
		return '{{%auth_item}}';
	}

	public static function primaryKey(){
		return ['name'];
	}

	public function extraFields(){
		return ['childs', 'parent'];
	}

	public function scenarios(){
		return \yii\helpers\ArrayHelper::merge(parent::scenarios(), [
			self::SCENARIO_CREATE => ['name', 'description', 'parent_name'],
			self::SCENARIO_UPDATE => ['description', 'parent_name']
		]);
	}

	public function behaviors(){
		return [
			[
				'class' => \yii\behaviors\TimestampBehavior::class,
				'attributes' => [
					self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
					self::EVENT_BEFORE_UPDATE => ['updated_at'],
				],
			],
		];
	}

	public function rules(){
		return [
			[['name', 'description'], 'required'],
			[['name', 'description'], 'string'],

			['name', 'unique', 'targetClass' => 'common\models\Role', 'targetAttribute' => 'name', 'on' => [self::SCENARIO_CREATE]],

			['parent_name', 'safe'],
			['parent_name', 'required', 'on' => self::SCENARIO_CREATE],
			['parent_name', 'exist', 'targetClass' => 'common\models\Role', 'targetAttribute' => 'name', 'message' => \Yii::t('app', 'auth_item_name_not_found'), 'except' => self::SCENARIO_DEFAULT],
		];
	}

	public function attributeLabels(){
		return [
			'name' => \Yii::t('app', 'auth_item_name'),
			'description' => \Yii::t('app', 'auth_item_description')
		];
	}

	public function beforeSave($insert){
		$this->setAttribute('type', 1);
		return parent::beforeSave($insert);
	}

	public function afterSave($insert, $changedAttributes){
		parent::afterSave($insert, $changedAttributes);
		if($insert == true){
			\Yii::$app->db->createCommand()->insert('{{%auth_item_child}}', ['parent' => $this->parent_name, 'child' => $this->getAttribute('name')])->execute();
		}else if(!empty($this->parent_name)){
			\Yii::$app->db->createCommand()->update('{{%auth_item_child}}', ['parent' => $this->parent_name], ['child' => $this->getAttribute('name')])->execute();
		}
	}

	public function getChilds(){
		return $this->hasMany(Role::class, ['name' => 'child'])
			->viaTable('{{%auth_item_child}}', ['parent' => 'name'])->where(['type' => 1]);
	}

	public function getParent(){
		return $this->hasOne(Role::class, ['name' => 'parent'])
			->viaTable('{{%auth_item_child}}', ['child' => 'name'])->where(['type' => 1]);
	}

	public static function find(){
		return new \common\models\role\Query(get_called_class());
	}
}
