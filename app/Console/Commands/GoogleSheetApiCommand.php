<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Google\Client;
use Google\Service\Sheets;
use Exception;

class GoogleSheetApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'google:sheet_api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();
        $client->setApplicationName('Google Sheets API PHP');
        $client->setScopes([Sheets::SPREADSHEETS]);
        $client->setAuthConfig(storage_path('app/client_secret.json'));
        $service = new Sheets($client);

        $spreadsheetId = config('api.google_sheet_id');

        try {
            // Get spreadsheet details
            $spreadsheet = $service->spreadsheets->get($spreadsheetId);
            $sheets = $spreadsheet->getSheets();
        
            // Check if the 4th sheet exists
            if (isset($sheets[3])) { // Arrays are zero-indexed, so 4th sheet is at index 3
                $sheet = $sheets[3];
                $sheetTitle = $sheet->getProperties()->getTitle();
                
                // Get values from the 4th sheet
                $range = $sheetTitle . '!A1:Z1000'; // Adjust the range as needed
                $response = $service->spreadsheets_values->get($spreadsheetId, $range);
                $values = $response->getValues();
        
                if (empty($values)) {
                    print "No data found in the 4th sheet.\n";
                } else {
                    print "Data from the 4th sheet:\n";
                    foreach ($values as $row) {
                        echo implode(", ", $row), "\n";
                    }
                }
            } else {
                echo "Sheet number 4 does not exist.\n";
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
		
    }

}
