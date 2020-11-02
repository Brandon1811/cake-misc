<?php
namespace App\Test;

use Cake\Log\Log;
use Cake\Utility\Security;
use josegonzalez\Queuesadilla\Engine\NullEngine;
use josegonzalez\Queuesadilla\Job\Base;
use josegonzalez\Queuesadilla\TestCase;
use Psr\Log\NullLogger;

/**
 * App\Test\TestHelper
 * @codeCoverageIgnore
 *
 */
class TestHelper
{
    /**
     * __construct method - Creates the TestHelper class and sets the logger and engine up to be ready to create a job
     */
    public function __construct()
    {
        $config = [];
        $this->Logger = new NullLogger;
        $this->Engine = new NullEngine($this->Logger, $config);
    }

    /**
     * createJob method - Creates the josegonzalez\Queuesadilla\Job\Base class to be passed in as arguments to the functions being tested
     *
     * @param string $className php class name
     * @param array $data data for job
     * @return \josegonzalez\Queuesadilla\Job\Base
     */
    public function createJob(string $className, array $data)
    {
        $jobData = [
            'id' => 1,
            'delay' => 0,
            'class' => $className,
            'queue' => 'default',
            'args' => [
                $data
            ],
        ];

        return new Base($jobData, $this->Engine);
    }
}
