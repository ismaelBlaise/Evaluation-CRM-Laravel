<?php

namespace App\Imports;

use App\Models\TempOffer;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Throwable;

class OffersImport implements 
    ToModel, 
    WithHeadingRow, 
    WithValidation,
    SkipsOnError,
    SkipsOnFailure
{
    use SkipsErrors, SkipsFailures;
    
    private $rowNumber = 0;

    public function model(array $row)
    {
        $this->rowNumber++;
        
        // Validation manuelle supplémentaire
        if (empty($row['client_name'])) {
            throw new \Exception("Le nom du client est requis à la ligne {$this->rowNumber}");
        }

        if (empty($row['lead_title'])) {
            throw new \Exception("Le titre du lead est requis à la ligne {$this->rowNumber}");
        }

        if (empty($row['type'])) {
            throw new \Exception("Le type est requis à la ligne {$this->rowNumber}");
        }

        if (empty($row['produit'])) {
            throw new \Exception("Le produit est requis à la ligne {$this->rowNumber}");
        }

        if (!isset($row['prix']) || !is_numeric($row['prix'])) {
            throw new \Exception("Le prix doit être un nombre valide à la ligne {$this->rowNumber}");
        }

        if (!isset($row['quantite']) || !is_numeric($row['quantite'])) {
            throw new \Exception("La quantité doit être un nombre valide à la ligne {$this->rowNumber}");
        }

        return new TempOffer([
            'client_name' => $row['client_name'],
            'lead_title'  => $row['lead_title'],
            'type'        => $row['type'],
            'produit'     => $row['produit'],
            'prix'        => $row['prix'],
            'quantite'    => $row['quantite'],
            'import_row'   => $this->rowNumber
        ]);
    }

    public function rules(): array
    {
        return [
            'client_name' => 'required|string|max:255',
            'lead_title'  => 'required|string|max:255',
            'type'        => 'required|string|max:50',
            'produit'     => 'required|string|max:100',
            'prix'        => 'required|numeric|min:0',
            'quantite'    => 'required|integer|min:1',
        ];
    }

    public function onError(Throwable $e)
    {
        Log::error('Erreur lors de l\'import CSV: '.$e->getMessage());
    }
}
