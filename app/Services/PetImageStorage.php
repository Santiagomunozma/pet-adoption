<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PetImageStorage
{
    public function isCloudinaryEnabled(): bool
    {
        return filled(config('cloudinary.url'))
            || (filled(config('cloudinary.cloud_name'))
                && filled(config('cloudinary.api_key'))
                && filled(config('cloudinary.api_secret')));
    }

    /**
     * @param  UploadedFile|TemporaryUploadedFile  $file
     */
    public function store(UploadedFile|TemporaryUploadedFile $file): string
    {
        if ($this->isCloudinaryEnabled()) {
            return $this->storeOnCloudinary($file);
        }

        return $file->store('pets', config('cloudinary.fallback_disk'));
    }

    public function delete(?string $storedPath): void
    {
        if (! $storedPath || str_starts_with($storedPath, 'http://') || str_starts_with($storedPath, 'https://')) {
            return;
        }

        if ($this->isCloudinaryEnabled() && str_starts_with($storedPath, config('cloudinary.folder').'/')) {
            $this->cloudinary()->uploadApi->destroy($storedPath);

            return;
        }

        Storage::disk(config('cloudinary.fallback_disk'))->delete($storedPath);
    }

    public function url(?string $storedPath): ?string
    {
        if (! $storedPath) {
            return null;
        }

        if (str_starts_with($storedPath, 'http://') || str_starts_with($storedPath, 'https://')) {
            return $storedPath;
        }

        if ($this->isCloudinaryEnabled() && str_starts_with($storedPath, config('cloudinary.folder').'/')) {
            return (string) $this->cloudinary()->image($storedPath)->toUrl();
        }

        return asset('storage/'.$storedPath);
    }

    protected function storeOnCloudinary(UploadedFile|TemporaryUploadedFile $file): string
    {
        $result = $this->cloudinary()->uploadApi->upload(
            $file->getRealPath(),
            [
                'folder' => config('cloudinary.folder'),
                'resource_type' => 'image',
            ]
        );

        return $result['public_id'];
    }

    protected function cloudinary(): Cloudinary
    {
        if ($url = config('cloudinary.url')) {
            return new Cloudinary(['url' => $url]);
        }

        return new Cloudinary([
            'cloud' => [
                'cloud_name' => config('cloudinary.cloud_name'),
                'api_key' => config('cloudinary.api_key'),
                'api_secret' => config('cloudinary.api_secret'),
            ],
        ]);
    }
}
