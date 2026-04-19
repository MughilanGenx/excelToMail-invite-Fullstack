<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExcelColumnData extends Model
{
    protected $table = 'excel_column_data';

    protected $fillable = [
        'column_name',   // Custom label given by user (the input field name)
        'excel_column',  // Original header from Excel file
        'data',          // Comma-separated string: val1,val2,val3
    ];

    /**
     * Implode an array of values into a comma-separated string for storage.
     * e.g. ['a@b.com', 'c@d.com'] → "a@b.com,c@d.com"
     */
    public static function implodeValues(array $values): string
    {
        return implode(',', $values);
    }

    /**
     * Explode the stored comma-separated string back into an array.
     * e.g. "a@b.com,c@d.com" → ['a@b.com', 'c@d.com']
     */
    public function explodeValues(): array
    {
        return explode(',', $this->data);
    }
}
