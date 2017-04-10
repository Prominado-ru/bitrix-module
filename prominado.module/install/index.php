<?

use \Bitrix\Main\Localization\Loc;

class prominado_module extends CModule
{
    var $MODULE_ID = "prominado.module";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $PARTNER_NAME;
    var $PARTNER_URI;
    var $MODULE_CSS;

    function prominado_module()
    {
        $arModuleVersion = array();
        $path = str_replace("\\", "/", __FILE__);
        $path = substr($path, 0, strlen($path) - strlen("/index.php"));
        Loc::loadMessages($path . "/install.php");
        include($path . "/version.php");
        if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        }
        $this->MODULE_NAME = Loc::getMessage("PROMINADO_MODULE_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("PROMINADO_MODULE_MODULE_DESCRIPTION");
        $this->PARTNER_NAME = Loc::getMessage("PROMINADO_MODULE_MODULE_PARTNER");
        $this->PARTNER_URI = Loc::getMessage("PROMINADO_MODULE_MODULE_PARTNER_WEBSITE");
    }

    function DoInstall()
    {
		$eventManager = \Bitrix\Main\EventManager::getInstance();
		$eventManager->registerEventHandler("main", "OnBuildGlobalMenu", $this->MODULE_ID, "\\Prominado\\Module\\Core", "onGlobalMenu");
		
		RegisterModule($this->MODULE_ID);
        CAdminMessage::ShowNote(Loc::getMessage("PROMINADO_MODULE_MODULE_INSTALLED"));

        return true;
    }

    function DoUninstall()
    {
		$eventManager = \Bitrix\Main\EventManager::getInstance();
		$eventManager->unRegisterEventHandler("main", "OnBuildGlobalMenu", $this->MODULE_ID, "\\Prominado\\Module\\Core", "onGlobalMenu");
		
        UnRegisterModule($this->MODULE_ID);
		CAdminMessage::ShowNote(Loc::getMessage("PROMINADO_MODULE_MODULE_UNINSTALLED"));
        return true;
    }
}
?>