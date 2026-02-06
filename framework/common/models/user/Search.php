<?php

namespace common\models\user;


class Search extends \common\models\base\Model {


	const SCENARIO_DATATABLE = 'datatable';

	public $id;
	public $username;
	public $email;

	public $start;
	public $length;
	public $order;
	public $search;
	public $columns;


	public function scenarios(){
		return \yii\helpers\ArrayHelper::merge(parent::scenarios(), [
			self::SCENARIO_DATATABLE => ['start', 'length', 'order', 'search', 'columns']
		]);
	}

	public function rules(){
		return [
			[['id', 'username', 'email'], 'safe'],

			[['start', 'length', 'order', 'search', 'columns'], 'required'],
			[['start', 'length'], 'integer'],
			[['order', 'search', 'columns'], \common\models\validators\ArrayValidator::class],
		];
	}

	public function search(){
		$query = \common\models\User::find();
		$dataProvider = new \yii\data\ActiveDataProvider([
			'query' => $query
		]);

		if (!$this->validate()) {
			return $dataProvider;
		}

		if(!empty($this->id)){
			$query->andWhere(['id' => $this->id]);
		}
		if(!empty($this->username)){
			$query->andFilterWhere(['like', 'username', $this->username]);
		}
		if(!empty($this->email)){
			$query->andFilterWhere(['like', 'email', $this->email]);
		}

		if($this->getScenario() == self::SCENARIO_DATATABLE){

			if(isset($this->order[0]['dir']) && isset($this->order[0]['column'])){
				$column = $this->columns[$this->order[0]['column']]['data'];
				$order = ($this->order[0]['dir'] == 'asc') ? SORT_ASC : SORT_DESC;

				$query->orderBy([$column => $order]);
			}

			$allow = ['id' => 'id', 'username' => 'username', 'email' => 'email'];
			for($i = 0; $i < (count($this->columns) - 1); $i++){
				$col = $this->columns[$i];
				if(isset($col['data']) && !empty($col['data']) && in_array($col['data'], $allow)){
					if(!isset($query->select[$col['data']])){
						$query->addSelect($allow[$col['data']] . ' ' . $col['data']);
					}
					if(isset($col['searchable']) && $col['searchable'] !== 'false'){
						if(!empty($col['search']['value'])){
							$query->andWhere(['like', $allow[$col['data']], $col['search']['value']]);
						}else if(!empty($this->search['value'])){
							$query->andWhere(['like', $allow[$col['data']], $this->search['value']]);
						}
					}
				}
			}

			$dataProvider->setPagination([
				'page' => ($this->start > $this->length || $this->start == $this->length) ? ($this->start / $this->length) : 0,
				'pageSize' => $this->length
			]);

		}

		return $dataProvider;
	}
}
