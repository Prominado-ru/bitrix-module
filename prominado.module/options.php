<?php

use Bitrix\Main\Config\Option;
use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

Loc::loadMessages(__FILE__);
Loader::includeSharewareModule('prominado.module');

$post = Context::getCurrent()->getRequest()->getPostList()->toArray();
if (is_array($post['settings']) && (count($post['settings']) > 0)) {
    foreach ($post['settings'] as $name => $val) {
        if ($val) {
            Option::set('prominado.module', $name, $val);
        } else {
            Option::delete('prominado.module', ['name' => $name]);
        }
    }
}

$tabs = [];
$tabs[] = [
    'DIV' => 'settings',
    'TAB' => Loc::getMessage('PROMINADO_MODULE_OPTIONS_TAB_1'),
    'ICON' => '',
    'TITLE' => Loc::getMessage('PROMINADO_MODULE_OPTIONS_TAB_1')
];

$tabControl = new CAdminTabControl('tabControl', $tabs);
$tabControl->Begin();

echo '<form name="prominado.module" method="POST" action="' . $APPLICATION->GetCurPage() . '?mid=prominado.modile&lang=' . LANGUAGE_ID . '" enctype="multipart/form-data">' .
    bitrix_sessid_post();
$tabControl->BeginNextTab();

?>
    <tr class="heading">
        <td colspan="2"><?= Loc::getMessage('PROMINADO_MODULE_OPTIONS_TAB_1_TITLE'); ?></td>
    </tr>
    <tr>
        <td width="40%" nowrap="" class="adm-detail-content-cell-l">
            <label><?= Loc::getMessage('PROMINADO_MODULE_OPTIONS_TAB_1_FIELD'); ?>:</label>
        </td>
        <td width="60%" class="adm-detail-content-cell-r">
            <input type="text" id="field" name="settings[field]"
                   value="<?= Option::get('prominado.module', 'field'); ?>"/>
        </td>
    </tr>
<?
$tabControl->Buttons();

echo '<input type="hidden" name="update" value="Y" />';
echo '<input type="submit" name="save" value="' . Loc::getMessage('PROMINADO_MODULE_OPTIONS_SAVE') . '" class="adm-btn-save" />';
echo '<input type="reset" name="reset" value="' . Loc::getMessage('PROMINADO_MODULE_OPTIONS_RESET') . '" />';
echo '</form>';

$tabControl->End();