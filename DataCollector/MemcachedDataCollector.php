<?php

namespace BeSimple\Bundle\MemcachedBundle\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class MemcachedDataCollector extends DataCollector
{
    protected $memcached;

    public function setMemcached($memcached)
    {
        if ($memcached instanceof \BeSimple_Memcached_TraceableInterface) {
            $this->memcached = $memcached;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = array(
            'actions' => null !== $this->memcached ? $this->memcached->getActions() : array(),
        );

        if (null !== $this->memcached) {
            $actions = $this->memcached->getActions();
            foreach ($actions as $i => $action) {
                $actions[$i]['returned_value'] = $this->varToString($action['returned_value']);
            }

            $this->data['actions'] = $actions;
        }
    }

    public function getActions()
    {
        return $this->data['actions'];
    }

    public function getActionCount()
    {
        return count($this->data['actions']);
    }

    public function getTime()
    {
        $time = 0;
        foreach ($this->getActions() as $action) {
            $time += $action['time'];
        }

        return $time;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'be_simple.memcached';
    }
}
