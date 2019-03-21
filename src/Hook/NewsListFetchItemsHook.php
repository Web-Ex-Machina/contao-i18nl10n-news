<?php

namespace Verstaerker\I18nl10nNewsBundle\Hook;

use Verstaerker\I18nl10nNewsBundle\Model\NewsI18nl10nModel;

/**
 * Class NewsListFetchItemsHook
 * @package Verstaerker\I18nl10nBundle\Hook
 *
 * Implementation of i18nl10n news counting logic.
 */
class NewsListFetchItemsHook
{
    /**
     * Fetch items with the current language
     *
     * @param [NewsArchiveModel] $newsArchives [News feed concerned]
     * @param [Boolean]          $blnFeatured  [True if featured news]
     * @param [Integer]          $limit        [News limit]
     * @param [Integer]          $offset       [News offset]
     * 
     * @return [NewsModel]
     */
    public function fetchItemsByLanguage($newsArchives, $limit, $offset, $blnFeatured)
    {
        return NewsI18nl10nModel::findPublishedByPids($newsArchives, $limit, $offset, $blnFeatured);
    }
}
