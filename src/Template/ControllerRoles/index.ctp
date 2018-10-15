<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ControllerRole[]|\Cake\Collection\CollectionInterface $controllerRoles
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Controller Role'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Controllers'), ['controller' => 'Controllers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Controller'), ['controller' => 'Controllers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="controllerRoles index large-9 medium-8 columns content">
    <h3><?= __('Controller Roles') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rol_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('controller_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('permiso') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($controllerRoles as $controllerRole): ?>
            <tr>
                <td><?= $this->Number->format($controllerRole->id) ?></td>
                <td><?= $controllerRole->has('role') ? $this->Html->link($controllerRole->role->id, ['controller' => 'Roles', 'action' => 'view', $controllerRole->role->id]) : '' ?></td>
                <td><?= $controllerRole->has('controller') ? $this->Html->link($controllerRole->controller->id, ['controller' => 'Controllers', 'action' => 'view', $controllerRole->controller->id]) : '' ?></td>
                <td><?= h($controllerRole->permiso) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $controllerRole->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $controllerRole->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $controllerRole->id], ['confirm' => __('Are you sure you want to delete # {0}?', $controllerRole->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
