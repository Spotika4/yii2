<?php

namespace common\components\core\models\base;


class ListingProcessor extends ObjectProcessor {


	public function default(){
		return $this->query()->asArray()->all();
	}
}