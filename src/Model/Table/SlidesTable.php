<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Slides Model
 *
 * @property \App\Model\Table\EstadosTable|\Cake\ORM\Association\BelongsTo $Estados
 *
 * @method \App\Model\Entity\Slide get($primaryKey, $options = [])
 * @method \App\Model\Entity\Slide newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Slide[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Slide|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Slide patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Slide[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Slide findOrCreate($search, callable $callback = null, $options = [])
 */
class SlidesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);
        $this->table('slides');
        $this->displayField('titulo');
        $this->primaryKey('id');
        $this->addBehavior('Burzum/Imagine.Imagine');
        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id',
            'joinType' => 'INNER'
        ]);
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
        
        $path = WWW_ROOT . "img". DS . 'slides' . DS;
        
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
