<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Google\Client;
use Google\Service\Sheets;
use Google_Client;
use Google_Service_Sheets;
use Exception;
use Log;

use App\Publisher\ChatGPT;

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
		$client = $this->getGoogleClient();
		$service = new Google_Service_Sheets($client);
		$spreadsheetId = config('api.google_sheet_id');
        $sheetName = "gender equality";
		$range = "$sheetName!A2:A19";

		// get values
		$response = $service->spreadsheets_values->get($spreadsheetId, $range);
		$values = $response->getValues();
        $valueStr = '';
        foreach ($values as $innerArray) {
            $valueStr .= $innerArray[0] . ",";
        }
        $inputs = trim($valueStr, ',');
        
        // chatGPT
        $chatGPT = new ChatGPT();
        $promt = " Cho inputs " . $inputs . ' tôi muốn bạn translate từ vựng cho example sentence chứa từ vựng này, kết quả là 1 mảng chứa danh sách các mảng con theo pattern sau: [["vietnamese translate", "example", "/pronunciation/", "vocabulary type"], [], ]' ;
        $res = $chatGPT->askToChatGpt($promt);

        $data = $this->formatData($res);
        
        $range = "$sheetName!B2:E19"; // Adjust the range as needed
        $this->updateSheetValues($spreadsheetId, $data[0], $range, $service);

		echo "SUCCESS \n";
    }

    public function getGoogleClient()
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Sheets API PHP Quickstart');
        $client->setScopes(Google_Service_Sheets::SPREADSHEETS);
        $client->setAuthConfig(storage_path('app/public/client_secret.json'));
        $client->setAccessType('offline');

        $tokenPath = storage_path('app/public/token.json');
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        if ($client->isAccessTokenExpired()) {
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN));

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }

            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }

        return $client;
    }

    public function formatData($inputString)
    {
        \Log::info($inputString);
        if(!is_array($inputString))
        {
            // Clean up the string to make it a valid JSON format
            $inputString = trim($inputString, " \t\n\r\0\x0B\" ");
            $inputString = str_replace(["\n", "'"], ["", '"'], $inputString); // Replace newline characters and single quotes
            $inputString = str_replace("], [", "],[", $inputString); // Fix the array element separators
            $inputString = "[$inputString]"; // Enclose in square brackets

            // Decode the JSON string into a PHP array
            $data = json_decode($inputString, true);

            return $data;
        }

        // Check for JSON decoding errors
        return $inputString;
    }

    public function updateSheetValues($spreadsheetId, $data, $range, $service)
    {
        try {

            if(empty($data)) throw new Exception("Data is null\n");
            
            $body = new \Google_Service_Sheets_ValueRange([
                'values' => $data
            ]);

            $params = [
                'valueInputOption' => 'RAW'
            ];

            $result = $service->spreadsheets_values->update(
                $spreadsheetId,
                $range,
                $body,
                $params
            );

            printf("%d cells updated.", $result->getUpdatedCells());
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
