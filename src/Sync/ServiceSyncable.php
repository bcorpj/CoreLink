<?php

namespace Singlephon\Corelink\Sync;

use Singlephon\Corelink\Intentions\Syncable;

class ServiceSyncable extends Syncable
{
    /**
     * @return array
     */
    protected function routes(): array
    {
        return [
            'create' => '/nodelink/produce',
            'notify' => '/nodelink/notify'
        ];
    }
}
