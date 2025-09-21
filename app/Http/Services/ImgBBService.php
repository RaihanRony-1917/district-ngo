<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImgBBService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.imgbb.com/1/upload';

     public function __construct()
    {
        $this->apiKey = config('services.imgbb.api_key');
        
        // Log for debugging - remove this in production
        Log::info('ImgBB API Key: ' . (!empty($this->apiKey) ? 'Set' : 'Not set'));
    }

    /**
     * Upload image to ImgBB
     */
    public function upload($image, $name = null)
    {
        try {
            // Check if API key is set
            if (empty($this->apiKey)) {
                throw new \Exception('ImgBB API key is not configured');
            }

            // Check if image is a file path, Laravel file object, or base64
            if (is_string($image) && file_exists($image)) {
                $imageContent = base64_encode(file_get_contents($image));
            } elseif (is_object($image) && method_exists($image, 'getRealPath')) {
                $imageContent = base64_encode(file_get_contents($image->getRealPath()));
            } elseif (preg_match('/^data:image\/(\w+);base64,/', $image, $matches)) {
                 $imageContent = preg_replace('/^data:image\/\w+;base64,/', '', $image);
                 $imageContent = preg_replace('/[^A-Za-z0-9+\/]/', '', $imageContent);
            } else {
                throw new \Exception('Invalid image format');
            }

            Log::info('Sending request to ImgBB API');
            
            $response = Http::timeout(30)->asForm()->post($this->baseUrl, [
                'key' => $this->apiKey,
                'image' => $imageContent,
                'name' => $name ?? 'image_' . time(),
            ]);

            // Log the full response for debugging
            Log::info('ImgBB API Response: ', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            $data = $response->json();

            // Check if response has the expected structure
            if (!isset($data['success'])) {
                throw new \Exception('Unexpected response format from ImgBB: ' . $response->body());
            }

            if ($data['success']) {
                return [
                    'success' => true,
                    'id' => $data['data']['id'],
                    'url' => $data['data']['url'],
                    'display_url' => $data['data']['display_url'],
                    'delete_url' => $data['data']['delete_url'],
                    'thumb' => $data['data']['thumb']['url'],
                    'medium' => $data['data']['medium']['url'],
                    'data' => $data['data']
                ];
            }

            return [
                'success' => false,
                'error' => $data['error']['message'] ?? 'Unknown error'
            ];

        } catch (\Exception $e) {
            Log::error('ImgBB Upload Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    /**
     * Delete image from ImgBB using delete URL
     */
    public function delete($deleteUrl)
    {
        try {
            // Extract the deletion token from the URL
            $parts = parse_url($deleteUrl);
            parse_str($parts['query'], $query);
            
            $response = Http::get('https://api.imgbb.com/1/delete/'.$query['delete']);
            
            $data = $response->json();
            
            return $data['success'] ?? false;

        } catch (\Exception $e) {
            Log::error('ImgBB Delete Error: ' . $e->getMessage());
            return false;
        }
    }
}