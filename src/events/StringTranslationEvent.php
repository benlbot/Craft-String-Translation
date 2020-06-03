<?php

/**
 * String Translation plugin for Craft CMS 3
 *
 * Translate your translation strings into different languages.
 *
 * @copyright Copyright (c) 2020 Benjamin Le Bot
 */

namespace benlbot\stringtranslation\events;

use yii\base\Event;

class StringTranslationEvent extends Event {
    // Properties
    // =========================================================================

    /**
     * @var string Translation key
     */
    public $translationKey;

    /**
     * @var int Translation Value
     */
    public $translationValue;

}