<?php

namespace TrafficCophp\Message;

use TrafficCophp\Channel\Channel;

abstract class AbstractPublishMessage extends AbstractSendMessage {
	abstract public function __construct(Channel $channel, $message);
	abstract public function getChannel();
	abstract public function getMessage();
}