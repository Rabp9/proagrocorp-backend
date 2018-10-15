<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ControllerRolesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ControllerRolesTable Test Case
 */
class ControllerRolesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ControllerRolesTable
     */
    public $ControllerRoles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.controller_roles',
        'app.roles',
        'app.controllers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ControllerRoles') ? [] : ['className' => ControllerRolesTable::class];
        $this->ControllerRoles = TableRegistry::get('ControllerRoles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ControllerRoles);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
