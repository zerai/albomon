<?php

declare(strict_types=1);

namespace Albomon\Tests\Core;

use Albomon\Core\Infrastructure\Application\GoogleSheetsClient\GoogleSheetsClient;
use Google_Service_Sheets_UpdateValuesResponse;
use PHPUnit\Framework\TestCase;

class SheetTest extends TestCase
{
    private $sheetClient;

    protected function setUp()
    {
        $this->sheetClient = new GoogleSheetsClient();
    }

    /** @test */
    public function it_can_create(): void
    {
        self::assertInstanceOf(GoogleSheetsClient::class, $this->sheetClient);
    }

    /** @test */
    public function it_can_update_sheet(): void
    {
        self::markTestSkipped();
        $values = [];

        $spreadsheetId = '1qftoGeuqq7sKxxPBR6h8lCtTb-VxdzyzM4F1JtBWelw'; //getenv( "SPREADSHEET_ID" );

        $range = 'Report!A2:F2';

        $value = ['pippo', 'pluto', 'paperino', 'http://feeds.ricostruzionetrasparente.it/albi_pretori/Accumoli_feed.xml'];

        array_push($values, $value);

        $response = $this->sheetClient->updateSheet($values, $range, $spreadsheetId);

        self::assertInstanceOf(Google_Service_Sheets_UpdateValuesResponse::class, $response);
    }
}
