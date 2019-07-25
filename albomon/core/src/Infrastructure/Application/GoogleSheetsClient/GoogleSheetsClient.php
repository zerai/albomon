<?php

declare(strict_types=1);

namespace Albomon\Core\Infrastructure\Application\GoogleSheetsClient;

use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;

class GoogleSheetsClient
{
    protected $service;

    /**
     * GoogleSheetsClient constructor.
     */
    public function __construct()
    {
        $apiKey = getenv('GOOGLE_API_KEY');

        $client = new Google_Client();
        $client->setAccessType('offline');
        $client->useApplicationDefaultCredentials();
        $client->setDeveloperKey($apiKey);
        $client->setSubject(getenv('GOOGLE_SERVICE_ACCOUNT_NAME'));
        $client->setScopes(['https://www.googleapis.com/auth/spreadsheets']);

        $this->service = new Google_Service_Sheets($client);
    }

    public function updateSheet($values, $range, $spreadsheetId)
    {
        $requestBody = new Google_Service_Sheets_ValueRange([
            'values' => $values,
        ]);

        $params = [
            'valueInputOption' => 'USER_ENTERED',
        ];

        return $this->service->spreadsheets_values->update($spreadsheetId, $range, $requestBody, $params);
    }
}
