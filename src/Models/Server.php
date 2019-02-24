<?php
/**
 * Created by PhpStorm.
 * User: ruba.sadi
 * Date: 24.02.19
 * Time: 14:45
 */
namespace ServerPlanner\Models;

use ServerPlanner\Exceptions\VirtualMachineTooLargeException;

class Server
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

    /**
     * @var int $freeCPU
     */
    public $freeCPU;

    /**
     * @var int $freeRAM
     */
    public $freeRAM;

    /**
     * @var int $freeHDD
     */
    public $freeHDD;

    /**
     * @var VirtualMachine $currentVirtualMachine
     */
    protected $currentVirtualMachine;

    public function __construct($cpu, $ram, $hdd)
    {
        $this->cpu = $cpu;
        $this->ram = $ram;
        $this->hdd = $hdd;

        $this->freeCPU = $cpu;
        $this->freeRAM = $ram;
        $this->freeHDD = $hdd;
    }

    public function attachVirtualMachineToServer(VirtualMachine $virtualMachine){
        $this->currentVirtualMachine = $virtualMachine;
        $this->updateServerFreeSpace();
    }

    public function virtualMachineFit(VirtualMachine $virtualMachine)
    {
        $this->currentVirtualMachine = $virtualMachine;
        if (!$this->validVirtualMachine()) {
            throw new VirtualMachineTooLargeException();
        }

        if (!$this->virtualMachineFitsServer()) {
            return false;
        }

        $this->updateServerFreeSpace();

        return true;
    }

    protected function validVirtualMachine()
    {
        if ($this->currentVirtualMachine->cpu > $this->cpu ||
            $this->currentVirtualMachine->ram > $this->ram ||
            $this->currentVirtualMachine->hdd > $this->hdd) {
            return false;
        }
        return true;
    }

    protected function virtualMachineFitsServer()
    {
        if ($this->currentVirtualMachine->cpu <= $this->freeCPU &&
            $this->currentVirtualMachine->ram <= $this->freeRAM &&
            $this->currentVirtualMachine->hdd <= $this->freeHDD) {
            return true;
        }
        return false;
    }

    protected function updateServerFreeSpace()
    {
        $this->freeCPU -= $this->currentVirtualMachine->cpu;
        $this->freeRAM -= $this->currentVirtualMachine->ram;
        $this->freeHDD -= $this->currentVirtualMachine->hdd;
    }
}