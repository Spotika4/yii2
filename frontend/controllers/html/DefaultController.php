<?php

namespace frontend\controllers\html;


class DefaultController extends \frontend\models\base\HtmlController {


	public $layout = 'clear';


	public function actionIndex(){
		$this->layout = 'main';
		return $this->render('index');
	}
}
