<?php
/**
 * i18nl10n news Contao bundle
 *
 * @author Web ex Machina <https://www.webexmachina.fr>
 * @package     i18nl10n news
 * @license     MIT
 */

/**
 * Add frontend hooks
 */
if ("FE" === TL_MODE) {
    $GLOBALS['TL_HOOKS']['newsListCountItems'][] = array('Verstaerker\I18nl10nNewsBundle\Hook\NewsListCountItemsHook', 'countItemsByLanguage');
    $GLOBALS['TL_HOOKS']['newsListFetchItems'][] = array('Verstaerker\I18nl10nNewsBundle\Hook\NewsListFetchItemsHook', 'fetchItemsByLanguage');
    $GLOBALS['TL_HOOKS']['generateFrontendUrl'][] = array('Verstaerker\I18nl10nNewsBundle\Hook\GenerateFrontendUrlHook', 'generateFrontendUrl');
}

/**
 * Override tl_news associated model
 */
$GLOBALS['TL_MODELS'][\Verstaerker\I18nl10nNewsBundle\Model\NewsI18nl10nModel::getTable()] = '\Verstaerker\I18nl10nNewsBundle\Model\NewsI18nl10nModel';
