<?php

class MusicRegistry {

	protected $instructions = [];
	public $last_played = null;
	protected $registry = [];
	public $finished = false;

	public function __construct($instructions) {
		$this->instructions = $instructions;
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
					$last_played = $this->rcv($parts[1]);
					$this->instructions['at']++;

					if ($last_played !== false) {
						break 2; // Exit loop
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

	public function snd($register) {
		$this->last_played = $this->getRegister($register);
	}

	public function rcv($register) {
		if ($this->getRegister($register) != 0) {
			return $this->last_played;
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