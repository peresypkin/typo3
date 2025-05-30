<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace TYPO3\CMS\Seo\Tests\Functional\XmlSitemap;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Frontend\Tests\Functional\SiteHandling\AbstractTestCase;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;

abstract class AbstractXmlSitemapPagesTestCase extends AbstractTestCase
{
    /**
     * @var array
     */
    protected const LANGUAGE_PRESETS = [
        'EN' => ['id' => 0, 'title' => 'English', 'locale' => 'en_US.UTF8'],
        'FR' => ['id' => 1, 'title' => 'French', 'locale' => 'fr_FR.UTF8'],
        'DE' => ['id' => 2, 'title' => 'German', 'locale' => 'de_DE.UTF8'],
    ];

    protected array $coreExtensionsToLoad = ['seo'];

    protected function setUp(): void
    {
        parent::setUp();
        $this->importCSVDataSet(__DIR__ . '/../Fixtures/pages-sitemap.csv');
        $this->setUpFrontendRootPage(
            1,
            [
                'constants' => ['EXT:seo/Configuration/TypoScript/XmlSitemap/constants.typoscript'],
                'setup' => ['EXT:seo/Configuration/TypoScript/XmlSitemap/setup.typoscript'],
            ]
        );

        $this->writeSiteConfiguration(
            'website-local',
            $this->buildSiteConfiguration(1, 'http://localhost/'),
            [
                $this->buildDefaultLanguageConfiguration('EN', '/'),
                $this->buildLanguageConfiguration('FR', '/fr/'),
                $this->buildLanguageConfiguration('DE', '/de/', ['FR']),
            ]
        );
    }

    protected function getResponse(string $uri = 'http://localhost/'): ResponseInterface
    {
        return $this->executeFrontendSubRequest(
            (new InternalRequest($uri))->withQueryParameters([
                'id' => 1,
                'type' => 1533906435,
                'tx_seo[sitemap]' => 'pages',
            ])
        );
    }
}
