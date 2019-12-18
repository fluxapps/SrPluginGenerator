<?php

namespace srag\Plugins\SrPluginGenerator\Menu;

use ILIAS\GlobalScreen\Scope\MainMenu\Provider\AbstractStaticPluginMainMenuProvider;
use ilSrPluginGeneratorPlugin;
use srag\DIC\SrPluginGenerator\DICTrait;
use srag\Plugins\SrPluginGenerator\Generator\PluginGeneratorGUI;
use srag\Plugins\SrPluginGenerator\Utils\SrPluginGeneratorTrait;

/**
 * Class Menu
 *
 * @package srag\Plugins\SrPluginGenerator\Menu
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 *
 * @since   ILIAS 5.4
 */
class Menu extends AbstractStaticPluginMainMenuProvider
{

    use DICTrait;
    use SrPluginGeneratorTrait;
    const PLUGIN_CLASS_NAME = ilSrPluginGeneratorPlugin::class;


    /**
     * @inheritdoc
     */
    public function getStaticTopItems() : array
    {
        return [
            $this->mainmenu->topLinkItem($this->if->identifier(ilSrPluginGeneratorPlugin::PLUGIN_ID))
                ->withTitle(self::plugin()->translate("title", PluginGeneratorGUI::LANG_MODULE))
                ->withAction(self::srPluginGenerator()->generator()->getLink())
                ->withAvailableCallable(function () : bool {
                    return self::plugin()->getPluginObject()->isActive();
                })
                ->withVisibilityCallable(function () : bool {
                    return self::srPluginGenerator()->currentUserHasRole();
                })
        ];
    }


    /**
     * @inheritdoc
     */
    public function getStaticSubItems() : array
    {
        return [];
    }
}
