<?php
 /**
 * Function Benchmarking extention for Bee_Profiler
 *
 *
 * @author  Hasan Hameed <hasan.hameed07@gmail.com>
 * @version 1.0.0
 * @see https://github.com/hasanhameed07/bee-php-benchmark
 */
class Bee_Benchmark_Function
{

	// --- Public properties ---

	/**
	 * func - contains function names & thier params
	 * @var array
	 */
	public $func = array();

	/**
	 * _profiler - Instance of Bee_Benchmark
	 * @var object
	 */
	private $_profiler;

	/**
	 * _times - Number of times func should call
	 * @var int
	 */
	private $_times;

	/**
	 * _auto - Enables auto start, stop & display
	 * @var boolean
	 */
	private $_auto = false;



	// --- Public methods ---

	/**
	 * Creates new instance & start global timer if autostart is true
	 *
	 * @param boolen	$auto [autostart]
	 * @param int		$times [no. of times to repeat function call]
	 */
	public function __construct ($auto=false, $times=1000)
	{
		$this->_times = $times;
		$this->_auto = $auto;

		if ($this->_auto)
			$this->start();
	}


	/**
	 * Stops the global section & display report if autostart is enabled
	 */
	public function __destruct ()
	{
		if ($this->_auto) {
			$this->stop();
			$this->displayResults();
		}
	}


	/**
	 * Starts global timer
	 */
	public function start ()
	{
		$this->_profiler = new Bee_Profiler();
		$this->_profiler->start();
	}


	/**
	 * Stops global timer
	 */
	public function stop ()
	{
		$this->_profiler->stop();
	}


	/**
	 * Starts function profiling
	 *
	 * @param string	[function name]
	 * @param mixed		[function parameters]
	 * @return mixed	[value from function]
	 */
	public function call ()
	{
		$args = func_get_args();
		$func = $args[0]; 
		unset($args[0]);
		$param = $args;

		$this->func[$func]['name'] = $func;
		$this->func[$func]['param'] = $param;

		return $this->_startProfiling($func, $param);
	}


	/**
	 * Show fastest between two functions(called previously)
	 *
	 * @param string	$func1
	 * @param string	$func2
	 */
	public function showFastestBetween ($func1, $func2)
	{
		if (!array_key_exists($func1, $this->func))
			throw new Exception('Function <b>'.$func1.'()</b> should be called before.');
		if (!array_key_exists($func2, $this->func))
			throw new Exception('Function <b>'.$func2.'()</b> should be called before.');

		$info = $this->_profiler->getSectionTime($func1.'()');
		$info2 = $this->_profiler->getSectionTime($func2.'()');

		if ($info > $info2) {
			$per = round(($info2/$info)*100, 2);
			$str = "{$func2}() is faster than {$func1}() by {$per}%";

		} else {
			$per =  round(($info/$info2)*100, 2);
			$str = "{$func1}() is faster than {$func2}() by {$per}%";
		}

		print($str);
	}


	/**
	 * Returns fasted function(called previously)
	 *
	 * @return string	[function name]
	 */
	public function getFastestFunc ()
	{
		$time = array();

		foreach ($this->func as $func=>$key) {
			$time[$func] = $this->_profiler->getSectionTime($func.'()');
		}

		array_multisort($time, SORT_ASC);

		// return func name only
		$keys = array_keys($time);

		return $keys[0];
	}


	/**
	 * Outputs final report of all functions including global timer
	 */
	public function displayResults ()
	{
		$this->_profiler->displayResults();
	}



	// --- Private methods ---

	/**
	 * Starts function profiling
	 *
	 * @param string	$func [func name]
	 * @param array		$param_array [array of params]
	 * @return mixed	[value from function]
	 */
	private function _startProfiling ($func, $param_array)
	{
		$this->_profiler->enterSection($func.'()');
		ob_start();

		for ($i = 0; $i < $this->_times; $i++) {
			$returned = call_user_func_array($func, $param_array);
		}

		ob_clean();
		$this->_profiler->leaveSection($func.'()');
		
		return $returned;	// returned from function call
	}

} // Bee_Benchmark_Function end
?>
