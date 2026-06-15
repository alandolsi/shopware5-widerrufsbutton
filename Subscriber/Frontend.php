<?php

namespace LandolsiWiderrufsbutton\Subscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Enlight\Event\SubscriberInterface;
use Enlight_Controller_Action;
use Enlight_Event_EventArgs;

/**
 * Registers the plugin's template directory for the frontend so that:
 *  - the footer button (template extension of frontend/index/footer_typ_1.tpl) is rendered, and
 *  - the /widerruf controller can find its own templates.
 */
class Frontend implements SubscriberInterface
{
    /**
     * @var string Absolute path to the plugin root directory.
     */
    private $pluginDir;

    public function __construct()
    {
        // Subscriber/Frontend.php -> dirname() = plugin root.
        $this->pluginDir = dirname(__DIR__);
    }

    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch_Frontend' => 'onPreDispatchFrontend',
            'Theme_Compiler_Collect_Plugin_Css' => 'onCollectCss',
        ];
    }

    public function onPreDispatchFrontend(Enlight_Event_EventArgs $args)
    {
        /** @var Enlight_Controller_Action $controller */
        $controller = $args->getSubject();
        $controller->View()->addTemplateDir($this->pluginDir . '/Resources/views/');
    }

    public function onCollectCss()
    {
        $collection = new ArrayCollection();
        $collection->add($this->pluginDir . '/Resources/views/frontend/_public/src/css/widerruf.css');

        return $collection;
    }
}
