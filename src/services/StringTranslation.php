<?php

/**
 * String Translation plugin for Craft CMS 3
 *
 * Translate your translation strings into different languages.
 *
 * @copyright Copyright (c) 2020 Benjamin Le Bot
 */

namespace benlbot\stringtranslation\services;

use Craft;
use yii\base\Component;
use yii\base\Exception;

class StringTranslation extends Component {

    /**
     * Get all Translations for specific lang and locale
     *
     * @param string $language
     * @param string $locale
     *
     * @return array
     */
    public function getTranslations($filter = "") {
        $translationsPath = Craft::getAlias('@translations');

        if ($translationsPath === false) {
            throw new Exception('There was a problem getting the translations path.');
        }

        $translationFileRegex = $translationsPath.DIRECTORY_SEPARATOR."*";
        $translationFilesPath = glob($translationFileRegex);

        foreach ($translationFilesPath as $filePath) {
            $split=explode('/', $filePath);
            $fileContent = $this->loadMessagesFromFile($filePath.DIRECTORY_SEPARATOR."site.php");

            if(empty($translations)) {
                $translations = array_map(function($e) use ($split) {
                    return array($split[sizeof($split)-1] => $e);
                }, $fileContent);
            } else {
                foreach ($fileContent as $key => $value) {
                    if ( !empty($translations[$key]) ) {
                        $translations[$key][$split[sizeof($split)-1]] = $value;
                    }
                }
            }

            if ( !empty($filter) ){
                foreach ($translations as $key => $value) {
                    if ( strpos($value, $filter) == FALSE ){
                        unset($translations[$key]);
                    }
                }
            }
        }

        return $translations;
    }

    /**
     * Loads the message translation for the specified language or returns null if file doesn't exist.
     *
     * @param string $messageFile path to message file
     * @return array|null array of messages or null if file not found
     */
    protected function loadMessagesFromFile($messageFile) {
        if (is_file($messageFile)) {
            $messages = include $messageFile;
            if (!is_array($messages)) {
                $messages = [];
            }
            return $messages;
        }
        return null;
    }

}