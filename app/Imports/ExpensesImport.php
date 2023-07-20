<?php

namespace App\Imports;

use App\Models\Expenses;
use App\Models\Spent;
use Maatwebsite\Excel\Concerns\ToModel;

class ExpensesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Expenses([
            "date" => $row[0],
            "spent_id" => Spent::getSpentId($row[1]),
            "amount" => $row[2],
        ]);
    }
}
