<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Info $info
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Info'), ['action' => 'edit', $info->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Info'), ['action' => 'delete', $info->id], ['confirm' => __('Are you sure you want to delete # {0}?', $info->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Infos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Info'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="infos view large-9 medium-8 columns content">
    <h3><?= h($info->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Descripcion') ?></th>
            <td><?= h($info->descripcion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Valor') ?></th>
            <td><?= h($info->valor) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tipo') ?></th>
            <td><?= h($info->tipo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($info->id) ?></td>
        </tr>
    </table>
</div>
