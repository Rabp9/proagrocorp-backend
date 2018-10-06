<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Link $link
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $link->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $link->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Links'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Estados'), ['controller' => 'Estados', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Estado'), ['controller' => 'Estados', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="links form large-9 medium-8 columns content">
    <?= $this->Form->create($link) ?>
    <fieldset>
        <legend><?= __('Edit Link') ?></legend>
        <?php
            echo $this->Form->control('descripcion');
            echo $this->Form->control('url');
            echo $this->Form->control('imagen');
            echo $this->Form->control('ubicacion');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
