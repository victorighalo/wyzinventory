<?php

namespace App\Imports;

use App\product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new product([
            'name' => $row[0],
        ]);
    }

    public function batchSize(): int
    {
        return 100;
    }
}
