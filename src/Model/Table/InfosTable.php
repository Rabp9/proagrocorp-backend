<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Infos Model
 *
 * @method \App\Model\Entity\Info get($primaryKey, $options = [])
 * @method \App\Model\Entity\Info newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Info[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Info|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Info|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Info patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Info[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Info findOrCreate($search, callable $callback = null, $options = [])
 */
class InfosTable extends Table
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

        $this->setTable('infos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->scalar('valor')
            ->maxLength('valor', 45)
            ->allowEmpty('valor');

        $validator
            ->scalar('tipo')
            ->maxLength('tipo', 10)
            ->allowEmpty('tipo');

        return $validator;
    }
}
