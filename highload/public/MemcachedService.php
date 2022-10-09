<?php

class MemcachedService
{
    public function getCache()
    {
        $memcached = new Memcached();
        $memcached->addServer('memcached', 11211);

        $memcached->set('int', 102);
        $memcached->set('string', 'some cached string');
        $memcached->set('array', [2, 5, 8, 7]);
        $memcached->set('object', new stdClass(), time()+600);

        var_dump($memcached->get('int'));
        var_dump($memcached->get('string'));
        var_dump($memcached->get('array'));
        var_dump($memcached->get('object'));
    }

}
