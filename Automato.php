<?php

class Automato
{

	var $t = array();
	var $rules = array();
	var $generation = 0;
	var $width = 0;
	var $height = 0;

	public function __construct($width, $height)
	{
		$this->width = $width;
		$this->height = $height;
	}

	public function seed($passes){
		$newT = array();
		for ($x = 0; $x < $passes; $x++){
			$newT[rand(0, $this->width)][rand(0, $this->height)] = rand(0, 1);
		}
		$this->t = $newT;
		$this->generation = 1;
	}
	
	public function getValue($w, $h){
		return isset($this->t[$w][$h]) ? $this->t[$w][$h] : 0;
	}
	
	public function getNeighbours($w, $h){
		$found = 0;
		for ($x = ($w - 1); $x <= ($w + 1); $x++){
			for ($y = ($h - 1); $y <= ($h + 1); $y++){
				if ($y==$h && $x==$w) continue;
				$found += $this->getValue($x, $y);
			}
		}
		return $found;
	}
	
	public function evolve(){
		$newT = array();
		for ($x=0; $x<$this->width; $x++){
			for ($y=0; $y<$this->height; $y++){
				$newValue = $this->applyRule($this->getValue($x, $y), $this->getNeighbours($x, $y));
				if ($newValue) $newT[$x][$y] = 1;				
			}
		}
		$this->t = $newT;
		$this->generation++;
	}
	
	public function addRule($is, $neighbours, $turnTo = 1){
		$neighbours = explode(',', $neighbours);
		foreach ($neighbours as $neighbour){
			$this->rules[] = (object)array('is' => $is, 'neighbours' => $neighbour, 'turnTo' => $turnTo);
		}
	}
	
	public function applyRule($is, $neighbours){
		foreach ($this->rules as $rule){
			if ($rule->is == $is && $rule->neighbours == -1)
				return $rule->turnTo;
			
			if ($rule->is == $is && $rule->neighbours == $neighbours)
				return $rule->turnTo;
		}
		return $is;
	}
	
	public function render(){
		echo "Generation: {$this->generation}" . PHP_EOL;
		for ($w = 0; $w < $this->width; $w++){
			for ($h = 0; $h < $this->height; $h++){
				echo ($this->getValue($w, $h) ? 'X' : '-') . ' ';
			}
			echo PHP_EOL;
		}
		echo PHP_EOL;
	}

}

