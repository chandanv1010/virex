<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HomepageVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $videoCatalogueId = 12; // Thư viện Video

        // Verify or create video catalogue if not exists
        $catalogue = DB::table('post_catalogues')->where('id', $videoCatalogueId)->first();
        if (!$catalogue) {
            $videoCatalogueId = DB::table('post_catalogues')->insertGetId([
                'parent_id' => 0,
                'lft' => 16,
                'rgt' => 17,
                'level' => 1,
                'publish' => 2,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('post_catalogue_language')->insert([
                'post_catalogue_id' => $videoCatalogueId,
                'language_id' => 1,
                'name' => 'Thư viện Video',
                'canonical' => 'thuvien-video',
                'meta_title' => 'Thư viện Video',
                'meta_keyword' => 'video',
                'meta_description' => 'Thư viện Video',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // List of 4 real videos from YouTube channel @Virex68
        $videos = [
            [
                'title' => 'Tương lai của ngành ống, giải pháp tăng tốc độ thi công, tăng độ bền vượt trội',
                'code' => 'rBDgA86nI_Y',
                'canonical' => 'tuong-lai-cua-nganh-ong-giai-phap-tang-toc-do-thi-cong-tang-do-ben-vuot-troi',
            ],
            [
                'title' => 'Hỏa hoạn thương tâm sẽ xảy ra từ những chủ quan nhỏ nhất!',
                'code' => 'VwkjBerGvBc',
                'canonical' => 'hoa-hoan-thuong-tam-se-xay-ra-tu-nhung-chu-quan-nho-nhat',
            ],
            [
                'title' => 'Mẹo đề phòng hỏa hoạn trong thời tiết nắng nóng!',
                'code' => '-7zBokFIkSI',
                'canonical' => 'meo-de-phong-hoa-hoan-trong-thoi-tiet-nang-nong',
            ],
            [
                'title' => 'Công nghệ đường ống PCCC, ống nước sạch hiện đại nhất',
                'code' => 'aNtZijfKuaU',
                'canonical' => 'cong-nghe-duong-ong-pccc-ong-nuoc-sach-hien-dai-nhat',
            ],
        ];

        // Clean up old demo posts linked to video category (e.g. IDs 29, 30, 31, 32 or existing catalogue posts)
        $oldPostIds = DB::table('post_catalogue_post')
            ->where('post_catalogue_id', $videoCatalogueId)
            ->pluck('post_id')
            ->toArray();

        if (!empty($oldPostIds)) {
            DB::table('posts')->whereIn('id', $oldPostIds)->delete();
            DB::table('post_language')->whereIn('post_id', $oldPostIds)->delete();
            DB::table('post_catalogue_post')->whereIn('post_id', $oldPostIds)->delete();
            DB::table('routers')->whereIn('module_id', $oldPostIds)->where('controllers', 'App\Http\Controllers\Frontend\PostController')->delete();
        }

        $imported = 0;

        foreach ($videos as $index => $v) {
            $youtubeId = $v['code'];
            $title = $v['title'];
            $canonical = $v['canonical'];
            $imageUrl = "https://img.youtube.com/vi/{$youtubeId}/hqdefault.jpg";
            $iframeHtml = '<iframe src="https://www.youtube.com/embed/' . $youtubeId . '" frameborder="0" allowfullscreen></iframe>';

            DB::beginTransaction();
            try {
                // Insert into posts
                $postId = DB::table('posts')->insertGetId([
                    'image' => $imageUrl,
                    'video' => $iframeHtml,
                    'publish' => 2,
                    'follow' => 2,
                    'order' => $index,
                    'user_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Insert into post_language
                DB::table('post_language')->insert([
                    'post_id' => $postId,
                    'language_id' => 1,
                    'name' => $title,
                    'canonical' => $canonical,
                    'description' => "Video: {$title}",
                    'content' => "<p>{$title}</p><p>{$iframeHtml}</p>",
                    'meta_title' => $title,
                    'meta_keyword' => "video virex, {$title}",
                    'meta_description' => "Video {$title} từ kênh VIREX68",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Insert into post_catalogue_post
                DB::table('post_catalogue_post')->insert([
                    'post_id' => $postId,
                    'post_catalogue_id' => $videoCatalogueId,
                ]);

                // Insert into routers
                DB::table('routers')->insert([
                    'canonical' => $canonical,
                    'module_id' => $postId,
                    'controllers' => 'App\Http\Controllers\Frontend\PostController',
                    'language_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::commit();
                $imported++;
            } catch (\Exception $e) {
                DB::rollBack();
                $this->command->error("Failed to insert video {$title}: " . $e->getMessage());
            }
        }

        // Ensure homepage-video widget points to videoCatalogueId
        $widget = DB::table('widgets')->where('keyword', 'homepage-video')->first();
        if ($widget) {
            DB::table('widgets')->where('keyword', 'homepage-video')->update([
                'model_id' => json_encode([(string)$videoCatalogueId]),
                'model' => 'PostCatalogue',
                'publish' => 2,
                'updated_at' => now(),
            ]);
        } else {
            DB::table('widgets')->insert([
                'name' => 'Thư viện Video',
                'keyword' => 'homepage-video',
                'description' => json_encode(["1" => "Video"]),
                'album' => json_encode([]),
                'model_id' => json_encode([(string)$videoCatalogueId]),
                'model' => 'PostCatalogue',
                'publish' => 2,
                'note' => 'Thư viện video trang chủ',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info("Homepage Video Seeder completed! Total videos imported: {$imported}");
    }
}
