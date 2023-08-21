<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Models\ZipStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ZipController extends Controller
{

    public function saveVideo(Request $request)
    {
        $file = new ZipStore();
        if ($request->hasFile('files')) {
            $videoFile = $request->file('files');
            $videoPath = time() . '.' . $videoFile->extension();
            $videoFile->move('files', $videoPath);
        }
        $file->file = $videoPath;
        $file->user_name = $request->user_name ? $request->user_name : 'test User';
        $file->save();
        return response()->json([
            'success' => true,
            'message' => 'No files uploaded.',
            'video' => asset('files/' . $videoPath)
        ]);
    }

    public function getVideo()
    {
        $files = ZipStore::all();
        foreach ($files as $file) {
            $file['file'] = asset('files/' . $file->file);
        }
        return response()->json([
            'success' => true,
            'message' => 'No files uploaded.',
            'videos' => $files,
        ]);
    }

    public function getSingleVideo(Request $request)
    {
        $file = ZipStore::find($request->id);
        return response()->json([
            'success' => true,
            'message' => 'No files uploaded.',
            'video' => asset('files/' . $file->file)
        ]);
    }

}
