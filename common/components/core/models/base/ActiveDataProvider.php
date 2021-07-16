<?php

namespace common\components\core\models\base;


class ActiveDataProvider extends \yii\data\ActiveDataProvider {


	protected function prepareTotalCount(){
		if (!$this->query instanceof \yii\db\QueryInterface) {
			throw new \yii\base\InvalidConfigException('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
		}
		$query = clone $this->query;
		return (int) $query->limit(-1)->offset(-1)->orderBy([])->count('*', $this->db);
	}
}