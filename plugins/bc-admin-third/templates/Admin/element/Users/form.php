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

use BaserCore\Model\Entity\User;
use BaserCore\View\BcAdminAppView;

/**
 * Users Form
 * @var BcAdminAppView $this
 * @var User $user
 * @var array $userGroupList
 * @var bool $isUserGroupEditable
 * @checked
 * @unitTest
 * @noTodo
 */
$this->BcBaser->i18nScript([
  'alertMessage1' => __d('baser', '処理に失敗しました。'),
  'alertMessage2' => __d('baser', '送信先のプログラムが見つかりません。'),
  'confirmMessage1' => __d('baser', '更新内容をログイン情報に反映する為、一旦ログアウトします。よろしいですか？'),
  'confirmMessage2' => __d('baser', '登録されている「よく使う項目」を、このユーザーが所属するユーザーグループの初期設定として登録します。よろしいですか？'),
  'infoMessage1' => __d('baser', '登録されている「よく使う項目」を所属するユーザーグループの初期値として設定しました。'),
]);
$this->BcBaser->js('admin/users/form.bundle', false);
?>


<?php // 自動入力を防止する為のダミーフィールド ?>
<input type="text" name="dummy-email" style="top:-100px;left:-100px;position:fixed;">
<?php $this->BcAdminForm->unlockFields('dummy-email') ?>
<input type="password" name="dummy-pass" autocomplete="off" style="top:-100px;left:-100px;position:fixed;">
<?php $this->BcAdminForm->unlockFields('dummy-pass') ?>


<?php echo $this->BcFormTable->dispatchBefore() ?>

