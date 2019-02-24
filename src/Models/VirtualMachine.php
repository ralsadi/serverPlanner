<?php
/**
 * Created by PhpStorm.
 * User: ruba.sadi
 * Date: 24.02.19
 * Time: 14:45
 */

namespace ServerPlanner\Models;

class VirtualMachine
{
    /**
     * @var int $cpu
     */
    public $cpu;

    /**
     * @var int $ram
     */
    public $ram;

    /**
     * @var int $hdd
     */
    public $hdd;

    public function __construct($cpu, $ram, $hdd)
    {
        $this->cpu = $cpu;
        $this->ram = $ram;
        $this->hdd = $hdd;
    }
}