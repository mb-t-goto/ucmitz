<?php
// TODO ucmitz  : コード確認要
return;
/**
 * baserCMS :  Based Website Development Project <https://basercms.net>
 * Copyright (c) baserCMS Users Community <https://basercms.net/community/>
 *
 * @copyright       Copyright (c) baserCMS Users Community
 * @link            https://basercms.net baserCMS Project
 * @package         Baser.Test.Case.Routing.Filter
 * @since           baserCMS v 4.0.9
 * @license         https://basercms.net/license/index.html
 */

App::uses('BcRedirectMainSiteFilter', 'Routing/Filter');

/**
 * Class BcRedirectMainSiteFilterTest
 *
 * @package Baser.Test.Case.Routing.Filter
 * @property  BcRedirectMainSiteFilter $BcRedirectMainSiteFilter
 */
class BcRedirectMainSiteFilterTest extends BcTestCase
{

    /**
     * set up
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * beforeDispatch Event
     */
    public function testBeforeDispatch()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
    }

}
