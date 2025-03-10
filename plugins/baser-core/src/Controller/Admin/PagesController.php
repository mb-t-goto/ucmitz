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

namespace BaserCore\Controller\Admin;

use BaserCore\Service\Admin\PagesAdminServiceInterface;
use Cake\Event\EventInterface;
use BaserCore\Utility\BcSiteConfig;
use BaserCore\Service\PagesServiceInterface;
use BaserCore\Service\ContentsServiceInterface;
use BaserCore\Annotation\NoTodo;
use BaserCore\Annotation\Checked;
use BaserCore\Annotation\UnitTest;
use BaserCore\Annotation\Note;
use Cake\ORM\Exception\PersistenceFailedException;

/**
 * PagesController
 */
class PagesController extends BcAdminAppController
{

    /**
     * initialize
     * @checked
     * @noTodo
     * @unitTest
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('BaserCore.BcAdminContents', [
            'entityVarName' => 'page',
            'useForm' => true
        ]);
    }

    /**
     * [ADMIN] 固定ページ情報編集
     *
     * @param PagesServiceInterface $service
     * @param ContentsServiceInterface $contentsService
     * @param int $id ページID
     * @checked
     * @unitTest
     * @noTodo
     */
    public function edit(
        PagesAdminServiceInterface $service,
        ContentsServiceInterface $contentsService,
        int $id
    ) {
        $page = $service->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {

            // EVENT Pages.beforeEdit
            $event = $this->dispatchLayerEvent('beforeEdit', [
                'request' => $this->request,
            ]);
            if ($event !== false) {
                $this->request = ($event->getResult() === null || $event->getResult() === true)? $event->getData('request') : $event->getResult();
            }

            try {
                $page = $service->update($page, $this->request->getData());

                // EVENT Pages.afterEdit
                $this->dispatchLayerEvent('afterEdit', [
                    'request' => $this->request,
                ]);

                $url = $contentsService->getUrl($page->content->url, true, $page->content->site->useSubDomain);
                $this->BcMessage->setSuccess(sprintf(__d('baser', "固定ページ「%s」を更新しました。\n%s"), $page->content->title, rawurldecode($url)));
                return $this->redirect(['action' => 'edit', $id]);
            } catch (PersistenceFailedException $e) {
                $page = $e->getEntity();
                $this->BcMessage->setError(
                    __d('baser', '入力エラーです。内容を修正してください。')
                );
            }  catch (\Exception $e) {
                $this->BcMessage->setError(
                    __d('baser', '入力エラーです。内容を修正してください。' . $e->getMessage())
                );
            }
        }
        $this->set($service->getViewVarsForEdit($page));
    }

    /**
	 * beforeFilter
	 *
     * @param EventInterface $event
     * @checked
     * @noTodo
     * @unitTest
	 */
	public function beforeFilter(EventInterface $event)
	{
		parent::beforeFilter($event);
        if (BcSiteConfig::get('editor') && BcSiteConfig::get('editor') !== 'none') {
            $this->viewBuilder()->addHelpers([BcSiteConfig::get('editor')]);
        }
	}

}
