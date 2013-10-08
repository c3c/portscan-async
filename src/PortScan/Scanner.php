<?php

namespace PortScan;

class Scanner {
	private $timeout = 5;
	private $tests;
	private $lookup;
	private $socks;
	public $results;

	public function __construct() {
	}

	public function addTest($host, $port) {
		$this->tests[] = array($host, $port);
	}

	// you can use a float
	public function setTimeout($seconds) {
		$this->timeout = $seconds;
	}

	private function createSockets() {
		foreach ($this->tests as $test) {
			list($host, $port) = $test;
			$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			socket_set_nonblock($sock);
			@socket_connect($sock, $host, $port);

			$this->socks[] = $sock;
			$this->lookup[$sock] = array($host, $port);
		}
	}

	private function handleSelect($selects, $func) {
		foreach ($selects as $idx => $sock) {
			list ($host, $port) = $this->lookup[$sock];
			$this->results[$host][$port] = $func($sock);
	
			unset($this->socks[$idx]);
			socket_close($sock);
		}
	}

	public function scan($cb = null) {
		$this->createSockets();

		$poll = microtime(true);
		while ($this->socks && microtime(true) - $poll < $this->timeout) {
			$null = null;
			$write = $this->socks;

			socket_select($null, $write, $null, 0, 50);
			$this->handleSelect($write, function($sock) {
				return socket_get_option($sock, SOL_SOCKET, SO_ERROR);
			});
		}

		$this->handleSelect($this->socks, function() { return SOCKET_ETIMEDOUT; });
	}
}
