<?php
namespace App\Http\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SupaGPTService
{
    protected string $disk = 'supabase';

    /**
     * Upload a file and return the stored path (to save in DB).
     *
     * @param UploadedFile $file
     * @param string|null $folder e.g. "uploads/blogs"
     * @param bool $public
     * @return string path you can store in DB
     */
    public function upload(UploadedFile $file, ?string $folder = null, bool $public = true): string
    {
        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                    . '-' . time()
                    . '.' . $file->getClientOriginalExtension();

        $path = trim(($folder ? $folder . '/' : '') . $filename, '/');

        Storage::disk($this->disk)->putFileAs($folder ?? '', $file, $filename, $public ? 'public' : 'private');

        return $path;
    }

    /**
     * Update (replace) a file: deletes oldPath (if given) and uploads new file.
     *
     * @param UploadedFile $file
     * @param string|null $folder
     * @param string|null $oldPath path stored in DB
     * @param bool $public
     * @return string new path to store in DB
     */
    public function update(UploadedFile $file, ?string $folder = null, ?string $oldPath = null, bool $public = true): string
    {
        if ($oldPath) {
            $this->delete($oldPath);
        }

        return $this->upload($file, $folder, $public);
    }

    /**
     * Delete a file by its path (as stored in DB).
     *
     * @param string $path
     * @return bool
     */
    public function delete(string $path): bool
    {
        if (Storage::disk($this->disk)->exists($path)) {
            return Storage::disk($this->disk)->delete($path);
        }
        return true;
    }

    /**
     * Optionally: get a public URL from a stored path.
     *
     * @param string $path
     * @return string|null
     */
    public function url(string $path): ?string
    {
        try {
            if(config('app.supa_public')) {
                return config('filesystems.disks.supabase.public_endpoint') .'/'. $path;
            }
            return Storage::disk($this->disk)->url($path);
        } catch (\Throwable $e) {
            return null;
        }
    }
}
