<?php

class Registry
{
	protected $registry = [];
	protected $max_value = 0;

	public function checkCondition($condition) {

		$parts = explode(" ", $condition);

		$register = $parts[0];
		$operator = $parts[1];
		$value = (int) $parts[2];

		switch ($operator) { // Thanks PHP.....
			case '==';
				$evaluation = ($this->getRegisterValue($register) == $value);
				break;
			case '!=':
				$evaluation = ($this->getRegisterValue($register) != $value);
				break;
			case '<':
				$evaluation = ($this->getRegisterValue($register) < $value);
				break;
			case '<=';
				$evaluation = ($this->getRegisterValue($register) <= $value);
				break;
			case '>':
				$evaluation = ($this->getRegisterValue($register) > $value);
				break;
			case '>=';
				$evaluation = ($this->getRegisterValue($register) >= $value);
				break;
		}
		
		return $evaluation;
	}

	public function updateRegistry($action) {
		$parts = explode(" ", $action);

		$register = $parts[0];
		$operator = $parts[1];
		$value = (int) $parts[2];

		$register_value = $this->getRegisterValue($register);
		switch ($operator) {
			case 'inc':
				$register_value += ($value);
				break;
			case 'dec':
				$register_value -= ($value);
				break;
		}

		$this->setRegisterValue($register, $register_value);
	}

	public function setRegisterValue($index, $value) {

		if ($value > $this->max_value) {
			$this->max_value = $value;
		}

		$this->registry[$index] = $value;
	}

	public function getRegisterValue($index) {

		if (!isset($this->registry[$index])) {
			$this->registry[$index] = 0;
		}

		return $this->registry[$index];
	}

	public function getMaxValueEver() {
		return $this->max_value;
	}

	public function getMaxValue() {
		return max($this->registry);
	}

	public function getRegistry() {
		return $this->registry;
	}

}