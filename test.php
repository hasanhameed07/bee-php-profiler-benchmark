<?php

require_once('Benchmark.php');
require_once('Function.php');

Bee_Benchmark::setMarker('Begining');

function f1 ($array) {
$count = count($array);
	for($i=0;$i<$count;$i++) {
	}
}

function f2 ($array) {
	foreach($array as $k=>$val) {
	}
}

// Auto start, stop & display

$func = new Bee_Benchmark(true);




// Manual start, stop & display

$profiler = new Bee_Benchmark_Function(false, 4000);	// 1000 times to execute
$profiler->start();

$profiler->call('f1', array(2,4,6,8));
$profiler->call('f2', array(2,4,6,8));
// call more functions here...											

$profiler->stop();

// this will get the func name which is fastest of all.
//echo $profiler->getFastestFunc();

// or compare two functions by percentage.
$profiler->showFastestBetween('f1', 'f2');

// or display full report (this gets called by profiler in auto mode)
$profiler->display();


Bee_Benchmark::setMarker('Ending');
Bee_Benchmark::displayResults();