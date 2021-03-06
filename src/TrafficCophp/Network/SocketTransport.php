<?php

namespace TrafficCophp\Network;

use TrafficCophp\Network\Exception as NetworkException;
use TrafficCophp\Message\AbstractMessage;

class SocketTransport extends AbstractTransport {

	protected $host;
	protected $port;
	protected $resource;

	public function __construct($host, $port) {
		$this->host = $host;
		$this->port = $port;
	}

	public function receive($bytes) {
		if (!$this->isConnected()) {
			$this->connect();
		}
		return socket_read($this->resource, $bytes, PHP_BINARY_READ);
	}

	public function send(AbstractMessage $message) {
		if (!$this->isConnected()) {
			$this->connect();
		}
		socket_write($this->resource, $message->getProtokollString(), $message->getLength());
	}

	protected function isConnected() {
		return is_resource($this->resource);
	}

	protected function connect() {
		$this->resource = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		$connteced = socket_connect($this->resource, $this->host, $this->port);
		if (!$connteced) {
			throw new NetworkException('Cant establish connection to Traffic Cop server');
		}
	}

	public function __destruct() {
		if ($this->isConnected()) {
			socket_close($this->resource);
		}
	}

}