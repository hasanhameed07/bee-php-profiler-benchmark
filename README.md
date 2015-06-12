# bee-php-benchmark
###An easy to use and super accurate Benchmark library for PHP.

`Bee_Benchmark` is main library for profiling while `Bee_Benchmark_Function` is a library to benchmark functions and require `Bee_Benchmark`.

## Basic usage
This will auto generate report at the script end with auto start & stop
```
require_once('Benchmark.php');
$benchmark = new Bee_Benchmark(true);
// your code
  // more code here
```
## Custom start & stop
```
require_once('Benchmark.php');
$benchmark = new Bee_Benchmark();
$benchmark->start();
// your code
  // more code here
$benchmark->stop();
$benchmark->displayResults();
```
