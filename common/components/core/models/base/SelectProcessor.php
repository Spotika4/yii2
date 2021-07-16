<?php

namespace common\components\core\models\base;


class SelectProcessor extends \common\components\core\models\base\ObjectProcessor{


	public $lexicon;


	public function default(){
		$rows = [];
		$_rows = $this->query()->asArray()->all();
		foreach($_rows as $i => $row){
			$rows[$i] = $row;
			if(isset($row['title'])){
				$rows[$i]['display'] = \Yii::t($this->lexicon, $row['title']);
			}
		}
		return $rows;
	}
}