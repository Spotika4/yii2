<?php

namespace common\models\role;


class Search extends \common\models\base\Model {


	public $name;
	public $parent;


	public function rules(){
		return [
			[['name', 'parent'], 'safe'],
		];
	}

	public function search(){
		$query = \common\models\Role::find()
			->leftJoin('{{%auth_item_child}}', 'name=auth_item_child.child');
		$dataProvider = new \yii\data\ActiveDataProvider([
			'query' => $query
		]);

		if (!$this->validate()) {
			return $dataProvider;
		}

		$query->andWhere(['type' => 1]);
		if(!empty($this->name)){
			$query->andFilterWhere(['like', 'name', $this->name]);
		}
		if(!empty($this->parent)){
			$query->andFilterWhere(['like', 'parent', $this->parent]);
		}

		return $dataProvider;
	}
}
