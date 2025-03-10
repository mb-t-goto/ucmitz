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

/**
 * [ADMIN] ブログ記事作成者一覧ウィジェット設定
 * @var \BaserCore\View\BcAdminAppView $this
 * @var string $key
 * @checked
 * @noTodo
 * @unitTest
 */
$title = __d('baser', 'ブログ投稿者一覧');
$description = __d('baser', 'ブログの投稿者一覧を表示します。');
?>


<?php echo $this->BcAdminForm->label($key . '.view_count', __d('baser', '記事数表示')) ?>&nbsp;
<?php echo $this->BcAdminForm->control($key . '.view_count', [
  'type' => 'radio',
  'options' => $this->BcText->booleanDoList(''),
  'legend' => false,
  'default' => 0
]) ?>
<br>
<?php echo $this->BcAdminForm->label($key . '.blog_content_id', __d('baser', 'ブログ')) ?>&nbsp;
<?php echo $this->BcAdminForm->control($key . '.blog_content_id', [
  'type' => 'select',
  'options' => $this->BcAdminForm->getControlSource('BcBlog.BlogContents.id')
]) ?>
<br>
<small>
  <?php echo __d('baser', 'ブログページを表示している場合は、上記の設定に関係なく、<br>対象ブログのブログ投稿者一覧を表示します。') ?>
</small>
