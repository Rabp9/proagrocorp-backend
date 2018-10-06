<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Producto $producto
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Producto'), ['action' => 'edit', $producto->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Producto'), ['action' => 'delete', $producto->id], ['confirm' => __('Are you sure you want to delete # {0}?', $producto->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Productos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Producto'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Estados'), ['controller' => 'Estados', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Estado'), ['controller' => 'Estados', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="productos view large-9 medium-8 columns content">
    <h3><?= h($producto->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Descripcion') ?></th>
            <td><?= h($producto->descripcion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nombre2') ?></th>
            <td><?= h($producto->nombre2) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nombre3') ?></th>
            <td><?= h($producto->nombre3) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Estado') ?></th>
            <td><?= $producto->has('estado') ? $this->Html->link($producto->estado->id, ['controller' => 'Estados', 'action' => 'view', $producto->estado->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($producto->id) ?></td>
        </tr>
    </table>
</div>
