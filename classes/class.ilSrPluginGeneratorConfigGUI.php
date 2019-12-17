<?php

require_once __DIR__ . "/../vendor/autoload.php";

use srag\DIC\SrPluginGenerator\DICTrait;
use srag\Plugins\SrPluginGenerator\Config\ConfigFormGUI;
use srag\Plugins\SrPluginGenerator\Utils\SrPluginGeneratorTrait;

/**
 * Class ilSrPluginGeneratorConfigGUI
 *
 * @author studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ilSrPluginGeneratorConfigGUI extends ilPluginConfigGUI
{

    use DICTrait;
    use SrPluginGeneratorTrait;
    const PLUGIN_CLASS_NAME = ilSrPluginGeneratorPlugin::class;
    const CMD_CONFIGURE = "configure";
    const CMD_UPDATE_CONFIGURE = "updateConfigure";
    const LANG_MODULE = "config";
    const TAB_CONFIGURATION = "configuration";


    /**
     * ilSrPluginGeneratorConfigGUI constructor
     */
    public function __construct()
    {

    }


    /**
     * @inheritDoc
     */
    public function performCommand(/*string*/ $cmd)/*:void*/
    {
        $this->setTabs();

        $next_class = self::dic()->ctrl()->getNextClass($this);

        switch (strtolower($next_class)) {
            default:
                $cmd = self::dic()->ctrl()->getCmd();

                switch ($cmd) {
                    case self::CMD_CONFIGURE:
                    case self::CMD_UPDATE_CONFIGURE:
                        $this->{$cmd}();
                        break;

                    default:
                        break;
                }
                break;
        }
    }


    /**
     *
     */
    protected function setTabs()/*: void*/
    {
        self::dic()->tabs()->addTab(self::TAB_CONFIGURATION, self::plugin()->translate("configuration", self::LANG_MODULE), self::dic()->ctrl()
            ->getLinkTargetByClass(self::class, self::CMD_CONFIGURE));

        self::dic()->locator()->addItem(ilSrPluginGeneratorPlugin::PLUGIN_NAME, self::dic()->ctrl()->getLinkTarget($this, self::CMD_CONFIGURE));
    }


    /**
     * @return ConfigFormGUI
     */
    protected function getConfigForm() : ConfigFormGUI
    {
        $form = new ConfigFormGUI($this);

        return $form;
    }


    /**
     *
     */
    protected function configure()/*: void*/
    {
        self::dic()->tabs()->activateTab(self::TAB_CONFIGURATION);

        $form = $this->getConfigForm();

        self::output()->output($form);
    }


    /**
     *
     */
    protected function updateConfigure()/*: void*/
    {
        self::dic()->tabs()->activateTab(self::TAB_CONFIGURATION);

        $form = $this->getConfigForm();

        if (!$form->storeForm()) {
            self::output()->output($form);

            return;
        }

        ilUtil::sendSuccess(self::plugin()->translate("configuration_saved", self::LANG_MODULE), true);

        self::dic()->ctrl()->redirect($this, self::CMD_CONFIGURE);
    }
}
