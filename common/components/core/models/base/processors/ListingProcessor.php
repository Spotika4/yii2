<?php

namespace common\components\core\models\base\processors;


class ListingProcessor extends ObjectProcessor {


	public function default(){
		return $this->query()->asArray()->all();
	}
}