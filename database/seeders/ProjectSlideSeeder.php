<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Slide;
use Illuminate\Support\Facades\File;

class ProjectSlideSeeder extends Seeder
{
    /**
     * Run the database seeds for Project Slide.
     */
    public function run(): void
    {
        $dir = public_path('userfiles/image/du-an');
        $slideItems = [];

        if (File::exists($dir)) {
            $files = File::files($dir);
            foreach ($files as $file) {
                if (in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp'])) {
                    $relativePath = '/userfiles/image/du-an/' . $file->getFilename();
                    $slideItems[] = [
                        'image' => $relativePath,
                        'name' => 'Dự án VIREX',
                        'description' => '',
                        'canonical' => '',
                        'alt' => 'Dự án VIREX',
                        'window' => '',
                    ];
                }
            }
        }

        $payloadItem = [
            1 => $slideItems, // Keyed by language_id = 1
        ];

        Slide::updateOrCreate(
            ['keyword' => 'project'],
            [
                'name' => 'Dự án tiêu biểu',
                'keyword' => 'project',
                'item' => $payloadItem,
                'publish' => 2,
                'short_code' => '',
            ]
        );
    }
}
