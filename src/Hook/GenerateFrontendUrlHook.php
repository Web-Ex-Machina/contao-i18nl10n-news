<?php

namespace Verstaerker\I18nl10nNewsBundle\Hook;

use Contao\News;
use Verstaerker\I18nl10nNewsBundle\Model\NewsI18nl10nModel;
use Verstaerker\I18nl10nNewsBundle\Classes\I18nl10n;

/**
 * Class GenerateFrontendUrlHook
 * @package Verstaerker\I18nl10nNewsBundle\Hook
 *
 * Create news links to translated pages.
 */
class GenerateFrontendUrlHook
{
    /**
     * Generate the news URL according to another language
     *
     * @param [Array] $arrRow     [Item data]
     * @param [String] $strParams [Additionnal params]
     * @param [String] $strUrl    [Current URL generated]
     *
     * @return mixed|string
     *
     * @throws \Exception
     */
    public function generateFrontendUrl($arrRow, $strParams, $strUrl)
    {   
        // @todo : function not conclusive, need to find a better way
        return $strUrl;

        global $objPage;
dump($strUrl);
        // Skip if the page is not the current one (the purpose here is just to translate the current news url)
        if ($objPage->alias != $arrRow["alias"] || $GLOBALS['I18NL10N']['NEWSURLFOUND']) {
            return $strUrl;
        }
dump($GLOBALS['TL_HOOKS']['generateFrontendUrl']);
dump("NOT SKIPPED");
        // Set the item from the auto_item parameter
        if (!isset($_GET['items']) && \Config::get('useAutoItem') && isset($_GET['auto_item'])) {
            \Input::setGet('items', \Input::get('auto_item'));
        }

        $objCurrentItem = \NewsModel::findByIdOrAlias(\Input::get('items'));


        // If no item or item found has a different language than the current one
        if ($objCurrentItem && !$GLOBALS['I18NL10N']['NEWSURLFOUND']) {

            // Append language if existing and forced (by i18nl10n)
            $language     = empty($arrRow['language']) || empty($arrRow['forceRowLanguage'])
                ? $GLOBALS['TL_LANGUAGE']
                : $arrRow['language'];

            // @todo : find a better logic to find matching translations, here, we just assume news posted at the same hours are linked
            $objItem = NewsI18nl10nModel::findTranslation($objCurrentItem, $language);

            if ($objItem) {
                // Set a global to avoid hook loop
                $GLOBALS['I18NL10N']['NEWSURLFOUND'] = true;
                $strUrl = preg_replace('/'.$GLOBALS['TL_LANGUAGE'].'/', $language, \News::generateNewsUrl($objItem), 1);
            }
        }

        return $strUrl;
    }
}