<div class="section">
  <table id="FormTable" class="form-table bca-form-table">
    <?php if ($this->request->getParam('action') == 'edit'): ?>
      <tr>
        <th class="col-head bca-form-table__label"><?php echo $this->BcAdminForm->label('id', 'No') ?></th>
        <td class="col-input bca-form-table__input">
          <?php echo $user->id ?>
          <?php echo $this->BcAdminForm->control('id', ['type' => 'hidden']) ?>
        </td>
      </tr>
    <?php endif ?>
    <tr>
      <th
        class="col-head bca-form-table__label"><?php echo $this->BcAdminForm->label('real_name_1', __d('baser', '名前')) ?>
        &nbsp;<span class="bca-label" data-bca-label-type="required"><?php echo __d('baser', '必須') ?></span></th>
      <td class="col-input bca-form-table__input">
        <small>[<?php echo __d('baser', '姓') ?>
          ]</small> <?php echo $this->BcAdminForm->control('real_name_1', ['type' => 'text', 'size' => 12, 'maxlength' => 255]) ?>
        <small>[<?php echo __d('baser', '名') ?>
          ]</small> <?php echo $this->BcAdminForm->control('real_name_2', ['type' => 'text', 'size' => 12, 'maxlength' => 255]) ?>
        <i class="bca-icon--question-circle bca-help"></i>
        <div class="bca-helptext"><?php echo __d('baser', '「名」は省略する事ができます。') ?></div>
        <?php echo $this->BcAdminForm->error('real_name_1', __d('baser', '姓を入力してください')) ?>
        <?php echo $this->BcAdminForm->error('real_name_2', __d('baser', '名を入力してください')) ?>
      </td>
    </tr>
    <tr>
      <th
        class="col-head bca-form-table__label"><?php echo $this->BcAdminForm->label('nickname', __d('baser', 'ニックネーム')) ?></th>
      <td class="col-input bca-form-table__input">
        <?php echo $this->BcAdminForm->control('nickname', ['type' => 'text', 'size' => 40, 'maxlength' => 255]) ?>
        <i class="bca-icon--question-circle bca-help"></i>
        <div class="bca-helptext"><?php echo __d('baser', 'ニックネームを設定している場合は全ての表示にニックネームが利用されます。') ?></div>
        <?php echo $this->BcAdminForm->error('nickname') ?>
      </td>
    </tr>
    <tr>
      <th
        class="col-head bca-form-table__label"><?php echo $this->BcAdminForm->label('user_group_id', __d('baser', 'グループ')) ?>
        &nbsp;<span class="bca-label" data-bca-label-type="required"><?php echo __d('baser', '必須') ?></span></th>
      <td class="col-input bca-form-table__input">
        <?php if ($isUserGroupEditable): ?>
          <?php echo $this->BcAdminForm->control('user_groups._ids', ['type' => 'multiCheckbox', 'options' => $userGroupList, 'error' => false]); ?>
          <i class="bca-icon--question-circle bca-help"></i>
          <div class="bca-helptext"><?php echo sprintf(__d('baser', 'ユーザーグループごとにコンテンツへのアクセス制限をかける場合などには%sより新しいグループを追加しアクセスルールの設定をおこないます。'), $this->BcBaser->getLink(__d('baser', 'ユーザーグループ管理'), ['controller' => 'user_groups', 'action' => 'index'])) ?></div>
          <?php echo $this->BcAdminForm->error('user_groups') ?>
        <?php else: ?>
          <?php foreach($user->user_groups as $group): ?>
            <span><?php echo h($group->title) ?></span>
          <?php endforeach ?>
        <?php endif ?>
      </td>
    </tr>
    <tr>
      <th class="col-head bca-form-table__label"><?php echo $this->BcAdminForm->label('email', __d('baser', 'Eメール')) ?>
        &nbsp;<span class="bca-label" data-bca-label-type="required"><?php echo __d('baser', '必須') ?></span></th>
      <td class="col-input bca-form-table__input">
        <?php echo $this->BcAdminForm->control('email', ['type' => 'text', 'size' => 40, 'maxlength' => 255]) ?>
        <i class="bca-icon--question-circle bca-help"></i>
        <div class="bca-helptext">
          <?php echo __d('baser', '連絡用メールアドレスを入力します。') ?>
          <br><small>※ <?php echo __d('baser', 'パスワードを忘れた場合の新パスワードの通知先等') ?></small>
        </div>
        <?php echo $this->BcAdminForm->error('email') ?>
      </td>
    </tr>
    <tr>
      <th class="col-head bca-form-table__label">
        <?php echo $this->BcAdminForm->label('name', __d('baser', 'アカウント名')) ?>
      </th>
      <td class="col-input bca-form-table__input">
        <?php echo $this->BcAdminForm->control('name', ['type' => 'text', 'size' => 20, 'maxlength' => 255, 'autofocus' => true]) ?>
        <i class="bca-icon--question-circle bca-help"></i>
        <div class="bca-helptext">
          <?php echo __d('baser', 'アカウント名を設定するとアカウント名とパスワードでログインできるようになります。') ?>
          <?php echo __d('baser', '半角英数字とハイフン、アンダースコアのみで入力してください。') ?>
        </div>
        <?php echo $this->BcAdminForm->error('name') ?>
      </td>
    </tr>

    <tr>
      <th class="col-head bca-form-table__label">
        <?php echo $this->BcAdminForm->label('password_1', __d('baser', 'パスワード')) ?>
        <?php if ($this->request->getParam('action') == 'add'): ?>
          <span class="bca-label" data-bca-label-type="required"><?php echo __d('baser', '必須') ?></span>&nbsp;
        <?php endif; ?>
      </th>
      <td class="col-input bca-form-table__input">
        <?php if ($this->request->getParam('action') == 'edit'): ?><small>
          [<?php echo __d('baser', 'パスワードは変更する場合のみ入力してください') ?>]</small><br/><?php endif ?>
        <?php echo $this->BcAdminForm->control('password_1', ['type' => 'password', 'size' => 20, 'maxlength' => 255, 'autocomplete' => 'off']) ?>
        <?php echo $this->BcAdminForm->control('password_2', ['type' => 'password', 'size' => 20, 'maxlength' => 255, 'autocomplete' => 'off']) ?>
        <i class="bca-icon--question-circle bca-help"></i>
        <div class="bca-helptext">
          <ul>
            <li>
              <?php if ($this->request->getParam('action') == 'edit'): ?>
                <?php echo __d('baser', 'パスワードの変更をする場合は、') ?>
              <?php endif; ?>
              <?php echo __d('baser', '確認のため２回入力してください。') ?></li>
            <li><?php echo __d('baser', '半角英数字(英字は大文字小文字を区別)とスペース、記号(._-:/()#,@[]+=&;{}!$*)のみで入力してください') ?></li>
            <li><?php echo __d('baser', '最低６文字以上で入力してください') ?></li>
          </ul>
        </div>
        <?php echo $this->BcAdminForm->error('password') ?>
      </td>
    </tr>

    <tr>
      <th class="col-head bca-form-table__label">
        <?php echo $this->BcAdminForm->label('status', __d('baser', '利用状態')) ?>
      </th>
      <td class="col-input bca-form-table__input">
        <?php echo $this->BcAdminForm->control('status', ['type' => 'checkbox', 'label' => __d('baser', '有効')]) ?>
        <?php echo $this->BcAdminForm->error('status') ?>
      </td>
    </tr>

    <?php echo $this->BcAdminForm->dispatchAfterForm() ?>

  </table>
</div>

<?php echo $this->BcFormTable->dispatchAfter() ?>


