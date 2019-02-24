<?php
/**
 * Created by PhpStorm.
 * User: ruba.sadi
 * Date: 24.02.19
 * Time: 16:03
 */

namespace ServerPlanner\Methods;

use ServerPlanner\Models\Server;
use ServerPlanner\Models\VirtualMachine;

class ServerPlanner
{
    /**
     * @param Server $serverType
     * @param VirtualMachine[] $virtualMachines
     * @return int
     */
    public static function calculate(Server $serverType, $virtualMachines)
    {
        $server = clone $serverType;
        $serversNeeded = 1;
        foreach ($virtualMachines as $virtualMachine) {
            if (!$server->virtualMachineFit($virtualMachine)) {
                $server = clone $serverType;
                $server->attachVirtualMachineToServer($virtualMachine);
                $serversNeeded += 1;
            }
        }
        return $serversNeeded;
    }
}