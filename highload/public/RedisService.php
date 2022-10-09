<?php

class RedisService
{
    public function getCache()
    {
        $redis = new Redis();
        $redis->connect('redis');

        $redis->set('int', 1245);
        $redis->set('string', 'some redis cached string');
        $redis->set('array', [12,10,45,28,33]);
        $redis->set('object', new stdClass(), time()+600);

        var_dump($redis->get('int'));
        var_dump($redis->get('string'));
        var_dump($redis->get('array'));
        var_dump($redis->get('object'));

    }

}
