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
use yii\base\InvalidConfigException;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller {

    /**
     * Show String Translation index page
     *
     * @return Response
     */
    public function actionIndex(string $siteHandle = null) {
        $variables = [];
        // Get the site to edit
        $siteId = $this->getSiteIdFromHandle($siteHandle);
        $pluginName = "String Translation";
        // Asset bundle
        try {
            $this->view->registerAssetBundle(StringTranslationAsset::class);
        } catch (InvalidConfigException $e) {
            Craft::error($e->getMessage(), __METHOD__);
        }

        // Enabled sites
        $this->setMultiSiteVariables($siteHandle, $siteId, $variables);
        $variables['controllerHandle'] = 'dashboard';

        $templateTitle = Craft::t('string-translation', $pluginName);
        $siteHandleUri = Craft::$app->isMultiSite ? '/'.$siteHandle : '';

        $variables['title'] = $templateTitle;
        $variables['crumbs'] = [
            [
                'label' => $templateTitle,
                'url' => UrlHelper::cpUrl('string-translation'.$siteHandleUri),
            ],
        ];

        $variables['baseAssetsUrl'] = Craft::$app->assetManager->getPublishedUrl(
            '@benlbot/stringtranslation/assetbundles/dist',
            true
        );

        return $this->renderTemplate('string-translation/stringtranslation/_index', $variables);
    }


    /**
     * Get all translations
     *
     * @param string $translation
     *
     * @return Response
     */
    public function actionGetTranslations($translation = "") : Response {
        return $this->asJson(StringTranslationPlugin::$plugin->StringTranslation->getTranslations($translation));
    }

    /**
     * Update all translations
     *
     * @param string $translation
     *
     * @return Response
     */
    public function actionUpdateTranslations() : Response {
        $this->requirePostRequest();

        $request = Craft::$app->getRequest();

        $translations = json_decode($request->getRawBody());

        return $this->asJson(StringTranslationPlugin::$plugin->StringTranslation->updateTranslations($translations));
    }

    /**
     * Return a siteId from a siteHandle
     *
     * @param string $siteHandle
     *
     * @return int|null
     * @throws NotFoundHttpException
     */
    protected function getSiteIdFromHandle($siteHandle)
    {
        // Get the site to edit
        if ($siteHandle !== null) {
            $site = Craft::$app->getSites()->getSiteByHandle($siteHandle);
            if (!$site) {
                throw new NotFoundHttpException('Invalid site handle: '.$siteHandle);
            }
            $siteId = $site->id;
        } else {
            $siteId = Craft::$app->getSites()->currentSite->id;
        }

        return $siteId;
    }

    /**
     * @param string $siteHandle
     * @param        $siteId
     * @param        $variables
     *
     * @throws \yii\web\ForbiddenHttpException
     */
    protected function setMultiSiteVariables($siteHandle, &$siteId, array &$variables, $element = null)
    {
        // Enabled sites
        $sites = Craft::$app->getSites();
        if (Craft::$app->getIsMultiSite()) {
            // Set defaults based on the section settings
            $variables['enabledSiteIds'] = [];
            $variables['siteIds'] = [];

            /** @var Site $site */
            foreach ($sites->getEditableSiteIds() as $editableSiteId) {
                $variables['enabledSiteIds'][] = $editableSiteId;
                $variables['siteIds'][] = $editableSiteId;
            }

            // Make sure the $siteId they are trying to edit is in our array of editable sites
            if (!\in_array($siteId, $variables['enabledSiteIds'], false)) {
                if (!empty($variables['enabledSiteIds'])) {
                    $siteId = reset($variables['enabledSiteIds']);
                } else {
                    $this->requirePermission('editSite:'.$siteId);
                }
            }
        }

        // Set the currentSiteId and currentSiteHandle
        $variables['currentSiteId'] = empty($siteId) ? Craft::$app->getSites()->currentSite->id : $siteId;
        $variables['currentSiteHandle'] = empty($siteHandle)
            ? Craft::$app->getSites()->currentSite->handle
            : $siteHandle;

        // Page title
        $variables['showSites'] = (
            Craft::$app->getIsMultiSite() &&
            \count($variables['enabledSiteIds'])
        );

        if ($variables['showSites']) {
            $variables['sitesMenuLabel'] = Craft::t(
                'site',
                $sites->getSiteById((int)$variables['currentSiteId'])->name
            );
        } else {
            $variables['sitesMenuLabel'] = '';
        }
    }

}
