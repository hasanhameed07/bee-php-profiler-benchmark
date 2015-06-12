<?php
class Bee_Benchmark
{

	// --- Private properties ---

	/**
	 * _markers - Holds markers (keyname:time pair)
	 * @var array
	 * @static
	 */
	private static $_markers = array();

	/**
	 * _sections - Holds sections (keyname:time pair)
	 */
	private $_sections = array();

	/**
	 * _timers - Section timers
	 * @var array
	 */
	private $_timers = array();

	/**
	 * _auto - Enables auto start, stop & display
	 * @var boolean
	 */
	private $_auto = false;



	// --- Public methods ---

	/**
	 * Creates new instance also starts the global section is autostart is true
	 *
	 * @param boolen	$auto [autostart]
	 */
	public function __construct ($auto=false)
	{
		$this->_auto = $auto;
		if ($this->_auto)
			$this->start();
	}


	/**
	 * Stops the global section & display report
	 */
	public function __destruct ()
	{
		if ($this->_auto) {
			$this->stop();
			$this->display();
		}
	}


	/**
	 * Enters global section
	 */
	public function start ()
	{
		$this->enterSection('Global');
	}


	/**
	 * Leaves global section
	 */
	public function stop ()
	{
		$this->leaveSection('Global');
	}


	/**
	 * Enters a new section given by keyname
	 *
	 * @param string	$key [keyname]
	 */
	public function enterSection ($key)
	{
		$this->_sections[$key] = microtime(true);
	}


	/**
	 * Leaves an entered section
	 *
	 * @param string	$key [keyname]
	 */
	public function leaveSection ($key)
	{
		if (!isset($this->_sections[$key]))
			Bee_Exception::throwE('Invalid Section '.$key);

		$this->_timers[$key] = microtime(true) - $this->_sections[$key];
	}


	/**
	 * Returns section time
	 *
	 * @param string	$key [keyname]
	 * @return int		[timestamp]
	 */
	public function getSectionTime ($key)
	{
		return isset($this->_timers[$key])? $this->_timers[$key] : 0 ;
	}


	/**
	 * Outputs final report of all sections
	 */
	public function display ()
	{
		$str = '<h1>Bee Benchmark Results</h1><table border="1" cellpadding="5"><tr><th>No.</th><th>Section</th><th>Time</th>';
		$i = 1;
		array_multisort($this->_timers, SORT_ASC);

		foreach ($this->_timers as $key=>$time) {
			$str .= '<tr>';
			$str .= "<td>{$i}</td><td><b>{$key}</b></td><td>{$time} sec.</td>";
			$str .= '</tr>'; 
			$i++;
		}

		$str .= '</table>'; 
		self::pr($str);
	}


	// --- Public Static methods ---

	/**
	 * Sets a quick marker
	 *
	 * @param string	$key [keyname]
	 */
	public static function setMarker ($key)
	{
		self::$_markers[$key] = microtime(true);
	}


	/**
	 * Reset all markers
	 */
	public static function init ()
	{
		self::$_markers= array();
	}


	/**
	 * Returns marker time according to given keyname
	 *
	 * @param string	$key [keyname]
	 * @return int		[timestamp]
	 */
	public static function getMarkerTime ($key)
	{
		return isset(self::$_markers[$key])? self::$_markers[$key] : 0 ;
	}


	/**
	 * Display final report of all markers
	 */
	public static function displayResults ()
	{
		$str = '<h1>Bee Benchmark Results</h1>';
		$keys = array_keys(self::$_markers);
		$count = count($keys);

		for ($i=1; $i < $count; $i++) {

			$current = $keys[$i];
			$prev = $keys[$i-1];

			$marker1 = $prev;
			$marker2 = $current;

			$t1 = self::$_markers[$current];
			$t2 = self::$_markers[$prev];
			$time = $t1 - $t2;

			$str .= "{$marker1} to {$marker2}: {$time} sec.<br />"; 
		}

		$total = self::$_markers[$keys[$count-1]] - self::$_markers[$keys[0]];
		$str .= "Total time : {$total} sec.<br />";

		self::pr($str);
	}

	public static function pr($str) {
		print '<pre>';
		print_r($str);
		print '</pre>';
	}

} // Bee_Benchmark end
?>