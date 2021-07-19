<?php

namespace common\components\core\models\base;


class Processor extends Model {


	const SCENARIO_DEFAULT = 'default';
	const EVENT_BEFORE_PROCESS = 'beforeProcess';
	const EVENT_AFTER_PROCESS = 'afterProcess';

	private $data;
	private $message;
	private $success = false;


	public function formName(){
		return '';
	}

	public function init(){
		if($this->getScenario() == mb_strtolower(Model::SCENARIO_DEFAULT)){
			$this->setScenario(Processor::SCENARIO_DEFAULT);
		}
	}

	public function scenarios(){
		return [
			self::SCENARIO_DEFAULT => []
		];
	}

	public function process(){
		if($this->validate()){
			$result = $this->runScenario();
			if(!is_bool($result)){
				$this->setData($result);
				$result = true;
			}
			$this->setSuccess($result);
		}else if(!$this->getSuccess() && !$this->hasMessage()){
			$this->addMessage(\Yii::t('core', 'processor_process_failed'));
		}
		return $this;
	}

	public function runScenario(){
		return $this->{$this->getScenario()}();
	}

	public function setSuccess(bool $success){
		$this->success = $success;
	}

	public function getSuccess(){
		return $this->success;
	}

	public function setMessage($message){
		$this->message = [$message];
	}

	public function addMessage($message){
		$this->message[] = $message;
	}

	public function getMessage(){
		return $this->message;
	}

	public function hasMessage(){
		return ($this->message);
	}

	public function setData($data){
		$this->data = $data;
	}

	public function getData(){
		return $this->data;
	}

	public function hasData(){
		return ($this->data);
	}

	public function response(){
		return [
			'data' => $this->getData(),
			'errors' => $this->getErrors(),
			'success' => $this->getSuccess(),
			'message' => $this->getMessage(),
			//'attributes' => $this->getAttributes(),
		];
	}
}
