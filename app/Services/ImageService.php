<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageService
{
    protected $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
    }

    /**
     * Upload and process an image
     *
     * @param UploadedFile $file The uploaded file instance
     * @param string $folder The folder to store the image in
     * @param integer $width The width to resize to (null for auto)
     * @param integer|null $height The height to resize to (null for auto)
     * @param integer $quality Image quality (1-100)
     * @return string The path to the stored image
     */
    public function uploadImage(UploadedFile $file, string $folder = 'images', int $width = 1200, ?int $height = null, int $quality = 90): string
    {
        // Generate a unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Create the intervention image instance
        $img = $this->imageManager->read($file->getRealPath());
        
        // Resize the image
        if ($height) {
            $img->resize($width, $height);
        } else {
            $img->scale(width: $width);
        }
        
        // Prepare path and store the image
        $path = $folder . '/' . $filename;
        Storage::put('public/' . $path, $img->encode(null, $quality)->toString());
        
        return $path;
    }
    
    /**
     * Delete an image from storage
     *
     * @param string $path The path to the image
     * @return boolean Whether the deletion was successful
     */
    public function deleteImage(string $path): bool
    {
        if (empty($path)) {
            return false;
        }
        
        if (Storage::exists('public/' . $path)) {
            return Storage::delete('public/' . $path);
        }
        
        return false;
    }
    
    /**
     * Process an existing image
     *
     * @param string $path The path to the image
     * @param integer $width The width to resize to
     * @param integer|null $height The height to resize to
     * @param integer $quality Image quality (1-100)
     * @return boolean Whether the processing was successful
     */
    public function processExistingImage(string $path, int $width = 1200, ?int $height = null, int $quality = 90): bool
    {
        try {
            if (!Storage::exists('public/' . $path)) {
                return false;
            }
            
            // Get the image content
            $imageContent = Storage::get('public/' . $path);
            
            // Create intervention image from content
            $img = $this->imageManager->read($imageContent);
            
            // Resize the image
            if ($height) {
                $img->resize($width, $height);
            } else {
                $img->scale(width: $width);
            }
            
            // Save the processed image back to storage
            Storage::put('public/' . $path, $img->encode(null, $quality)->toString());
            
            return true;
        } catch (\Exception $e) {
            // Log the error here if needed
            return false;
        }
    }
} 