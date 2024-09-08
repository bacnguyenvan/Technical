<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate(
            ['file' => 'required']
        );

        if($request->hasFile('file')) {
            $file = $request->file;
            $fileName = $file->getClientOriginalName();
            $file->move('uploads/', $fileName);

            return "success";
        }

    }

    public function uploadChunk(Request $request)
    {
        $fileName = $request->input('file_name');
        $chunkIndex = $request->input('chunk_index');
        $totalChunks = $request->input('total_chunks');

        $file = $request->file('file');

        $tempDir = storage_path('app/uploads/' . $fileName);

        // Create the temporary directory if it doesn't exist
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        // Save the chunk
        $file->move($tempDir, $chunkIndex);

        // Check if all chunks have been uploaded
        if (count(scandir($tempDir)) - 2 == $totalChunks) {
            $this->combineChunks($tempDir, $fileName);

            // Optionally, you can delete the chunks and the temporary directory
            array_map('unlink', glob("$tempDir/*"));
            rmdir($tempDir);
        }

        return response()->json(['status' => 'Chunk uploaded']);
    }

    private function combineChunks($tempDir, $fileName)
    {
        $path = 'app/public/uploads/';

        if (!file_exists(storage_path($path))) {
            mkdir(storage_path($path), 0777, true);
        }

        $finalPath = storage_path($path . $fileName);

        if (is_file($finalPath)) {
            $finalFile = fopen($finalPath, 'r');
        } else {
            $finalFile = fopen($finalPath, 'w');
        }

        $chunkFiles = glob("$tempDir/*");
        natsort($chunkFiles);

        foreach ($chunkFiles as $chunkFile) {
            $chunkData = file_get_contents($chunkFile);
            fwrite($finalFile, $chunkData);
        }

        fclose($finalFile);
    }
}
