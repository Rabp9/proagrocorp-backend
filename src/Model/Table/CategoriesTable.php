<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Categories Model
 *
 * @property \App\Model\Table\CategoriesTable|\Cake\ORM\Association\BelongsTo $Categories
 * @property \App\Model\Table\EstadosTable|\Cake\ORM\Association\BelongsTo $Estados
 *
 * @method \App\Model\Entity\Category get($primaryKey, $options = [])
 * @method \App\Model\Entity\Category newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Category[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Category|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Category|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Category patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Category[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Category findOrCreate($search, callable $callback = null, $options = [])
 */
class CategoriesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('categories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Tree');

        $this->hasMany('Child1Categories', [
            'className' => 'Categories',
            'foreignKey' => 'parent_id'
        ])->setProperty('child1Categories');
        
        $this->hasMany('Child2Categories', [
            'className' => 'Categories',
            'foreignKey' => 'parent_id'
        ])->setProperty('child2Categories');
        
        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'joinType' => 'INNER'
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
            ->maxLength('descripcion', 90)
            ->requirePresence('descripcion', 'create')
            ->notEmpty('descripcion');

        $validator
            ->scalar('background')
            ->maxLength('background', 60)
            ->allowEmpty('background');

        $validator
            ->scalar('resumen')
            ->maxLength('resumen', 60)
            ->allowEmpty('resumen');

        $validator
            ->scalar('resumenDetallado')
            ->allowEmpty('resumenDetallado');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['category_id'], 'Categories'));
        $rules->add($rules->existsIn(['estado_id'], 'Estados'));

        return $rules;
    }
}
