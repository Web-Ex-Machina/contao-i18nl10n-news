<?php

namespace Verstaerker\I18nl10nNewsBundle\Model;

class NewsI18nl10nModel extends \NewsModel
{
    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_news';

    public static function findTranslation($objItem, $strLanguage)
    {
        $t = static::$strTable;

        $arrColumns = array("$t.pid = ".$objItem->pid);
        $arrColumns[] = "$t.i18nl10n_language = '".$strLanguage."'";
        $arrColumns[] = "$t.time = '".$objItem->time."'";

        $arrOptions['limit']  = 1;

        return static::findBy($arrColumns, null, $arrOptions);
    }

    /**
     * Find published news items by their parent ID
     *
     * @param array   $arrPids     An array of news archive IDs
     * @param boolean $blnFeatured If true, return only featured news, if false, return only unfeatured news
     * @param integer $intLimit    An optional limit
     * @param integer $intOffset   An optional offset
     * @param array   $arrOptions  An optional options array
     *
     * @return Model\Collection|NewsModel[]|NewsModel|null A collection of models or null if there are no news
     */
    public static function findPublishedByPids($arrPids, $blnFeatured=null, $intLimit=0, $intOffset=0, array $arrOptions=array())
    {
        if (empty($arrPids) || !\is_array($arrPids)) {
            return null;
        }

        $t = static::$strTable;
        $arrColumns = array("$t.pid IN(" . implode(',', array_map('\intval', $arrPids)) . ")");
        $arrColumns[] = "($t.i18nl10n_language = '' OR $t.i18nl10n_language = '".$GLOBALS['TL_LANGUAGE']."')";

        if ($blnFeatured === true) {
            $arrColumns[] = "$t.featured='1'";
        } elseif ($blnFeatured === false) {
            $arrColumns[] = "$t.featured=''";
        }

        // Never return unpublished elements in the back end, so they don't end up in the RSS feed
        if (!BE_USER_LOGGED_IN || TL_MODE == 'BE') {
            $time = \Date::floorToMinute();
            $arrColumns[] = "($t.start='' OR $t.start<='$time') AND ($t.stop='' OR $t.stop>'" . ($time + 60) . "') AND $t.published='1'";
        }

        if (!isset($arrOptions['order'])) {
            $arrOptions['order']  = "$t.date DESC";
        }

        $arrOptions['limit']  = $intLimit;
        $arrOptions['offset'] = $intOffset;

        return static::findBy($arrColumns, null, $arrOptions);
    }

    /**
     * Count published news items by their parent ID
     *
     * @param array   $arrPids     An array of news archive IDs
     * @param boolean $blnFeatured If true, return only featured news, if false, return only unfeatured news
     * @param array   $arrOptions  An optional options array
     *
     * @return integer The number of news items
     */
    public static function countPublishedByPids($arrPids, $blnFeatured=null, array $arrOptions=array())
    {
        if (empty($arrPids) || !\is_array($arrPids)) {
            return 0;
        }

        $t = static::$strTable;
        $arrColumns = array("$t.pid IN(" . implode(',', array_map('\intval', $arrPids)) . ")");
        $arrColumns[] = "($t.i18nl10n_language = '' OR $t.i18nl10n_language = '".$GLOBALS['TL_LANGUAGE']."')";

        if ($blnFeatured === true) {
            $arrColumns[] = "$t.featured='1'";
        } elseif ($blnFeatured === false) {
            $arrColumns[] = "$t.featured=''";
        }

        if (!static::isPreviewMode($arrOptions)) {
            $time = \Date::floorToMinute();
            $arrColumns[] = "($t.start='' OR $t.start<='$time') AND ($t.stop='' OR $t.stop>'" . ($time + 60) . "') AND $t.published='1'";
        }

        return static::countBy($arrColumns, null, $arrOptions);
    }
}
