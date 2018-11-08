<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Links Model
 *
 * @property \App\Model\Table\EstadosTable|\Cake\ORM\Association\BelongsTo $Estados
 *
 * @method \App\Model\Entity\Link get($primaryKey, $options = [])
 * @method \App\Model\Entity\Link newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Link[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Link|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Link|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Link patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Link[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Link findOrCreate($search, callable $callback = null, $options = [])
 */
class LinksTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->addBehavior('Burzum/Imagine.Imagine');
        $this->setTable('links');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

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
    public function validationDefault(Validator $validator) {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('descripcion')
            ->maxLength('descripcion', 60)
            ->requirePresence('descripcion', 'create')
            ->notEmpty('descripcion');

        $validator
            ->scalar('url')
            ->maxLength('url', 90)
            ->allowEmpty('url');

        $validator
            ->scalar('imagen')
            ->maxLength('imagen', 90)
            ->allowEmpty('imagen');

        $validator
            ->scalar('ubicacion')
            ->maxLength('ubicacion', 10)
            ->allowEmpty('ubicacion');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['estado_id'], 'Estados'));

        return $rules;
    }
    
    public function afterSave($event, $entity, $options) {
        $imageOperationsLarge = [
            'thumbnail' => [
                'height' => 800,
                'width' => 800
            ],
        ];
        $imageOperationsSmall = [
            'thumbnail' => [
                'height' => 400,
                'width' => 400
            ],
        ];
        
        $path = WWW_ROOT . "img". DS . 'links' . DS;
        
        if ($entity->imagen) {
            $ext = pathinfo($entity->imagen, PATHINFO_EXTENSION);
            $filenameBase = basename($entity->imagen, '.' . $ext);
            if (file_exists($path . $entity->imagen)) {
                $this->processImage($path . $entity->imagen,
                    $path . $filenameBase . '_large.' . $ext,
                    [],
                    $imageOperationsLarge
                );
                $this->processImage($path . $entity->imagen,
                    $path . $filenameBase . '_small.' . $ext,
                    [],
                    $imageOperationsSmall
                );
            }
        }
    }
}
