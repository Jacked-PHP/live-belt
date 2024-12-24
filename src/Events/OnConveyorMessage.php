<?php

namespace LiveBelt\Events;

class OnConveyorMessage
{
    public function __construct(
        public string $data,
    ) {}
}
