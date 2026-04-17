<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
                // The first row is the header
                // We filter out fully empty rows to be safe
                $data = array_filter($data, function($row) {
                    return count(array_filter($row)) > 0; // retain rows that have at least one non-empty cell
                });
                
                // Re-key the array after filtering
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
}
