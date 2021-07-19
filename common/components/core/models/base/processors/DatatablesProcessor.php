<?php

namespace common\components\core\models\base\processors;


class DatatablesProcessor extends \common\components\core\models\base\Processor {


	public $start;
	public $length;
	public $order;
	public $search;
	public $columns;

	private $allows;


	public function setAllows($fields){
		$this->allows = $fields;
	}

	public function getAllows(){
		return $this->allows;
	}

	public function isAllow($field){
		return in_array($field, $this->allows);
	}

	public function getTableName(){
		return false;
	}

	public function byDataProvider($query){
		$provider = new \common\components\core\models\base\ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'page' => ($this->start > $this->length || $this->start == $this->length) ? ($this->start / $this->length) : 0,
				'pageSize' => $this->length
			],
		]);
		return [
			'data' => $provider->getModels(),
			//'attributes' => $this->getAttributes(),
			'recordsTotal' => $provider->getTotalCount(),
			'recordsFiltered' => $provider->getTotalCount(),
		];
	}

	public function rules(){
		return [
			[['start', 'length', 'order', 'search', 'columns'], 'required'],
			[['start', 'length'], 'integer'],
			[['order', 'search', 'columns'], \common\components\core\models\validators\ArrayValidator::class],
		];
	}

	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => ['start', 'length', 'order', 'search', 'columns'],
		];
	}

	public function query(){
		return (new \yii\db\Query())->from($this->getTableName());
	}

	public function default(){
		$query = $this->query();
		$attributes = $this->getAttributes();
		$cols = $attributes['columns'];
		$order = $attributes['order'];
		$search = $attributes['search'];

		if(isset($order[0]['dir']) && isset($order[0]['column'])){
			$column = $cols[$order[0]['column']]['data'];
			$order = ($order[0]['dir'] == 'asc') ? SORT_ASC : SORT_DESC;
			if($this->isAllow($column)){
				$query->orderBy([$column => $order]);
			}
		}

		for($i = 0; $i < (count($cols) - 1); $i++){
			$col = $cols[$i];
			if(isset($col['data']) && !empty($col['data']) && $this->isAllow($col['data'])){
				if(!isset($query->select[$col['data']])){
					$query->addSelect($this->allows[$col['data']] . ' ' . $col['data']);
				}
				if(isset($col['searchable']) && $col['searchable'] !== 'false'){
					if(!empty($col['search']['value'])){
						$query->andWhere(['like', $this->allows[$col['data']], $col['search']['value']]);
					}else if(!empty($search['value'])){
						$query->andWhere(['like', $this->allows[$col['data']], $search['value']]);
					}
				}
			}
		}
		return $this->byDataProvider($query);
	}
}
