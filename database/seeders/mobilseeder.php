<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Database\Seeder;

class mobilseeder extends Seeder
{
    public function run(): void
    {
        $carImages = [
            'TYT-001' => ['toyota-avanza-front.jpg', 'toyota-avanza-rear.jpg'],
            'TYT-002' => ['toyota-innova-front.jpg', 'toyota-innova-rear.jpg'],
            'TYT-003' => ['toyota-agya-front.jpg', 'toyota-agya-rear.jpg'],
            'TYT-004' => ['toyota-yaris-front.jpg', 'toyota-yaris-rear.jpg'],
            'TYT-005' => ['toyota-calya-front.jpg', 'toyota-calya-rear.jpg'],
            'DAI-001' => ['daihatsu-xenia-front.jpg', 'daihatsu-xenia-rear.jpg'],
            'DAI-002' => ['daihatsu-ayla-front.jpg', 'daihatsu-ayla-rear.jpg'],
            'DAI-003' => ['daihatsu-sigra-front.jpg', 'daihatsu-sigra-rear.jpg'],
            'HND-001' => ['honda-civic-front.jpg', 'honda-civic-rear.jpg'],
            'HND-002' => ['honda-brio-front.jpg', 'honda-brio-rear.jpg'],
            'HND-003' => ['honda-jazz-front.jpg', 'honda-jazz-rear.jpg'],
            'SUZ-001' => ['suzuki-ertiga-front.jpg', 'suzuki-ertiga-rear.jpg'],
            'SUZ-002' => ['suzuki-xl7-front.jpg', 'suzuki-xl7-rear.jpg'],
            'SUZ-003' => ['suzuki-baleno-front.jpg', 'suzuki-baleno-rear.jpg'],
            'SUZ-004' => ['suzuki-ignis-front.jpg', 'suzuki-ignis-rear.jpg'],
            'SUZ-005' => ['suzuki-swift-front.jpg', 'suzuki-swift-rear.jpg'],
            'SUZ-006' => ['suzuki-carry-front.jpg', 'suzuki-carry-rear.jpg'],
            'SUZ-007' => ['suzuki-jimny-front.jpg', 'suzuki-jimny-rear.jpg'],
            'MIT-001' => ['mitsubishi-xpander-front.jpg', 'mitsubishi-xpander-rear.jpg'],
            'MIT-002' => ['mitsubishi-pajero-sport-front.jpg', 'mitsubishi-pajero-sport-rear.jpg'],
            'MIT-003' => ['mitsubishi-xforce-front.jpg', 'mitsubishi-xforce-rear.jpg'],
            'TSL-001' => ['tesla-model-3-front.jpg', 'tesla-model-3-rear.jpg'],
        ];

        foreach ($carImages as $seriesNumber => $fileNames) {
            $car = Car::query()->find($seriesNumber);

            if (! $car) {
                continue;
            }

            CarImage::query()
                ->whereHas('cars', function ($query) use ($car): void {
                    $query->where($car->getQualifiedKeyName(), $car->getKey());
                })
                ->update(['is_primary' => false]);

            $imageIds = [];

            foreach ($fileNames as $index => $fileName) {
                $image = CarImage::query()->updateOrCreate(
                    ['image_path' => 'assets/img/mobil/' . $fileName],
                    ['is_primary' => $index === 0]
                );

                $imageIds[] = $image->id;
            }

            $car->images()->sync($imageIds);
        }
    }
}
