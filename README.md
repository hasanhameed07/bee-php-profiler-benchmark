# bee-php-profiler-benchmark
####An easy to use and super accurate Benchmark & Profiling library for PHP.

`Bee_Profiler` is main library for profiling while `Bee_Profiler_Function` is a library to benchmark functions and requires `Bee_Profiler`.

### Profiling

#### Basic usage
This will auto generate report at the script end with auto start & stop
```php
require_once('lib/Benchmark.php');

$benchmark = new Bee_Profiler(true);
// your code
  // more code here
```
#### Custom start & stop
```php
require_once('lib/Benchmark.php');

$benchmark = new Bee_Profiler();
$benchmark->start();
// your code
  // more code here
$benchmark->stop();
$benchmark->displayResults();
```
#### Custom markers
Setting multiple static markers between your code allows you to compare time difference.
```php
require_once('lib/Benchmark.php');

Bee_Profiler::setMarker('Begining');
// your code here
  Bee_Profiler::setMarker('Mid');
  // more code here
Bee_Profiler::setMarker('Ending');

Bee_Profiler::displayMarkerResults();

// Outputs something like
// Begining to mid: 0.036728858947754 sec.
// mid to Ending:   0.00011301040649414 sec.
// Total time :     0.036841869354248 sec.

```

### Benchmarking

#### Comparing functions
```php
require_once('lib/Bee_Profiler.php');
require_once('lib/Bee_Benchmark_Function.php');

function f1 ($array) {
  $count = count($array);
	for($i=0;$i<$count;$i++) {
	}
}

function f2 ($array) {
	foreach($array as $k=>$val) {
	}
}

$profiler = new Bee_Benchmark_Function(false, 4000);	// 1000 times to execute
$profiler->start();

$profiler->call('f1', array(2,4,6,8));
$profiler->call('f2', array(2,4,6,8));
// call more functions here...	
// even static method of a class
// $profiler->call('Math::sum', 2, 2);										

$profiler->stop();
$profiler->displayResults(); // or display full report (this gets called by profiler in auto mode)
```

#### Get the fastest function
This will get the func name which is fastest of all.
```php
echo $profiler->getFastestFunc();
```

#### Compare difference between two functions
```php
// make call() to functions prior to show this report
$profiler->showFastestBetween('f1', 'f2');
```

Original Author: Hasan Hameed <hasan.hameed07@gmail.com>
