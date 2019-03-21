<?php
/**
 * i18nl10n news Contao bundle
 *
 * @author Web ex Machina <https://www.webexmachina.fr>
 * @package     i18nl10n news
 * @license     MIT
 */

$this->loadDataContainer('tl_content');

$GLOBALS['TL_DCA']['tl_news']['config']['onload_callback'][] = array('tl_news_i18nl10n', 'updatePalettes');
$GLOBALS['TL_DCA']['tl_news']['list']['sorting']['child_record_callback'] = array('tl_news_i18nl10n', 'addTranslations');

$GLOBALS['TL_DCA']['tl_news']['fields']['i18nl10n_language'] = array_merge(
    $GLOBALS['TL_DCA']['tl_page']['fields']['language'],
    array(
        'label'            => &$GLOBALS['TL_LANG']['tl_news']['i18nl10n_language'],
        'exclude'          => true,
        'filter'           => true,
        'inputType'        => 'select',
        'options_callback' => array('tl_content_l10n', 'languageOptions'),
        'reference'        => &$GLOBALS['TL_LANG']['LNG'],
        'eval'             => array(
            'mandatory'          => false,
            'rgxp'               => 'alpha',
            'maxlength'          => 2,
            'nospace'            => true,
            'tl_class'           => 'w50'
        )
    )
);

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Web ex Machina <https://www.webexmachina.fr>
 */
class tl_news_i18nl10n extends tl_news
{
    public function updatePalettes($dc)
    {
        $objNews = \NewsModel::findByPk($dc->id);

        $GLOBALS['TL_DCA']['tl_news']['palettes']['default'] .= ';{i18nl10n_legend},i18nl10n_language';
    }

    /**
     * Add the type of input field
     *
     * @param array $arrRow
     *
     * @return string
     */
    public function addTranslations($arrRow)
    {
        return '<div class="tl_content_left"><strong>' . $arrRow['headline'] . '</strong> <span style="color:#b3b3b3;padding-left:3px">[' . Date::parse(Config::get('datimFormat'), $arrRow['date']) . ']</span><br />'.$GLOBALS['TL_LANG']['MSC']['i18nl10n_fields']['language']['label'][0].' : '.$GLOBALS['TL_LANG']['LNG'][$arrRow['i18nl10n_language']].'</div>';
    }
}
