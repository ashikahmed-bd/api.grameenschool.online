<?php

namespace Database\Seeders;

use App\Models\Batch;
use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            'Science' => 1,
            'Commerce' => 2,
            'Arts' => 3,
        ];
        $batches = Batch::all();

        foreach ($batches as $batch) {
            foreach ($groups as $name => $sortOrder) {

                Group::updateOrCreate(
                    [
                        'batch_id' => $batch->id,
                        'slug' => Str::slug($name),
                    ],
                    [
                        'name' => $name,
                        'sort_order' => $sortOrder,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
