<?php

namespace Database\Seeders;

use App\Domain\Entities\Bike;
use App\Domain\Entities\Brand;
use App\Domain\Entities\TypeBike;
use App\Domain\Entities\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        TypeBike::updateOrCreate(['name' => 'MTB']);
        TypeBike::updateOrCreate(['name' => 'Speed']);
        TypeBike::updateOrCreate(['name' => 'Urban']);
        TypeBike::updateOrCreate(['name' => 'Electrical']);
        TypeBike::updateOrCreate(['name' => 'Kid']);
        TypeBike::updateOrCreate(['name' => 'Road']);
        TypeBike::updateOrCreate(['name' => 'Mountain']);
        TypeBike::updateOrCreate(['name' => 'Cruiser']);


        Brand::updateOrCreate(
            ['name' => 'Caloi'],
            ['logo_path' => 'logos/caloi.webp']
        );
        Brand::updateOrCreate(
            ['name' => 'Audax'],
            ['logo_path' => 'logos/audax.webp']
        );
        Brand::updateOrCreate(
            ['name' => 'Mormaii'],
            ['logo_path' => 'logos/mormaii.webp']
        );
        Brand::updateOrCreate(
            ['name' => 'Soul Cycles'],
            ['logo_path' => 'logos/soul.webp']
        );
        

        //---------------------------------------------------------//

        Bike::updateOrCreate(
            ['name' => 'Caloi Elite 2024'], 
            [
                'year' => 2024,
                'type_bike_id' => TypeBike::where('name', 'Speed')->first()->id ?? null,
                'brand_id' => Brand::where('name', 'Caloi')->first()->id ?? null,
            ]
        );
        
        Bike::updateOrCreate(
            ['name' => 'Caloi Roadster 2023'],
            [
                'year' => 2023,
                'type_bike_id' => TypeBike::where('name', 'Road')->first()->id ?? null,
                'brand_id' => Brand::where('name', 'Caloi')->first()->id ?? null,
            ]
        );
        
        Bike::updateOrCreate(
            ['name' => 'Caloi MTB 2024'],
            [
                'year' => 2024,
                'type_bike_id' => TypeBike::where('name', 'Mountain')->first()->id ?? null,
                'brand_id' => Brand::where('name', 'Caloi')->first()->id ?? null,
            ]
        );
        
        Bike::updateOrCreate(
            ['name' => 'Caloi Cruiser 2022'],
            [
                'year' => 2022,
                'type_bike_id' => TypeBike::where('name', 'Cruiser')->first()->id ?? null,
                'brand_id' => Brand::where('name', 'Caloi')->first()->id ?? null,
            ]
        );

        Bike::updateOrCreate(
            ['name' => 'Audax Elite 2024'], 
            [
                'year' => 2024,
                'type_bike_id' => TypeBike::where('name', 'Road')->first()->id ?? null,
                'brand_id' => Brand::where('name', 'Audax')->first()->id ?? null,
            ]
        );
        
        Bike::updateOrCreate(
            ['name' => 'Audax MTB 2023'],
            [
                'year' => 2023,
                'type_bike_id' => TypeBike::where('name', 'Mountain')->first()->id ?? null,
                'brand_id' => Brand::where('name', 'Audax')->first()->id ?? null,
            ]
        );
        
        Bike::updateOrCreate(
            ['name' => 'Audax Roadster 2022'],
            [
                'year' => 2022,
                'type_bike_id' => TypeBike::where('name', 'Road')->first()->id ?? null,
                'brand_id' => Brand::where('name', 'Audax')->first()->id ?? null,
            ]
        );
        
        Bike::updateOrCreate(
            ['name' => 'Audax Cruiser 2021'],
            [
                'year' => 2021,
                'type_bike_id' => TypeBike::where('name', 'Cruiser')->first()->id ?? null,
                'brand_id' => Brand::where('name', 'Audax')->first()->id ?? null,
            ]
        );
        
        Bike::updateOrCreate(
            ['name' => 'Mormaii Elite 2024'], 
            [
                'year' => 2024,
                'type_bike_id' => TypeBike::where('name', 'Road')->first()->id ?? null,
                'brand_id' => Brand::where('name', 'Mormaii')->first()->id ?? null,
            ]
        );
        
        Bike::updateOrCreate(
            ['name' => 'Mormaii MTB 2023'],
            [
                'year' => 2023,
                'type_bike_id' => TypeBike::where('name', 'Mountain')->first()->id ?? null,
                'brand_id' => Brand::where('name', 'Mormaii')->first()->id ?? null,
            ]
        );
        
        Bike::updateOrCreate(
            ['name' => 'Mormaii Roadster 2022'],
            [
                'year' => 2022,
                'type_bike_id' => TypeBike::where('name', 'Road')->first()->id ?? null,
                'brand_id' => Brand::where('name', 'Mormaii')->first()->id ?? null,
            ]
        );
        
        Bike::updateOrCreate(
            ['name' => 'Mormaii Cruiser 2021'],
            [
                'year' => 2021,
                'type_bike_id' => TypeBike::where('name', 'Cruiser')->first()->id ?? null,
                'brand_id' => Brand::where('name', 'Mormaii')->first()->id ?? null,
            ]
        );
        
        Bike::updateOrCreate(
            ['name' => 'Soul Cycles Elite 2024'], 
            [
                'year' => 2024,
                'type_bike_id' => TypeBike::where('name', 'Road')->first()->id ?? null,
                'brand_id' => Brand::where('name', 'Soul Cycles')->first()->id ?? null,
            ]
        );
        
        Bike::updateOrCreate(
            ['name' => 'Soul Cycles MTB 2023'],
            [
                'year' => 2023,
                'type_bike_id' => TypeBike::where('name', 'Mountain')->first()->id ?? null,
                'brand_id' => Brand::where('name', 'Soul Cycles')->first()->id ?? null,
            ]
        );
        
        Bike::updateOrCreate(
            ['name' => 'Soul Cycles Roadster 2022'],
            [
                'year' => 2022,
                'type_bike_id' => TypeBike::where('name', 'Road')->first()->id ?? null,
                'brand_id' => Brand::where('name', 'Soul Cycles')->first()->id ?? null,
            ]
        );
        
        Bike::updateOrCreate(
            ['name' => 'Soul Cycles Cruiser 2021'],
            [
                'year' => 2021,
                'type_bike_id' => TypeBike::where('name', 'Cruiser')->first()->id ?? null,
                'brand_id' => Brand::where('name', 'Soul Cycles')->first()->id ?? null,
            ]
        );
    }
}
