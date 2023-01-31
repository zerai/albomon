<?php declare(strict_types=1);

namespace Albomon\Tests\Catalog;

use Albomon\Catalog\Adapter\MarkdownToCatalogItemConverter;
use PHPUnit\Framework\TestCase;

class ConvertMarkdownToCatalogItemTest extends TestCase
{
    public function testCreateWithEmptyStringThrowException(): void
    {
        self::expectException(\InvalidArgumentException::class);

        MarkdownToCatalogItemConverter::createFromMarkdownContent('');
    }

    /**
     * @dataProvider getMarkdownContentDataProvider
     */
    public function testConvertTitle(string $markdownContent)
    {
        $converter = MarkdownToCatalogItemConverter::createFromMarkdownContent($markdownContent);

        self::assertEquals('Accumoli', $converter->getTitle());
    }

    /**
     * @dataProvider getMarkdownContentDataProvider
     */
    public function testConvertOriginalAlboUrl(string $markdownContent)
    {
        $converter = MarkdownToCatalogItemConverter::createFromMarkdownContent($markdownContent);

        self::assertEquals('http://www.comune.accumoli.ri.it/albo-pretorio/', $converter->getOriginalAlboUrl());
    }

    /**
     * @dataProvider getMarkdownContentDataProvider
     */
    public function testConvertRssUrl(string $markdownContent)
    {
        $converter = MarkdownToCatalogItemConverter::createFromMarkdownContent($markdownContent);

        self::assertEquals('http://feeds.ricostruzionetrasparente.it/albi_pretori/Accumoli_feed.xml', $converter->getRssFeedUrl());
    }

    /**
     * @dataProvider getMarkdownContentDataProvider
     */
    public function testConvertAsArray(string $markdownContent)
    {
        $expectedResult = [
            'title' => 'Accumoli',
            'original' => 'http://www.comune.accumoli.ri.it/albo-pretorio/',
            'rss' => 'http://feeds.ricostruzionetrasparente.it/albi_pretori/Accumoli_feed.xml',
        ];

        $converter = MarkdownToCatalogItemConverter::createFromMarkdownContent($markdownContent);

        self::assertEquals($expectedResult, $converter->asArray());
    }

    public function getMarkdownContentDataProvider(): array
    {
        $data = '---
# Inserisci il nome della Pubblica Amministrazione
title: Accumoli
tags: ["tci","rt"]
original: http://www.comune.accumoli.ri.it/albo-pretorio/
rss: http://feeds.ricostruzionetrasparente.it/albi_pretori/Accumoli_feed.xml
twitter:
facebook:
telegram:
pdf:
author: Alessio Cimarelli <alessio.cimarelli@ondata.it> (http://www.ricostruzionetrasparente.it)
repo: https://github.com/RicostruzioneTrasparente/rt-scrapers/
regione: Lazio
provincia: Rieti
istat: 057001
ipa: c_a019
lat: 42.694444
lng: 13.2475
image: c_a019.png
accessible: true
standard: true
official: false
---
';
        return [
            [$data],
        ];
    }
}
