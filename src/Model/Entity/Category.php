<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Category Entity
 *
 * @property int $id
 * @property int $category_id
 * @property string $descripcion
 * @property string $background
 * @property string $resumen
 * @property string $resumenDetallado
 * @property int $estado_id
 *
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\Estado $estado
 */
class Category extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'descripcion' => true,
        'background' => true,
        'resumen' => true,
        'resumenDetallado' => true,
        'category' => true,
        'estado' => true
    ];
}
