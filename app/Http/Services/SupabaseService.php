<?php

namespace App\Http\Services;

use Supabase\Storage\StorageClient;
use Supabase\Storage\StorageFile;

class SupabaseService
{
    protected $storage;
    protected $bucket;

    public function __construct()
    {
        $url = config('services.supabase.url');
        $key = config('services.supabase.key');
        $this->bucket = config('services.supabase.bucket');
        
        $this->storage = new StorageClient($url, $key);
    }

    public function uploadImage($file, $path = '')
    {
        try {
            $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $path ? $path . '/' . $fileName : $fileName;

            // Upload file
            $this->storage->upload($this->bucket, $filePath, file_get_contents($file->getRealPath()));

            // Get public URL
            $publicUrl = $this->storage->getPublicUrl($this->bucket, $filePath);

            return [
                'success' => true,
                'file_name' => $fileName,
                'file_path' => $filePath,
                'public_url' => $publicUrl
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function deleteImage($filePath)
    {
        try {
            $this->storage->remove([$this->bucket . '/' . $filePath]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getPublicUrl($filePath)
    {
        return $this->storage->getPublicUrl($this->bucket, $filePath);
    }
}