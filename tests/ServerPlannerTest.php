<?php

use ServerPlanner\Models\Server;
use ServerPlanner\Models\VirtualMachine;
use ServerPlanner\Methods\ServerPlanner;
use PHPUnit\Framework\TestCase;

class ServerPlannerTest extends TestCase
{
    public function testCase1()
    {
        $server = new Server(2, 32, 100);
        $virtualMachines = [
            new VirtualMachine(1, 16, 10),
            new VirtualMachine(1, 16, 10),
            new VirtualMachine(2, 32, 100)
        ];

        $val = ServerPlanner::calculate($server, $virtualMachines);
        $this->assertEquals($val, 2);
    }

    public function testCase2()
    {
        $server = new Server(2, 32, 100);
        $virtualMachines = [
            new VirtualMachine(1, 16, 10),
            new VirtualMachine(2, 16, 10),
            new VirtualMachine(2, 32, 100)
        ];

        $val = ServerPlanner::calculate($server, $virtualMachines);
        $this->assertEquals($val, 3);
    }

    public function testCase3()
    {
        $this->expectException("\ServerPlanner\Exceptions\VirtualMachineTooLargeException");
        $server = new Server(2, 32, 100);
        $virtualMachines = [
            new VirtualMachine(1, 16, 10),
            new VirtualMachine(2, 16, 10),
            new VirtualMachine(3, 32, 100)
        ];

        ServerPlanner::calculate($server, $virtualMachines);
    }
}
