<?php

namespace App\Services;

use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use InvalidArgumentException;

class CarImageService
{
    /**
     * @param array<int, UploadedFile> $images
     */
    public function storeUploadedImages(Car $car, array $images, bool $makeFirstPrimary = false): void
    {
        if ($images === []) {
            return;
        }

        $hasPrimaryImage = $car->images()->where('is_primary', true)->exists();

        foreach ($images as $index => $imageFile) {
            $isPrimary = ($makeFirstPrimary && $index === 0) || (! $hasPrimaryImage && $index === 0);

            if ($isPrimary) {
                $this->clearPrimaryImage($car);
                $hasPrimaryImage = true;
            }

            $image = CarImage::query()->create([
                'image_path' => $this->storeImage($imageFile),
                'is_primary' => $isPrimary,
            ]);

            $car->images()->attach($image->id);
        }
    }

    public function setPrimaryImage(Car $car, int $imageId): void
    {
        $isAttachedToCar = $car->images()->whereKey($imageId)->exists();

        if (! $isAttachedToCar) {
            throw new InvalidArgumentException('Gambar mobil tidak valid.');
        }

        $this->clearPrimaryImage($car);
        CarImage::query()->whereKey($imageId)->update(['is_primary' => true]);
    }

    /**
     * @param array<int, int|string> $imageIds
     */
    public function deleteImages(Car $car, array $imageIds): void
    {
        $imageIds = collect($imageIds)
            ->map(fn ($imageId) => (int) $imageId)
            ->filter()
            ->unique()
            ->values();

        if ($imageIds->isEmpty()) {
            return;
        }

        $attachedImages = $car->images()
            ->whereIn('car_images.id', $imageIds)
            ->get();

        if ($attachedImages->isEmpty()) {
            return;
        }

        $deletedPrimaryImage = $attachedImages->contains(fn (CarImage $image) => $image->is_primary);

        $car->images()->detach($attachedImages->pluck('id')->all());

        CarImage::query()
            ->whereIn('id', $attachedImages->pluck('id'))
            ->whereDoesntHave('cars')
            ->delete();

        if ($deletedPrimaryImage) {
            $this->ensurePrimaryImage($car);
        }
    }

    private function clearPrimaryImage(Car $car): void
    {
        CarImage::query()
            ->whereHas('cars', function ($query) use ($car): void {
                $query->where($car->getQualifiedKeyName(), $car->getKey());
            })
            ->update(['is_primary' => false]);
    }

    private function ensurePrimaryImage(Car $car): void
    {
        $remainingImage = $car->images()
            ->orderBy('car_images.id')
            ->first();

        if ($remainingImage) {
            $this->clearPrimaryImage($car);
            $remainingImage->update(['is_primary' => true]);
        }
    }

    private function storeImage(UploadedFile $imageFile): string
    {
        $targetDirectory = public_path('assets/img/mobil');

        if (! is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }

        $originalName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = strtolower($imageFile->getClientOriginalExtension() ?: $imageFile->extension() ?: 'jpg');
        $fileName = (Str::slug($originalName) ?: 'mobil') . '-' . Str::random(8) . '.' . $extension;

        $imageFile->move($targetDirectory, $fileName);

        return 'assets/img/mobil/' . $fileName;
    }
}
