<?php

namespace Pgvector\Hyperf\Listener;

use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Framework\Event\BootApplication;
use Pgvector\Hyperf\Schema;

class BootApplicationListener implements ListenerInterface {
	public function listen(): array {
		return [
			BootApplication::class
		];
	}
	
	public function process(object $event): void {
		if (!$event instanceof BootApplication) {
			return;
		}
		
		Schema::register();
		
	}
}
