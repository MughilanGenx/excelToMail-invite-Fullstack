<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\ExcelColumnData;

class ExcelController extends Controller
{
    public function index()
    {
        return view('excel-upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        $file = $request->file('excel_file');

        try {
            $spreadsheet = IOFactory::load($file->getRealPath());
            $worksheet = $spreadsheet->getActiveSheet();
            $data = $worksheet->toArray();

            $headers = [];
            $rows = [];

            if (count($data) > 0) {
                // Filter out fully empty rows
                $data = array_filter($data, function ($row) {
                    return count(array_filter($row)) > 0;
                });

                $data = array_values($data);

                if (count($data) > 0) {
                    $headers = array_shift($data);
                    $rows = $data;
                }
            }

            return view('excel-upload', compact('headers', 'rows'));

        } catch (\Exception $e) {
            return back()->with('error', 'Error processing file: ' . $e->getMessage());
        }
    }

    /**
     * Save a selected column's values as a comma-separated string (implode).
     * Input:  column_index (which column), column_name (custom label), rows_data (JSON)
     * Output: stored as "val1,val2,val3" in the `data` text column.
     */
    public function saveColumn(Request $request)
    {
        $request->validate([
            'column_name'  => 'required|string|max:255',
            'excel_column' => 'required|string|max:255',
            'values'       => 'required|array|min:1',
            'values.*'     => 'nullable|string',
        ]);

        // Filter out blanks, then implode into comma-separated string
        $cleanValues = array_filter($request->values, fn($v) => $v !== null && $v !== '');
        $implodedData = ExcelColumnData::implodeValues(array_values($cleanValues));

        ExcelColumnData::create([
            'column_name'  => $request->column_name,
            'excel_column' => $request->excel_column,
            'data'         => $implodedData,
        ]);

        return redirect()->route('excel.saved')->with('success',
            "Column \"{$request->column_name}\" saved successfully with " . count($cleanValues) . " values."
        );
    }

    /**
     * Show all saved column records.
     * Explodes the stored comma-separated string back into an array for display.
     */
    public function savedData()
    {
        $records = ExcelColumnData::latest()->get()->map(function ($record) {
            $record->values = $record->explodeValues(); // explode back to array
            return $record;
        });

        return view('saved-data', compact('records'));
    }
}
