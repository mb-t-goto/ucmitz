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

namespace BaserCore\Test\TestCase\Controller\Component;

use BaserCore\Test\Factory\ContentFactory;
use Cake\Controller\Controller;
use Cake\Routing\Router;
use BaserCore\Service\PagesService;
use BaserCore\TestSuite\BcTestCase;
use BaserCore\Service\ContentsService;
use Cake\Controller\ComponentRegistry;
use BaserCore\Controller\BcAppController;
use BaserCore\Controller\PagesController;
use BaserCore\Controller\Component\BcFrontContentsComponent;

/**
 * Class BcFrontContentsComponentTest
 *
 * @package BaserCore\Test\TestCase\Controller\Component
 * @property BcFrontContentsComponent $BcFrontContents
 */
class BcFrontContentsComponentTest extends BcTestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'plugin.BaserCore.Contents',
        'plugin.BaserCore.Sites',
        'plugin.BaserCore.Pages',
    ];

    /**
     * set up
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->getRequest('baser/admin');
        $this->ComponentRegistry = new ComponentRegistry(new Controller());
        $this->BcFrontContents = new BcFrontContentsComponent($this->ComponentRegistry);
        $this->PagesService = new PagesService();
        $this->ContentsService = new ContentsService();
    }

    /**
     * Tear Down
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($_SESSION);
        Router::reload();
        parent::tearDown();
    }

    /**
     * test initialize
     */
    public function testInitialize()
    {
        // isContentsPageが設定されないとtrueになる
        $this->BcFrontContents->initialize([]);
        $this->assertTrue($this->BcFrontContents->getConfig('isContentsPage'));

        // isContentsPageが設定されると設定値の通りになる
        $this->BcFrontContents->initialize(['isContentsPage' => false]);
        $this->assertFalse($this->BcFrontContents->getConfig('isContentsPage'));

        // isContentsPageの以外の設定をテスト
        $this->BcFrontContents->initialize(['configKey' => 'configValue']);
        $this->assertEquals('configValue', $this->BcFrontContents->getConfig('configKey'));
    }

    /**
     * testSetupFront
     * コントローラーがPagesControllerの場合
     * ※ NOTE ucmitz: プレビュー時のテスト未完了
     * @return void
     */
    public function testSetupFront()
    {
        $page = $this->PagesService->get(2);
        $request = $this->getRequest()->withParam('Content', $page->content);
        $Controller = new PagesController($request);
        $ComponentRegistry = new ComponentRegistry($Controller);
        $BcFrontContents = new BcFrontContentsComponent($ComponentRegistry);
        $BcFrontContents->setupFront();
        $layout = $Controller->viewBuilder()->getLayout();
        $vars = $Controller->viewBuilder()->getVars();
        $this->assertEquals($this->ContentsService->getParentLayoutTemplate($page->content->id), $layout);
        $this->assertIsString($vars['description']);
        $this->assertIsString($vars['title']);

    }

    public function testGetCrumbs()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
    }

    /**
     * test setLayout
     */
    public function testSetLayout()
    {
        // currentContent の layout_template に値がある場合
        $this->BcFrontContents->setLayout(ContentFactory::get(6));
        $currentLayout = $this->BcFrontContents->getController()->viewBuilder()->getLayout();
        $this->assertEquals('serviceTemplate', $currentLayout);
        // currentContent の layout_template に値がなく、親にはある場合
        $this->BcFrontContents->setLayout(ContentFactory::get(4));
        $currentLayout = $this->BcFrontContents->getController()->viewBuilder()->getLayout();
        $this->assertEquals('default', $currentLayout);
    }
}
