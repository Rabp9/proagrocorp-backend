<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Controller $controller
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $controller->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $controller->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Controllers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Controller Roles'), ['controller' => 'ControllerRoles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Controller Role'), ['controller' => 'ControllerRoles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="controllers form large-9 medium-8 columns content">
    <?= $this->Form->create($controller) ?>
    <fieldset>
        <legend><?= __('Edit Controller') ?></legend>
        <?php
            echo $this->Form->control('descripcion');
            echo $this->Form->control('controllerName');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
