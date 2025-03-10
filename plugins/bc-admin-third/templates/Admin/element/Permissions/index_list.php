<?php
/**
 * baserCMS :  Based Website Development Project <https://basercms.net>
 * Copyright (c) NPO baser foundation <https://baserfoundation.org/>
 *
 * @copyright     Copyright (c) NPO baser foundation
 * @link          https://basercms.net baserCMS Project
 * @since         5.0.0
 * @license       https://basercms.net/license/index.html MIT License
 */

use BaserCore\View\BcAdminAppView;

/**
 * [ADMIN] アクセスルール一覧
 *
 * @var BcAdminAppView $this
 * @var \Cake\ORM\ResultSet $permissions
 * @var \BaserCore\Model\Entity\UserGroup $currentUserGroup
 * @checked
 * @unitTest
 * @noTodo
 */

$this->BcListTable->setColumnNumber(6);
?>


<div class="bca-data-list__top">
  <?php if ($this->BcBaser->isAdminUser()): ?>
    <div>
      <?php echo $this->BcAdminForm->control('batch', [
        'type' => 'select',
        'options' => [
          'unpublish' => __d('baser', '無効'),
          'publish' => __d('baser', '有効'),
          'delete' => __d('baser', '削除'),
        ],
        'empty' => __d('baser', '一括処理')
      ]) ?>
      <?php echo $this->BcAdminForm->button(__d('baser', '適用'), ['id' => 'BtnApplyBatch', 'disabled' => 'disabled', 'class' => 'bca-btn', 'data-bca-btn-size' => 'lg']) ?>
    </div>
  <?php endif ?>
</div>


<table class="list-table sort-table bca-table-listup" id="ListTable">
  <thead class="bca-table-listup__thead">
  <tr>
    <th class="list-tool bca-table-listup__thead-th  bca-table-listup__thead-th--select"><?php // 一括選択 ?>
      <?php if ($this->BcBaser->isAdminUser()): ?>
        <?php echo $this->BcAdminForm->control('checkall', ['type' => 'checkbox', 'label' => __d('baser', '一括選択')]) ?>
      <?php endif; ?>
      <?php if ($this->request->getQuery('sortmode')): ?>
        <?php $this->BcBaser->link('<i class="bca-btn-icon-text" data-bca-btn-type="draggable"></i>' . __d('baser', 'ノーマル'), [$currentUserGroup->id, '?' => ['sortmode' => 0]], ['escape' => false]) ?>
      <?php else: ?>
        <?php $this->BcBaser->link('<i class="bca-btn-icon-text" data-bca-btn-type="draggable"></i>' . __d('baser', '並び替え'), [$currentUserGroup->id, '?' => ['sortmode' => 1]], ['escape' => false]) ?>
      <?php endif ?>
    </th>
    <th class="bca-table-listup__thead-th">No</th>
    <th class="bca-table-listup__thead-th"><?php echo __d('baser', 'タイプ') ?></th>
    <th class="bca-table-listup__thead-th"><?php echo __d('baser', 'ルールグループ') ?></th>
    <th class="bca-table-listup__thead-th">
      <?php echo __d('baser', 'ルール名') ?><br><?php echo __d('baser', 'URL設定') ?>
    </th>
    <th class="bca-table-listup__thead-th"><?php echo __d('baser', '権限') ?></th>
    <?php echo $this->BcListTable->dispatchShowHead() ?>
    <th class="bca-table-listup__thead-th"><?php echo __d('baser', '登録日') ?><br><?php echo __d('baser', '更新日') ?>
    </th>
    <th class="bca-table-listup__thead-th"><?php echo __d('baser', 'アクション') ?></th>
  </tr>
  </thead>
  <tbody>
  <?php if ($permissions->count()): ?>
    <?php $count = 1 ?>
    <?php foreach($permissions as $permission): ?>
      <?php $this->BcBaser->element('Permissions/index_row', ['permission' => $permission, 'count' => $count]) ?>
      <?php $count++ ?>
    <?php endforeach; ?>
  <?php else: ?>
    <tr>
      <td colspan="<?php echo $this->BcListTable->getColumnNumber() ?>">
        <p class="no-data"><?php echo __d('baser', 'データが見つかりませんでした。') ?></p>
      </td>
    </tr>
  <?php endif; ?>
  </tbody>
</table>
