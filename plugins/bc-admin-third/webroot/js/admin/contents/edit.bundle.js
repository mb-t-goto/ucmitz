!function(e){var t={};function n(o){if(t[o])return t[o].exports;var r=t[o]={i:o,l:!1,exports:{}};return e[o].call(r.exports,r,r.exports,n),r.l=!0,r.exports}n.m=e,n.c=t,n.d=function(e,t,o){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:o})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var o=Object.create(null);if(n.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)n.d(o,r,function(t){return e[t]}.bind(null,r));return o},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=16)}({16:function(e,t){
/**
 * baserCMS :  Based Website Development Project <https://basercms.net>
 * Copyright (c) baserCMS Users Community <https://basercms.net/community/>
 *
 * @copyright       Copyright (c) baserCMS Users Community
 * @link            https://basercms.net baserCMS Project
 * @since           baserCMS v 4.0.0
 * @license         https://basercms.net/license/index.html
 */
$((function(){window.setTimeout((function(){window.scrollTo(0,1)}),100);var e=$("#AdminContentsEditScript").attr("data-fullurl"),t=$("#AdminContentsEditScript").attr("data-previewurl"),n=$.parseJSON($("#AdminContentsEditScript").attr("data-current")),o=$.parseJSON($("#AdminContentsEditScript").attr("data-settings"));$("form #ContentsFormTabs").tabs().show(),$("#BtnSave").click((function(){$.bcUtil.showLoader()})),$("#BtnPreview").click((function(){window.open("","preview");var n=$(this).parents("form"),o=n.attr("action"),r="default",i=t;return $("#ContentAliasId").val()&&(r="alias"),"draft"==$("#DraftModeContentsTmp").val()&&(r="draft"),i.match(/\?/)?i+="&url="+e+"&preview="+r:i+="?url="+e+"&preview="+r,n.attr("target","preview"),n.attr("action",i),n.submit(),n.attr("target","_self"),n.attr("action",o),$.get("/baser/baser-core/bc_form/get_token?requestview=false",(function(e){$('input[name="_csrfToken"]').val(e)})),!1})),$("#BtnDelete").click((function(){var e=bcI18n.contentsEditConfirmMessage1;if($("#ContentAliasId").val()&&(e=bcI18n.contentsEditConfirmMessage2),confirm(e)){$("#BtnDelete").prop("disabled",!0),$.bcUtil.showLoader();var t=$(this).parents("form");t.attr("action",$.bcUtil.adminBaseUrl+"baser-core/contents/delete"),t.submit()}return!1})),$(".create-alias").click((function(){var e=$(this).attr("data-site-id"),t=$("#SiteDisplayName"+e).val(),o=$("#SiteTargetUrl"+e).val(),r={Content:{title:n.Content.name,plugin:n.Content.plugin,type:n.Content.type,site_id:e,alias_id:n.Content.id,entity_id:n.Content.entity_id,url:n.Content.url}};return confirm(bcI18n.contentsEditConfirmMessage3.sprintf(t))&&$.bcToken.check((function(){return $.ajax({url:$.bcUtil.apiBaseUrl+"baser-core/contents/exists_content_by_url",headers:{Authorization:$.bcJwt.accessToken},type:"POST",data:{data:{url:o},_csrfToken:$.bcToken.key},beforeSend:function(){$.bcUtil.showLoader()},success:function(e){e?($.bcUtil.hideLoader(),$.bcUtil.showAlertMessage(bcI18n.contentsEditAlertMessage2)):($.bcToken.key=null,$.bcToken.check((function(){return $.ajax({url:$.bcUtil.apiBaseUrl+"baser-core/contents/add/1",headers:{Authorization:$.bcJwt.accessToken},type:"POST",data:$.extend(r,{_csrfToken:$.bcToken.key}),dataType:"json",beforeSend:function(){$("#Waiting").show()},success:function(e){$.bcUtil.showNoticeMessage(bcI18n.contentsEditInfoMessage1),location.href=$.baseUrl()+"/"+$.bcUtil.adminPrefix+"/contents/edit_alias/"+e.id},error:function(e,t,n){$.bcUtil.hideLoader(),$.bcUtil.showAlertMessage(bcI18n.contentsEditAlertMessage1),$.bcToken.key=null}})}),{useUpdate:!1,hideLoader:!1}))},error:function(e,t,n){$.bcUtil.hideLoader(),$.bcUtil.showAlertMessage(bcI18n.contentsEditAlertMessage1)}})}),{useUpdate:!1,hideLoader:!1}),!1})),$(".create-copy").click((function(){var e=$(this).attr("data-site-id"),t=$("#SiteDisplayName"+e).val(),r=$("#SiteTargetUrl"+e).val(),i={title:n.Content.title,siteId:e,parentId:n.Content.parent_id,contentId:n.Content.id,entityId:n.Content.entity_id,url:n.Content.url};return confirm(bcI18n.contentsEditConfirmMessage4.sprintf(t))&&$.bcToken.check((function(){return $.ajax({url:$.bcUtil.apiBaseUrl+"baser-core/contents/exists_content_by_url",headers:{Authorization:$.bcJwt.accessToken},type:"POST",data:{data:{url:r},_csrfToken:$.bcToken.key},beforeSend:function(){$.bcUtil.showLoader()},success:function(e){e?($.bcUtil.hideLoader(),$.bcUtil.showAlertMessage(bcI18n.contentsEditAlertMessage3)):($.bcToken.key=null,$.bcToken.check((function(){return $.ajax({url:o[n.Content.type].url.copy,headers:{Authorization:$.bcJwt.accessToken},type:"POST",data:$.extend(i,{_csrfToken:$.bcToken.key}),dataType:"json",beforeSend:function(){$("#Waiting").show()},success:function(e){$.bcUtil.showNoticeMessage(bcI18n.contentsEditInfoMessage2),location.href=o[n.Content.type].url.edit+"/"+e.entity_id},error:function(e,t,n){$.bcUtil.hideLoader(),$.bcToken.key=null,$.bcUtil.showAlertMessage(bcI18n.contentsEditAlertMessage4)}})}),{useUpdate:!1,hideLoader:!1}))},error:function(e,t,n){$.bcUtil.hideLoader(),$.bcUtil.showAlertMessage(bcI18n.contentsEditAlertMessage4)}})}),{useUpdate:!1,hideLoader:!1}),!1})),$("#ContentModifiedDate").val()||($("#ContentModifiedDateDate").val(getNowDate()),$("#ContentModifiedDateTime").val(getNowTime()))}))}});
//# sourceMappingURL=edit.bundle.js.map