<?php declare(strict_types=1);

namespace Albomon\Tests\Catalog;

use Albomon\Catalog\Adapter\MarkdownToCatalogItemConverter;
use PHPUnit\Framework\TestCase;

class ConvertMarkdownToCatalogItemTest extends TestCase
{
    public function testCreateWithEmptyStringThrowException(): void
    {
        self::markTestIncomplete('implementare validazione nel constructor');
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

    /**
     * @dataProvider getMarkdownContentDataProvider
     */
    public function testConversion(string $markdownContent)
    {
        $catalogItem = [];

        $lines = explode("\n", $markdownContent);

        foreach ($lines as $line) {
            if ('---' === $line) {
                continue;
            }
            $x = explode(':', $line);

            if (2 === \count($x)) {
                [$lineKey, $lineValue] = $x;
            } elseif (3 === \count($x)) {
                [$lineKey, $lineValue1, $lineValue2] = $x;
            } else {
                continue;
            }

            if ('title' === $lineKey) {
                $catalogItem['title'] = trim($lineValue);
            }

            if ('original' === $lineKey) {
                $catalogItem['original'] = trim($lineValue1) . ':' . trim($lineValue2);
            }

            if ('rss' === $lineKey) {
                $catalogItem['rss'] = trim($lineValue1) . ':' . trim($lineValue2);
            }
        }

        self::assertIsArray($catalogItem);
        self::assertArrayHasKey('title', $catalogItem);
        self::assertEquals('Accumoli', $catalogItem['title']);
        self::assertArrayHasKey('original', $catalogItem);
        self::assertEquals('http://www.comune.accumoli.ri.it/albo-pretorio/', $catalogItem['original']);
        self::assertArrayHasKey('rss', $catalogItem);
        self::assertEquals('http://feeds.ricostruzionetrasparente.it/albi_pretori/Accumoli_feed.xml', $catalogItem['rss']);
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
