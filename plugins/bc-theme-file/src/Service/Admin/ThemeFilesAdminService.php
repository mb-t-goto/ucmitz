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
use BaserCore\Utility\BcContainerTrait;
use BaserCore\Vendor\Imageresizer;
use BcThemeFile\Form\ThemeFileForm;
use BcThemeFile\Model\Entity\ThemeFile;
use BcThemeFile\Service\ThemeFilesService;
use BcThemeFile\Service\ThemeFoldersServiceInterface;
use BcThemeFile\Utility\BcThemeFileUtil;
use Cake\Filesystem\File;
use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Inflector;

/**
 * ThemeFilesAdminService
 */
class ThemeFilesAdminService extends ThemeFilesService implements ThemeFilesAdminServiceInterface
{

    /**
     * Trait
     */
    use BcContainerTrait;

    /**
     * テーマファイルタイプ
     *
     * @var array
     * @public protected
     */
    protected $_tempalteTypes = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->ThemeFoldersService = $this->getService(ThemeFoldersServiceInterface::class);
    }

    /**
     * テーマファイル一覧用の View 変数を取得する
     *
     * @param array $args
     * @return array
     */
    public function getViewVarsForIndex(array $args)
    {
        // タイトル設定
        $pageTitle = $args['theme'];
        if ($args['plugin']) $pageTitle .= '：' . $args['plugin'];
        if (BcThemeFileUtil::getTemplateTypeName($args['type'])) {
            $pageTitle .= __d('baser', '｜{0}一覧', BcThemeFileUtil::getTemplateTypeName($args['type']));
        }
        return [
            'themeFiles' => $this->ThemeFoldersService->getIndex($args),
            'currentPath' => str_replace(ROOT, '', $args['fullpath']),
            'fullpath' => $args['fullpath'],
            'path' => $args['path'],
            'theme' => $args['theme'],
            'plugin' => $args['plugin'],
            'type' => $args['type'],
            'pageTitle' => $pageTitle
        ];
    }

    /**
     * テーマファイル新規登録画面用の View 変数を取得する
     *
     * @param ThemeFile $entity
     * @param ThemeFileForm $form
     * @param array $args
     * @return array
     */
    public function getViewVarsForAdd(ThemeFile $entity, ThemeFileForm $form, array $args)
    {
        return [
            'themeFileForm' => $form,
            'themeFile' => $entity,
            'currentPath' => str_replace(ROOT, '', dirname($args['fullpath'])) . DS,
            'isWritable' => is_writable($args['fullpath']),
            'theme' => $args['theme'],
            'plugin' => $args['plugin'],
            'type' => $args['type'],
            'path' => $args['path'],
            'pageTitle' => __d('baser', '{0}｜{1}作成', Inflector::camelize($args['theme']), BcThemeFileUtil::getTemplateTypeName($args['type']))
        ];
    }

    /**
     * テーマファイル編集画面用の View 変数を取得する
     *
     * @param ThemeFile $themeFile
     * @param ThemeFileForm $themeFileForm
     * @param array $args
     * @return array
     */
    public function getViewVarsForEdit(ThemeFile $themeFile, ThemeFileForm $themeFileForm, array $args)
    {
        return [
            'themeFileForm' => $themeFileForm,
            'themeFile' => $themeFile,
            'currentPath' => str_replace(ROOT, '', dirname($args['fullpath'])) . DS,
            'isWritable' => is_writable($args['fullpath']),
            'theme' => $args['theme'],
            'plugin' => $args['plugin'],
            'type' => $args['type'],
            'path' => $args['path'],
            'pageTitle' => __d('baser', '{0}｜{1}編集', Inflector::camelize($args['theme']), BcThemeFileUtil::getTemplateTypeName($args['type']))
        ];
    }

    /**
     * テーマファイル表示画面用の View 変数を取得する
     *
     * @param ThemeFile $themeFile
     * @param ThemeFileForm $themeFileForm
     * @param array $args
     * @return array
     */
    public function getViewVarsForView(ThemeFile $themeFile, ThemeFileForm $themeFileForm, array $args)
    {
        return [
            'themeFileForm' => $themeFileForm,
            'themeFile' => $themeFile,
            'currentPath' => str_replace(ROOT, '', dirname($args['fullpath'])) . '/',
            'isWritable' => is_writable($args['fullpath']),
            'theme' => $args['theme'],
            'plugin' => $args['plugin'],
            'type' => $args['type'],
            'path' => $args['path'],
            'pageTitle' => __d('baser', '{0}｜{1}表示', Inflector::camelize($args['theme']), BcThemeFileUtil::getTemplateTypeName($args['type']))
        ];
    }

    /**
     * テーマ内のイメージデータを取得する
     *
     * @param $args
     * @return false|string
     */
    public function getImg($args)
    {
        $contents = ['jpg' => 'jpeg', 'gif' => 'gif', 'png' => 'png'];
        $pathinfo = pathinfo($args['fullpath']);

        if (!BcThemeFileUtil::getTemplateTypeName($args['type']) || !isset($contents[$pathinfo['extension']]) || !file_exists($args['fullpath'])) {
            throw new NotFoundException();
        }

        $file = new File($args['fullpath']);
        if (!$file->open('r')) {
            throw new NotFoundException();
        }

        header("Content-Length: " . $file->size());
        header("Content-type: image/" . $contents[$pathinfo['extension']]);
        return $file->read();
    }

    /**
     * テーマ内の画像のサムネイルイメージのデータを取得する
     *
     * @param array $args
     * @param int $width
     * @param int $height
     * @return false|string
     */
    public function getImgThumb(array $args, int $width, int $height)
    {
        $contents = ['jpeg' => 'jpeg', 'jpg' => 'jpeg', 'gif' => 'gif', 'png' => 'png'];
        $pathinfo = pathinfo($args['fullpath']);

        if (!BcThemeFileUtil::getTemplateTypeName($args['type']) || !isset($contents[strtolower($pathinfo['extension'])]) || !file_exists($args['fullpath'])) {
            throw new NotFoundException();
        }

        header("Content-type: image/" . $contents[strtolower($pathinfo['extension'])]);
        $Imageresizer = new Imageresizer();
        ob_start();
        $Imageresizer->resize($args['fullpath'], null, $width, $height);
        return ob_get_clean();
    }

}
