<?php
namespace App\Http\Controllers;

use App\Http\Services\SupaGPTService;
use Illuminate\Http\Request;

class SupabaseTestController extends Controller
{
    public function uploadSample(SupaGPTService $svc, Request $request)
    {
        // For automated test, create a tiny temp file if no file sent.
        if ($request->hasFile('file')) {
            $file = $request->file('file');
        } else {
            // Create a small temp file for testing
            $tmp = tmpfile();
            fwrite($tmp, "Supabase test " . now());
            $meta = stream_get_meta_data($tmp);
            $tmpPath = $meta['uri'];
            $file = new \Illuminate\Http\File($tmpPath);
        }

        $res = $svc->upload($file, 'test-uploads', true);

        return response()->json([
            'ok' => true,
            'path' => $res['path'] ?? null,
            'url' => $res['url'] ?? null
        ]);
    }

    public function deleteSample(SupaGPTService $svc, Request $request)
    {
        $path = $request->input('path');
        if (! $path) {
            return response()->json(['ok' => false, 'message' => 'path required'], 422);
        }
        $deleted = $svc->delete($path);
        return response()->json(['ok' => $deleted]);
    }
}
