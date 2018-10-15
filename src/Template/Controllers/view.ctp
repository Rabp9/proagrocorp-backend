<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Controller $controller
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Controller'), ['action' => 'edit', $controller->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Controller'), ['action' => 'delete', $controller->id], ['confirm' => __('Are you sure you want to delete # {0}?', $controller->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Controllers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Controller'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Controller Roles'), ['controller' => 'ControllerRoles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Controller Role'), ['controller' => 'ControllerRoles', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="controllers view large-9 medium-8 columns content">
    <h3><?= h($controller->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Descripcion') ?></th>
            <td><?= h($controller->descripcion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ControllerName') ?></th>
            <td><?= h($controller->controllerName) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($controller->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Controller Roles') ?></h4>
        <?php if (!empty($controller->controller_roles)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Rol Id') ?></th>
                <th scope="col"><?= __('Controller Id') ?></th>
                <th scope="col"><?= __('Permiso') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($controller->controller_roles as $controllerRoles): ?>
            <tr>
                <td><?= h($controllerRoles->id) ?></td>
                <td><?= h($controllerRoles->rol_id) ?></td>
                <td><?= h($controllerRoles->controller_id) ?></td>
                <td><?= h($controllerRoles->permiso) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ControllerRoles', 'action' => 'view', $controllerRoles->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ControllerRoles', 'action' => 'edit', $controllerRoles->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ControllerRoles', 'action' => 'delete', $controllerRoles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $controllerRoles->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
