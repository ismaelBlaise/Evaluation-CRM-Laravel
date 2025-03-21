<?php

namespace App\Services\Import;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class ImportCsv
{
    public function importClients(array $clients)
    {
        foreach ($clients as $client) {
            try {
                DB::table('crm2.clients')->insert([
                    'external_id'   => uniqid('cli_'),   
                    'address'       => $client['address'] ?? null,
                    'zipcode'       => $client['zipcode'] ?? null,
                    'city'          => $client['city'] ?? null,
                    'company_name'  => $client['company_name'],
                    'vat'           => $client['vat'] ?? null,
                    'company_type'  => $client['company_type'] ?? null,
                    'client_number' => $client['client_number'] ?? null,
                    'user_id'       => $client['user_id'],
                    'industry_id'   => $client['industry_id'],
                    'created_at'    => Carbon::now(),  
                    'updated_at'    => Carbon::now(),
                ]);
            } catch (\Exception $e) {
                Log::error("Erreur d'import client: " . $e->getMessage());
            }
        }
    }


    public function readCsv(string $filePath): array
    {
        $data = [];
        if (!file_exists($filePath) || !is_readable($filePath)) {
            return $data;
        }

        $header = [];
        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (empty($header)) {
                    $header = $row; 
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        return $data;
    }
}
