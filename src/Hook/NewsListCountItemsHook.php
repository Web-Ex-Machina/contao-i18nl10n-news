<?php

namespace Verstaerker\I18nl10nNewsBundle\Hook;

use Verstaerker\I18nl10nNewsBundle\Model\NewsI18nl10nModel;

/**
 * Class NewsListCountItemsHook
 * 
 * @package Verstaerker\I18nl10nBundle\Hook
 *
 * Implementation of i18nl10n news counting logic.
 */
class NewsListCountItemsHook
{
    /**
     * Count items with the current language
     *
     * @param [Array]          $newsArchives [Array of PID concerned]
     * @param [Boolean]        $blnFeatured  [True if featured news]
     * @param [ModuleNewsList] $objModule    [Newslist module]
     *
     * @return [Integer]                     [News matching the language]
     */
    public function countItemsByLanguage($newsArchives, $blnFeatured, $objModule)
    {
        return NewsI18nl10nModel::countPublishedByPids($newsArchives, $blnFeatured);
    }
}
