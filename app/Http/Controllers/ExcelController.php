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
            $worksheet   = $spreadsheet->getActiveSheet();
            $data        = $worksheet->toArray();

            $headers = [];
            $rows    = [];

            if (count($data) > 0) {
                $data = array_filter($data, fn($row) => count(array_filter($row)) > 0);
                $data = array_values($data);

                if (count($data) > 0) {
                    $headers = array_shift($data);
                    $rows    = $data;
                }
            }

            return view('excel-upload', compact('headers', 'rows'));

        } catch (\Exception $e) {
            return back()->with('error', 'Error processing file: ' . $e->getMessage());
        }
    }

    /**
     * Save a selected column as an imploded comma-separated string.
     */
    public function saveColumn(Request $request)
    {
        $request->validate([
            'column_name'  => 'required|string|max:255',
            'excel_column' => 'required|string|max:255',
            'values'       => 'required|array|min:1',
            'values.*'     => 'nullable|string',
        ]);

        $cleanValues  = array_filter($request->values, fn($v) => $v !== null && $v !== '');
        $implodedData = ExcelColumnData::implodeValues(array_values($cleanValues));

        ExcelColumnData::create([
            'column_name'  => $request->column_name,
            'excel_column' => $request->excel_column,
            'data'         => $implodedData,
        ]);

        return redirect()->route('excel.saved')->with('success',
            "Column \"{$request->column_name}\" saved with " . count($cleanValues) . " values."
        );
    }

    /**
     * Show all saved records (exploded for display).
     */
    public function savedData()
    {
        $records = ExcelColumnData::latest()->get()->map(function ($record) {
            $record->values = $record->explodeValues();
            return $record;
        });

        return view('saved-data', compact('records'));
    }

    /**
     * Show the edit form for a single record.
     */
    public function edit($id)
    {
        $record         = ExcelColumnData::findOrFail($id);
        $record->values = $record->explodeValues();
        return view('edit-record', compact('record'));
    }

    /**
     * Update a record — accepts individual value fields,
     * implodes them back into a comma-separated string.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'column_name'  => 'required|string|max:255',
            'excel_column' => 'required|string|max:255',
            'values'       => 'required|array|min:1',
            'values.*'     => 'nullable|string',
        ]);

        $record = ExcelColumnData::findOrFail($id);

        $cleanValues  = array_values(
            array_filter($request->values, fn($v) => $v !== null && trim($v) !== '')
        );
        $implodedData = ExcelColumnData::implodeValues($cleanValues);

        $record->update([
            'column_name'  => $request->column_name,
            'excel_column' => $request->excel_column,
            'data'         => $implodedData,
        ]);

        return redirect()->route('excel.saved')->with('success',
            "Record \"{$record->column_name}\" updated with " . count($cleanValues) . " values."
        );
    }

    /**
     * Delete a saved record permanently.
     */
    public function destroy($id)
    {
        $record = ExcelColumnData::findOrFail($id);
        $name   = $record->column_name;
        $record->delete();

        return redirect()->route('excel.saved')->with('success',
            "Record \"{$name}\" deleted successfully."
        );
    }
}
