<?php

/**
 * String Translation plugin for Craft CMS 3
 *
 * Translate your translation strings into different languages.
 *
 * @copyright Copyright (c) 2020 Benjamin Le Bot
 */

namespace benlbot\stringtranslation\controllers;

use Craft;
use craft\helpers\UrlHelper;
use craft\web\Controller;

use yii\web\Response;

use benlbot\stringtranslation\assetbundles\StringTranslationAsset;
use benlbot\stringtranslation\StringTranslation as StringTranslationPlugin;

class DefaultController extends Controller {

    /**
     * Show the dashboard
     *
     * @return Response
     */
    public function actionDashboard(): Response {
        $this->view->registerAssetBundle(StringTranslationAsset::class);

        $templateTitle = Craft::t('string-translation', 'Dashboard');

        $variables['title'] = $templateTitle;
        $variables['crumbs'] = [
            [
                'label' => 'String Translation',
                'url' => UrlHelper::cpUrl('string-translation'),
            ],
        ];

        $variables['baseAssetsUrl'] = Craft::$app->assetManager->getPublishedUrl(
            '@benlbot/stringtranslation/assetbundles/dist',
            true
        );

        return $this->renderTemplate('string-translation/dashboard/_index', $variables);
    }


    /**
     * Show String Translation index page
     *
     * @return Response
     */
    public function actionIndex() {
        $this->view->registerAssetBundle(StringTranslationAsset::class);

        $templateTitle = Craft::t('string-translation', 'String Translation');

        $variables['title'] = $templateTitle;

        $variables['baseAssetsUrl'] = Craft::$app->assetManager->getPublishedUrl(
            '@benlbot/stringtranslation/assetbundles/dist',
            true
        );

        return $this->renderTemplate('string-translation/fields/_index', $variables);
    }


    /**
     * Get all translations
     *
     * @param string $translation
     *
     * @return Response
     */
    public function actionGetTranslations($translation = "") : Response {
        return $this->asJson(StringTranslationPlugin::$plugin->StringTranslation->getTranslations($translation/*, $language, $locale*/));
    }

}
