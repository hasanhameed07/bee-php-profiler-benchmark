<?php

require_once('lib/Bee_Profiler.php');
require_once('lib/Bee_Benchmark_Function.php');

Bee_Profiler::setMarker('Begining');
class A{
public static function f1 ($array) {
$count = count($array);
	for($i=0;$i<$count;$i++) {
	}
}
}
function f2 ($array) {
	foreach($array as $k=>$val) {
	}
}

// Auto start, stop & display

$benchmark = new Bee_Profiler();
$benchmark->start();




// Manual start, stop & display

$profiler = new Bee_Benchmark_Function(false, 4000);	// 1000 times to execute
$profiler->start();

$profiler->call('A::f1', array(2,4,6,8));
$profiler->call('f2', array(2,4,6,8));
// call more functions here...											

$profiler->stop();

Bee_Profiler::setMarker('mid');
// this will get the func name which is fastest of all.
//echo $profiler->getFastestFunc();

// or compare two functions by percentage.
// $profiler->showFastestBetween('f1', 'f2');

// or display full report (this gets called by profiler in auto mode)
$benchmark->stop();
$profiler->displayResults();


Bee_Profiler::setMarker('Ending');
Bee_Profiler::displayMarkerResults();

