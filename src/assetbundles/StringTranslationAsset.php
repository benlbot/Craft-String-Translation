<?php

/**
 * String Translation plugin for Craft CMS 3
 *
 * Translate your translation strings into different languages.
 *

 * @copyright Copyright (c) 2020 Benjamin Le Bot
 */

namespace benlbot\stringtranslation\assetbundles;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class StringTranslationAsset extends AssetBundle {

  // Public Methods
  // =========================================================================

  /**
   * Initializes the bundle.
   */
  public function init()
  {
      // define the path that your publishable resources live
    $this->sourcePath = "@benlbot/stringtranslation/assetbundles/dist";

    // define the dependencies
    $this->depends = [
      CpAsset::class,
    ];

    // define the relative path to CSS/JS files that should be registered with the page
    // when this asset bundle is registered
    $this->js = [
      'js/stringtranslation.js',
    ];

    $this->css = [
      'css/stringtranslation.css',
    ];

    parent::init();
  }

}
