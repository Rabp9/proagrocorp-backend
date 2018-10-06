<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Estados Model
 *
 * @property \App\Model\Table\CategoriesTable|\Cake\ORM\Association\HasMany $Categories
 * @property \App\Model\Table\LinksTable|\Cake\ORM\Association\HasMany $Links
 * @property \App\Model\Table\ProductosTable|\Cake\ORM\Association\HasMany $Productos
 *
 * @method \App\Model\Entity\Estado get($primaryKey, $options = [])
 * @method \App\Model\Entity\Estado newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Estado[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Estado|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Estado|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Estado patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Estado[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Estado findOrCreate($search, callable $callback = null, $options = [])
 */
class EstadosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('estados');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Categories', [
            'foreignKey' => 'estado_id'
        ]);
        $this->hasMany('Links', [
            'foreignKey' => 'estado_id'
        ]);
        $this->hasMany('Productos', [
            'foreignKey' => 'estado_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('descripcion')
            ->maxLength('descripcion', 10)
            ->allowEmpty('descripcion');

        return $validator;
    }
}
