<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ControllerRole $controllerRole
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Controller Role'), ['action' => 'edit', $controllerRole->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Controller Role'), ['action' => 'delete', $controllerRole->id], ['confirm' => __('Are you sure you want to delete # {0}?', $controllerRole->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Controller Roles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Controller Role'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Controllers'), ['controller' => 'Controllers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Controller'), ['controller' => 'Controllers', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="controllerRoles view large-9 medium-8 columns content">
    <h3><?= h($controllerRole->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Role') ?></th>
            <td><?= $controllerRole->has('role') ? $this->Html->link($controllerRole->role->id, ['controller' => 'Roles', 'action' => 'view', $controllerRole->role->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Controller') ?></th>
            <td><?= $controllerRole->has('controller') ? $this->Html->link($controllerRole->controller->id, ['controller' => 'Controllers', 'action' => 'view', $controllerRole->controller->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($controllerRole->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Permiso') ?></th>
            <td><?= $controllerRole->permiso ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
