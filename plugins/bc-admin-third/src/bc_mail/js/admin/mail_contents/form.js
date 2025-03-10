/**
 * baserCMS :  Based Website Development Project <https://basercms.net>
 * Copyright (c) NPO baser foundation <https://baserfoundation.org/>
 *
 * @copyright     Copyright (c) NPO baser foundation
 * @link          https://basercms.net baserCMS Project
 * @since         5.0.0
 * @license       https://basercms.net/license/index.html MIT License
 */

$(function () {

    $('input[name="sender_1_"]').click(mailContentSender1ClickHandler);

    $("#EditLayout").click(function () {
        if (confirm(bcI18n.confirmMessage1.sprintf($("#layout-template").val()))) {
            $("#edit-layout").val(1);
            $("#edit-mail-form").val('');
            $("#edit-mail").val('');
            $("#MailContentAdminEditForm").submit();
        }
    });
    $("#EditForm").click(function () {
        if (confirm(bcI18n.confirmMessage2.sprintf($("#form-template").val()))) {
            $("#edit-layout").val('');
            $("#edit-mail-form").val(1);
            $("#edit-mail").val('');
            $("#MailContentAdminEditForm").submit();
        }
    });
    $("#EditMail").click(function () {
        if (confirm(bcI18n.confirmMessage3.sprintf($("#mail-template").val()))) {
            $("#edit-layout").val('');
            $("#edit-mail-form").val('');
            $("#edit-mail").val(1);
            $("#MailContentAdminEditForm").submit();
        }
    });

    let sender1 = $("#sender-1");
    sender1.hide();
    if ($('input[name="sender_1_"]:checked').val() === undefined) {
        if (sender1.val() !== '') {
            $("#sender-1-1").prop('checked', true);
        } else {
            $("#sender-1-0").prop('checked', true);
        }
    }
    mailContentSender1ClickHandler();

    function mailContentSender1ClickHandler() {
        if ($('input[name="sender_1_"]:checked').val() === '1') {
            sender1.slideDown(100);
        } else {
            sender1.slideUp(100);
        }
    }

});


