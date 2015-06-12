# bee-php-benchmark
####An easy to use and super accurate Benchmark & Profiling library for PHP.

`Bee_Benchmark` is main library for profiling while `Bee_Benchmark_Function` is a library to benchmark functions and requires `Bee_Benchmark`.

### Profiling

#### Basic usage
This will auto generate report at the script end with auto start & stop
```php
require_once('lib/Benchmark.php');

$benchmark = new Bee_Benchmark(true);
// your code
  // more code here
```
#### Custom start & stop
```php
require_once('lib/Benchmark.php');

$benchmark = new Bee_Benchmark();
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

Bee_Benchmark::setMarker('Begining');
// your code here
  Bee_Benchmark::setMarker('Mid');
  // more code here
Bee_Benchmark::setMarker('Ending');

Bee_Benchmark::displayMarkerResults();

// Outputs something like
// Begining to mid: 0.036728858947754 sec.
// mid to Ending:   0.00011301040649414 sec.
// Total time :     0.036841869354248 sec.

```
