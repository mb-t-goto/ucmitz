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

namespace BcThemeFile\Service\Admin;

use BaserCore\Annotation\NoTodo;
use BaserCore\Annotation\Checked;
use BaserCore\Annotation\UnitTest;
use BcThemeFile\Form\ThemeFolderForm;
use BcThemeFile\Model\Entity\ThemeFolder;
use BcThemeFile\Service\ThemeFoldersService;
use Cake\Utility\Inflector;

/**
 * ThemeFoldersAdminService
 */
class ThemeFoldersAdminService extends ThemeFoldersService implements ThemeFoldersAdminServiceInterface
{

    /**
     * フォルダ編集画面用の View 変数を取得する
     *
     * @param ThemeFolder $entity
     * @param ThemeFolderForm $form
     * @param array $args
     * @return array
     * @checked
     * @noTodo
     */
    public function getViewVarsForEdit(ThemeFolder $entity, ThemeFolderForm $form, array $args)
    {
        return [
            'themeFolderForm' => $form,
            'themeFolder' => $entity,
            'currentPath' => str_replace(ROOT, '', dirname($args['fullpath'])) . DS,
            'isWritable' => is_writable($args['fullpath']),
            'theme' => $args['theme'],
            'plugin' => $args['plugin'],
            'type' => $args['type'],
            'path' => $args['path'],
            'pageTitle' => __d('baser', '{0}｜フォルダ編集', Inflector::camelize($args['theme']))
        ];
    }

    /**
     * フォルダ新規登録画面用の View 変数を取得する
     *
     * @param ThemeFolder $entity
     * @param ThemeFolderForm $form
     * @param array $args
     * @return array
     * @checked
     * @noTodo
     */
    public function getViewVarsForAdd(ThemeFolder $entity, ThemeFolderForm $form, array $args)
    {
        return [
            'themeFolderForm' => $form,
            'themeFolder' => $entity,
            'currentPath' => str_replace(ROOT, '', dirname($args['fullpath'])) . DS,
            'isWritable' => is_writable($args['fullpath']),
            'theme' => $args['theme'],
            'plugin' => $args['plugin'],
            'type' => $args['type'],
            'path' => $args['path'],
            'pageTitle' => __d('baser', '{0}｜フォルダ作成', Inflector::camelize($args['theme']))
        ];
    }

    /**
     * フォルダ表示画面用の View 変数を取得する
     *
     * @param ThemeFolder $entity
     * @param ThemeFolderForm $form
     * @param array $args
     * @return array
     * @checked
     * @noTodo
     */
    public function getViewVarsForView(ThemeFolder $entity, ThemeFolderForm $form, array $args)
    {
        return [
            'themeFolderForm' => $form,
            'themeFolder' => $entity,
            'currentPath' => str_replace(ROOT, '', dirname($args['fullpath'])) . DS,
            'isWritable' => is_writable($args['fullpath']),
            'theme' => $args['theme'],
            'plugin' => $args['plugin'],
            'type' => $args['type'],
            'path' => $args['path'],
            'pageTitle' => __d('baser', '{0}｜フォルダ表示', Inflector::camelize($args['theme']))
        ];
    }

}
