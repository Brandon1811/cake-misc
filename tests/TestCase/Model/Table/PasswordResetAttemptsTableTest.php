<?php
namespace Misc\Test\TestCase\Model\Table;

use Cake\Log\Log;
use Misc\Model\Table\PasswordResetAttemptsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PasswordResetAttemptsTable Test Case
 */
class PasswordResetAttemptsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PasswordResetAttemptsTable
     */
    public $PasswordResetAttempts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Misc.PasswordResetAttempts',
        'Misc.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PasswordResetAttempts') ? [] : ['className' => PasswordResetAttemptsTable::class];
        $this->PasswordResetAttempts = TableRegistry::getTableLocator()->get('PasswordResetAttempts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PasswordResetAttempts);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        Log::write('debug', 'inside PasswordResetAttemptsTable testInitialize ');

        $associations = $this->PasswordResetAttempts->associations();
        $this->assertCount(1, $associations);
        $this->assertNotNull($this->PasswordResetAttempts->getAssociation('Users'));

        // Test behaviors
        $this->assertEquals(1, $this->PasswordResetAttempts->behaviors()->count());
        $this->assertNotNull($this->PasswordResetAttempts->behaviors()->get('Timestamp'));
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        Log::write('debug', 'inside PasswordResetAttemptsTable testValidationDefault ');

        $entity = $this->_validDefault();
        $data = [
            'user_id' => 2,
            'ip' => '',
            'ip_long' => '',
        ];
        $entityTwo = $this->PasswordResetAttempts->newEntity(
            $data,
            [
                'fields' => array_keys($data)
            ]
        );
        Log::write('debug', 'errors next');
        Log::write('debug', $entityTwo->getErrors());
        $this->assertCount(0, $entityTwo->getErrors()); // empty = no validation errors
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        Log::write('debug', 'inside PasswordResetAttemptsTable testBuildRules ');
        $entity = $this->_validDefault();
        $data = [
            'user_id' => 1,
            'ip' => '192.168.0.1',
            'ip_long' => ip2long('192.168.0.1'),
        ];
        $entityTwo = $this->PasswordResetAttempts->newEntity(
            $data,
            [
                'fields' => array_keys($data)
            ]
        );
        Log::write('debug', 'errors next');
        Log::write('debug', $entityTwo->getErrors());
        $result = $this->PasswordResetAttempts->save($entityTwo);

        $this->assertFalse($result);
        //$this->assertArrayHasKey('field_name', $entityTwo->getErrors());
    }

    /**
     * _validDefault - creates entity successfully and returns
     *
     * @return void
     */
    protected function _validDefault()
    {
        Log::write('debug', 'inside PasswordResetAttemptsTable  _validDefault');
        // test valid entity
        $data = [
            'user_id' => 1,
            'ip' => '192.168.0.1',
            'ip_long' => ip2long('192.168.0.1'),
            'created' => new FrozenTime(),
            'expires' => new FrozenTime('+4 hours'),
            'reset_at' => null,
            'token' => 'test_token',
        ];
        $entity = $this->PasswordResetAttempts->newEntity(
            $data,
            [
                'fields' => array_keys($data)
            ]
        );
        Log::write('debug', 'errors next');
        Log::write('debug', $entity->getErrors());
        $this->assertEmpty($entity->getErrors()); // empty = no validation errors

        return $entity;
    }
}
