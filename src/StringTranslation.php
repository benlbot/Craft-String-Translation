<?php
/**
 * String Translation plugin for Craft CMS 3.x
 *
 * Translate your translation strings into different languages.
 *
 * @link      https://github.com/benlbot
 * @copyright Copyright (c) 2020 Benjamin Le Bot
 */

namespace benlbot\stringtranslation;


use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\helpers\UrlHelper;
use craft\web\UrlManager;
use yii\base\Event;

class StringTranslation extends Plugin {
    // Static Properties
    // =========================================================================

    public static $plugin;

    // Public Properties
    // =========================================================================

    public $schemaVersion = '1.0.0';

    public $hasCpSettings = false;

    public $hasCpSection = true;

    // Public Methods
    // =========================================================================
    public function init() {
        parent::init();
        self::$plugin = $this;

        // Register services
        $this->setComponents([
            'StringTranslation' => \benlbot\stringtranslation\services\StringTranslation::class,
        ]);

        // Do something after we're installed
        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    $request = Craft::$app->getRequest();
                    if ($request->isCpRequest) {
                        Craft::$app->getResponse()->redirect(UrlHelper::cpUrl('string-translation/dashboard'))->send();
                    }
                }
            }
        );

        $request = Craft::$app->getRequest();

        // Control panel request
        if ($request->getIsCpRequest() && !$request->getIsConsoleRequest()) {
            // Register CP routes
            Event::on(UrlManager::class, UrlManager::EVENT_REGISTER_CP_URL_RULES, function(RegisterUrlRulesEvent $event) {
              $event->rules = array_merge($event->rules, $this->getCpUrlRules());
            });
        }

        Craft::info(
            Craft::t(
                'string-translation',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    /**
     * @return array
     */
    private function getCpUrlRules() {
      return [
        'string-translation' => 'string-translation/default/index',
        'string-translation/dashboard' => 'string-translation/default/dashboard',
      ];
    }

}
