<?php
/**
 * baserCMS :  Based Website Development Project <https://basercms.net>
 * Copyright (c) baserCMS Users Community <https://basercms.net/community/>
 *
 * @copyright       Copyright (c) baserCMS Users Community
 * @link            https://basercms.net baserCMS Project
 * @package         Baser.View
 * @since           baserCMS v 0.1.0
 * @license         https://basercms.net/license/index.html
 */

/**
 * [ADMIN] アップデート
 */
?>


<div class="corner10 panel-box bca-panel-box section">
  <?php echo $this->BcAdminForm->create('Updater', ['url' => ['action' => $this->request->action]]) ?>
  <p><?php echo $this->BcAdminForm->label('Updater.plugin', __d('baser', 'タイプ')) ?>
    &nbsp;<?php echo $this->BcAdminForm->control('Updater.plugin', ['type' => 'select', 'options' => $plugins, 'empty' => __d('baser', 'コア')]) ?></p>
  <p><?php echo $this->BcAdminForm->label('Updater.version', __d('baser', 'バージョン')) ?>
    &nbsp;<?php echo $this->BcAdminForm->control('Updater.version', ['type' => 'text']) ?></p>
  <?php echo $this->BcAdminForm->end(['label' => __d('baser', '実行'), 'class' => 'button']) ?>
</div>


<?php if ($log): ?>
  <div class="corner10 panel-box bca-panel-box section" id="UpdateLog">
    <h2><?php echo __d('baser', 'アップデートログ') ?></h2>
    <?php echo $this->BcAdminForm->textarea('Updater.log', [
      'value' => $log,
      'style' => 'width:99%;height:200px;font-size:12px',
      'readonly' => 'readonly'
    ]); ?>
  </div>
<?php endif; ?>
