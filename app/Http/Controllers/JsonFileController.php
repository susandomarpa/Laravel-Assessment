<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\JsonFile;
  
class JsonFileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function jsonUpload()
    {
        $sheet = JsonFile::first();
        $sheetdata  = $sheet->data;
        // $j_data = json_decode($data.":\"\"]", true);
        // dd( \File::get(public_path('uploads') ,$sheetdata));
        $filePath = public_path('uploads/').$sheetdata; // Replace with your JSON file path

        // Read the JSON file contents
        $jsonn = file_get_contents($filePath);
        // $withoutFirstAndLast = trim($jsonn, '*');
        $json = preg_replace( "/\r|\n/", "", $jsonn );

        // Decode the JSON data
        $data = json_decode($json, true);

        $csvContent = '';
        foreach ($data as $row) {
            $csvContent .= implode(',', $row) . "\n";
        }

        // Set response headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="exported_data.csv"',
        ];

        // Return the CSV response
        // return response($csvContent, 200, $headers);

        $json_files = JsonFile::get();
        return view('jsonUpload',compact('json_files','data','json'));
    }

    public function convertArrayToSheet($id)
    {
        $json_file = JsonFile::find($id);
        $sheetdata  = $json_file->data;
        $filePath = public_path('uploads/').$sheetdata;

        $json = file_get_contents($filePath);

        $data = json_decode($json, true);

        // Example array data
        $dataArray = [
            ['Name', 'Age', 'City'],
            ['John', 30, 'New York'],
            ['Alice', 28, 'London'],
            ['Bob', 35, 'Paris'],
        ];

        // Generate CSV content
        $csvContent = '';
        foreach ($data as $row) {
            $csvContent .= implode(',', $row) . "\n";
        }

        // Set response headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="exported_data.csv"',
        ];

        // Return the CSV response
        return response($csvContent, 200, $headers);
    }

    public function jsonUploadPost(Request $request)
    {
        // dd($request);
        $request->validate([
            'title'=> 'required',
        ]);
    
        $fileName = time(); 
     
        $json_file = new JsonFile();
        $json_file->title = $request->title;
        $request->data->move(public_path('uploads'), $fileName);
        $json_file->data = $fileName;
        if($json_file->save()) {
            return back()
            ->with('success','You have successfully upload Json.');
         }
    }
}