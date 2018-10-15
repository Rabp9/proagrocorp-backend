<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ControllerRolesFixture
 *
 */
class ControllerRolesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'rol_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'controller_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'permiso' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'fk_controller_roles_roles1_idx' => ['type' => 'index', 'columns' => ['rol_id'], 'length' => []],
            'fk_controller_roles_controllers1_idx' => ['type' => 'index', 'columns' => ['controller_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id', 'rol_id', 'controller_id'], 'length' => []],
            'fk_controller_roles_controllers1' => ['type' => 'foreign', 'columns' => ['controller_id'], 'references' => ['controllers', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_controller_roles_roles1' => ['type' => 'foreign', 'columns' => ['rol_id'], 'references' => ['roles', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'rol_id' => 1,
                'controller_id' => 1,
                'permiso' => 1
            ],
        ];
        parent::init();
    }
}
