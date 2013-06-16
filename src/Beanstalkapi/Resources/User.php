<?php

namespace Beanstalkapi\Resources;


use Guzzle\Service\Command\OperationCommand;
use Guzzle\Service\Command\ResponseClassInterface;

class User implements ResponseClassInterface
{

    public static function fromCommand(OperationCommand $command)
    {
        return self($command->getResponse()->json());
    }
}