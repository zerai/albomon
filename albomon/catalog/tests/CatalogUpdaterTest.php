<?php declare(strict_types=1);

namespace Albomon\Tests\Catalog;

use PHPUnit\Framework\TestCase;

class CatalogUpdaterTest extends TestCase
{
    public function testParseACatalogMarkdownFile(): void
    {
        $fileContent = file_get_contents(\dirname(__DIR__) . '/tests/Fixtures/accumoli.md');

        $lines = explode("\n", $fileContent);

        $data = [];
        foreach ($lines as $line) {
            $data[] = $line;
        }

        self::assertNotEmpty($data);
        self::assertContains('title: Accumoli', $data);
        self::assertContains('original: http://www.comune.accumoli.ri.it/albo-pretorio/', $data);
        self::assertContains('rss: http://feeds.ricostruzionetrasparente.it/albi_pretori/Accumoli_feed.xml', $data);
    }
}
