<?php

namespace Deadan\Support\Http;

/**
 *
 *
 * A simple implementation of the Weighted Round-Robin Scheduling in PHP 5.3+
 *
 * This class relies heavily on code from Alexis Gruet
 * https://gist.github.com/MI-LA01/9242702
 *
 * The weighted round-robin scheduling is designed to better handle devices with different
 * processing capacities. Each device can be assigned a weight, an integer value that
 * indicates the processing capacity. Devices with higher weights receive new connections/load
 * first than those with less weights, and devices with higher weights get more connections/
 * load than those with less weights and devices with equal weights get equal connections.
 *
 * Useful when you want to send smartly balanced traffic to a remote api or sms to various
 * devices depending on the processing power of the devices.
 *
 *
 */
class LoadBalancer
{
    /**
     * @var string
     * cw is the current weight in scheduling, and cw is initialized with zero;
     */
    //private $__CW__ = 'round-robin-dispatch-cw';
    private $__CW__ = 0;
    /**
     * @var int
     * i indicates the server selected last time, and i is initialized with -1;
     */
    private $__I__ = -1;
    /**
     * @var A list of partners/servers/devices with their associated weights i.e max requests they can handled
     * Format:
     *         $__SERVERS__ = [
     * 0 => [
     * 'device_id' => 'partner1',
     * 'weight'    => 4
     * ],
     * 1 => [
     * 'device_id' => 'partner2',
     * 'weight'    => 3
     * ],
     * 2 => [
     * 'device_id' => 'partner3',
     * 'weight'    => 2
     * ]
     * ];
     */
    
    private $__SERVERS__ = [];
    
    /**
     * LoadBalancer constructor.
     *
     * @param array $servers
     * @param null  $i
     */
    public function __construct(array $servers, $i = null)
    {
        $this->__SERVERS__ = $servers;
        $this->__I__ = (!is_null($i)) ? $i : -1;
        
    }
    
    /**
     *
     */
    public function run()
    {
        return $this->weightedRoundRobbin($this->__SERVERS__);
    }
    
    /**
     * This selects the server to dispatch load to using a weighted Round robbin algorithm.
     * Servers with higher weights receive new connections first than those with less weights,
     * and servers with higher weights get more connections than those with less weights
     * and servers with equal weights get equal connections.
     *
     * @see      http://kb.linuxvirtualserver.org/wiki/Weighted_Round-Robin_Scheduling
     *
     * @param  $serverPool
     *
     * @return null
     * @internal param $c
     */
    private function weightedRoundRobbin($serverPool)
    {
        $n = count($serverPool);
        /**
         * greatest common divisor of all provider weights;
         */
        $gcd = function () use ($serverPool) {
            $gcd = function ($a, $b) use (&$gcd) {
                return $b ? $gcd($b, $a % $b) : $a;
            };
            return array_reduce(array_column($serverPool, 'weight'), $gcd);
        };
        /**
         * get the max weight across the whole providers
         */
        $max = array_reduce($serverPool, function ($v, $w) {
            return max($v, $w['weight']);
        }, -9999999);
        
        //run!
        while (1) {
            $i = ($this->__I__ + 1) % $n;
            //
            if ($i == 0) {
                $cw = $this->__CW__ - $gcd();
                //
                if ($cw <= 0) {
                    $cw = $max;
                    //
                    if ($cw == 0) {
                        return;
                    }
                }
            }
            if ($this->getIndividualWeight($i) >= $cw) {
                return $serverPool[$i];
            }
        }
    }
    
    /**
     * Get the weight of a specific provider
     *
     * @param  $provider
     *
     * @return mixed
     */
    private function getIndividualWeight($provider)
    {
        return $this->__SERVERS__[$provider]['weight'];
    }
}