/**
 * baserCMS :  Based Website Development Project <https://basercms.net>
 * Copyright (c) baserCMS Permission Community <https://basercms.net/community/>
 *
 * @copyright     Copyright (c) baserCMS Permission Community
 * @link          https://basercms.net baserCMS Project
 * @since         5.0.0
 * @license       https://basercms.net/license/index.html MIT License
 */


$(function () {

    const mailContentId = $("#AdminMailMessagesScript").attr('data-mailContentId');
    /**
     * 一括処理実装
     */
    $.bcBatch.init({
        batchUrl: $.bcUtil.apiBaseUrl + 'bc-mail' + '/mail_messages/batch/' + mailContentId + '.json',
    });

});
