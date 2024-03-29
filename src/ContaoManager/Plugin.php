<?php

namespace Verstaerker\I18nl10nNewsBundle\ContaoManager;

use Verstaerker\I18nl10nNewsBundle\VerstaerkerI18nl10nNewsBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

/**
 * Plugin for the Contao Manager.
 *
 * @author Web ex Machina <https://www.webexmachina.fr>
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(VerstaerkerI18nl10nNewsBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class])
                ->setReplace(['i18nl10n_news']),
        ];
    }
}
