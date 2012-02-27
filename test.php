<?php

require 'Automato.php';

$a = new Automato (20, 20);
$a->seed(10);

$a->addRule(0, 0, 0);
$a->addRule(1, '5,6,7,8', 0);
$a->addRule(0, -1, 1);

$a->render();
for ($x = 0; $x < 1000; $x++){
	sleep(1);
	$a->evolve();
	$a->render();
}
