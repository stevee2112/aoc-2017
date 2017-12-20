<?php

class ProgramRegistry {

	public $queue = [];
	public $registry = [];
	protected $other_program = null;
	public $instructions = [];
	public $is_waiting = false;
	public $send_count = 0;
	public $finished = false;

	public function __construct($p_value, $instructions) {
		$this->set('p', $p_value);
		$this->instructions = $instructions;
	}

	public function setOtherProgram(ProgramRegistry $other_program) {
		$this->other_program = $other_program;
	}

	public function run() {
	
		$instruction_count = count($this->instructions['instructions']);

		while ($this->instructions['at'] < $instruction_count) {

			$instruction = $this->instructions['instructions'][$this->instructions['at']];

			$parts = explode(" ", $instruction);

			switch ($parts[0]) {
				case 'snd':
					$this->snd($parts[1]);
					$this->instructions['at']++;
					$this->send_count++;
					break;
				case 'set':
					$this->set($parts[1], $parts[2]);
					$this->instructions['at']++;
					break;
				case 'add':
					$this->add($parts[1], $parts[2]);
					$this->instructions['at']++;
					break;
				case 'mul':
					$this->mul($parts[1], $parts[2]);
					$this->instructions['at']++;
					break;
				case 'mod':
					$this->mod($parts[1], $parts[2]);
					$this->instructions['at']++;
					break;
				case 'rcv':

					$received = $this->rcv($parts[1]);

					if ($received === true) {
						$this->is_waiting = false;
						$this->instructions['at']++;
					} else {
						$this->is_waiting = true;
						return false; // Return to main to run other prog
					}

					break;
				case 'jgz':

					$jump = $this->jgz($parts[1], $parts[2]);

					if ($jump !== false) {
						$this->instructions['at'] += $jump;
					} else {
						$this->instructions['at']++;
					}

					break;
			}

		}

		$this->finished = true;
		return true;	
	}
	
	public function set($register, $value) {
		$this->registry[$register] = $this->getValue($value);
	}

	public function add($register, $value) {

		$this->registry[$register] = bcadd($this->getRegister($register),  $this->getValue($value));
	}

	public function mul($register, $value) {

		$this->registry[$register] = bcmul($this->getRegister($register), $this->getValue($value));
	}

	public function mod($register, $value) {

		$this->registry[$register] = bcmod($this->getRegister($register), $this->getValue($value));
	}

	public function snd($value) {
		$this->other_program->queue($this->getValue($value));
	}

	public function rcv($register) {
		$value = array_shift($this->queue);

		if (!is_null($value)) {
			$this->registry[$register] = $value;
			return true;
		} else {
			return false;
		}
	}

	public function jgz($register, $value) {
	
		if ($this->getValue($register) > 0) {
			return $this->getValue($value);
		} else {
			return false;
		}
	}

	public function queue($value) {
		$this->queue[] = $value;
	}
	
	private function getRegister($register) {

		if (!array_key_exists($register, $this->registry)) {
			$this->registry[$register] = 0;
		}

		return $this->registry[$register];
	
	}

	private function getValue($value) {

		if (is_numeric($value)) {
			return $value;
		} else {
			return $this->getRegister($value);
		}	
	}
	
}