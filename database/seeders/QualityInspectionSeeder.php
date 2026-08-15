<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Slide;
use Carbon\Carbon;

class QualityInspectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            $langId = 1;
            $canonical = 'kiem-dinh-chat-luong';
            $title = 'Kiểm định chất lượng';

            // 1. Create or Update Post Catalogue
            $existingCat = DB::table('post_catalogue_language')
                ->where('canonical', $canonical)
                ->where('language_id', $langId)
                ->first();

            if ($existingCat) {
                $catalogueId = $existingCat->post_catalogue_id;
                DB::table('post_catalogues')->where('id', $catalogueId)->update([
                    'publish' => 2,
                    'user_id' => 1,
                    'updated_at' => now(),
                ]);
            } else {
                $catalogueId = DB::table('post_catalogues')->insertGetId([
                    'parent_id' => 0,
                    'level' => 1,
                    'lft' => 1,
                    'rgt' => 2,
                    'publish' => 2,
                    'user_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('post_catalogue_language')->insert([
                    'post_catalogue_id' => $catalogueId,
                    'language_id' => $langId,
                    'name' => $title,
                    'canonical' => $canonical,
                    'meta_title' => 'Kiểm định chất lượng & Giấy ủy quyền - VIREX',
                    'meta_keyword' => 'kiem dinh chat luong, giay uy quyen, iso, kqkn, smai, virex',
                    'meta_description' => 'Hồ sơ kiểm định chất lượng, tiêu chuẩn ISO, kết quả kiểm nghiệm và ủy nhiệm độc quyền phân phối sản phẩm VIREX.',
                    'description' => 'Hồ sơ kiểm định chất lượng và ủy nhiệm độc quyền phân phối',
                    'content' => 'Hồ sơ kiểm định chất lượng và ủy nhiệm độc quyền phân phối',
                ]);
            }

            // 2. Create or Update Router Entry
            DB::table('routers')->updateOrInsert(
                ['canonical' => $canonical, 'language_id' => $langId],
                [
                    'module_id' => $catalogueId,
                    'controllers' => 'App\Http\Controllers\Frontend\QualityInspectionController',
                ]
            );

            // 3. Create or Update Menu Item
            $existingMenu = DB::table('menu_language')
                ->where('canonical', $canonical)
                ->where('language_id', $langId)
                ->first();

            if (!$existingMenu) {
                $maxOrder = DB::table('menus')->where('menu_catalogue_id', 1)->where('parent_id', 0)->max('order') ?? 0;
                $menuId = DB::table('menus')->insertGetId([
                    'menu_catalogue_id' => 1,
                    'parent_id' => 0,
                    'order' => $maxOrder + 1,
                    'user_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('menu_language')->insert([
                    'menu_id' => $menuId,
                    'language_id' => $langId,
                    'name' => $title,
                    'canonical' => $canonical,
                ]);
            }

            // 4. Create/Update Dynamic Slides for Quality Inspection
            $slideConfigs = [
                'quality-authorization' => [
                    'name' => 'Biên bản ủy quyền độc quyền phân phối',
                    'dir' => 'public/userfiles/image/kiem-dinh-chat-luong/uy-quyen',
                    'default_name' => 'Biên bản ủy quyền độc quyền phân phối',
                ],
                'quality-pccc-iso' => [
                    'name' => 'Ống PCCC - Tiêu chuẩn ISO',
                    'dir' => 'public/userfiles/image/kiem-dinh-chat-luong/ong-pccc/iso',
                    'default_name' => 'Chứng nhận tiêu chuẩn ISO Ống PCCC',
                ],
                'quality-pccc-smai' => [
                    'name' => 'Ống PCCC - Kết luận thử nghiệm S&Mai',
                    'dir' => 'public/userfiles/image/kiem-dinh-chat-luong/ong-pccc/smai',
                    'default_name' => 'Kết luận thử nghiệm S&Mai Ống PCCC',
                ],
                'quality-pccc-kqkn' => [
                    'name' => 'Ống PCCC - Kết quả kiểm nghiệm KQKN',
                    'dir' => 'public/userfiles/image/kiem-dinh-chat-luong/ong-pccc/kqkn',
                    'default_name' => 'Kết quả kiểm nghiệm KQKN Ống PCCC',
                ],
                'quality-inox' => [
                    'name' => 'Ống Inox - Chứng chỉ kiểm định',
                    'dir' => 'public/userfiles/image/kiem-dinh-chat-luong/ong-inox',
                    'default_name' => 'Chứng chỉ kiểm định chất lượng Ống Inox',
                ],
                'quality-nhua' => [
                    'name' => 'Ống nhựa - Chứng chỉ kiểm định',
                    'dir' => 'public/userfiles/image/kiem-dinh-chat-luong/ong-nhua',
                    'default_name' => 'Chứng chỉ kiểm định chất lượng Ống nhựa PPR',
                ],
                'quality-van' => [
                    'name' => 'Các loại Van - Chứng chỉ kiểm định',
                    'dir' => 'public/userfiles/image/kiem-dinh-chat-luong/cac-loai-van',
                    'default_name' => 'Chứng chỉ kiểm định Các loại Van',
                ],
            ];

            foreach ($slideConfigs as $keyword => $cfg) {
                $slideItems = [];
                $fullPath = base_path($cfg['dir']);

                if (File::exists($fullPath)) {
                    $files = File::files($fullPath);
                    $sortFiles = [];
                    foreach ($files as $f) {
                        if (in_array(strtolower($f->getExtension()), ['jpg', 'jpeg', 'png', 'webp'])) {
                            $sortFiles[] = $f;
                        }
                    }
                    usort($sortFiles, function ($a, $b) {
                        return strnatcmp($a->getFilename(), $b->getFilename());
                    });

                    foreach ($sortFiles as $idx => $file) {
                        // Strip 'public/' from start so image path is /userfiles/image/...
                        $urlDir = preg_replace('/^public\/?/', '/', str_replace('\\', '/', $cfg['dir']));
                        $relativePath = rtrim($urlDir, '/') . '/' . $file->getFilename();
                        
                        $slideItems[] = [
                            'image' => $relativePath,
                            'name' => $cfg['default_name'] . ' (' . ($idx + 1) . ')',
                            'description' => '',
                            'canonical' => '',
                            'alt' => $cfg['default_name'],
                            'window' => '',
                        ];
                    }
                }

                $payloadItem = [
                    $langId => $slideItems,
                ];

                Slide::updateOrCreate(
                    ['keyword' => $keyword],
                    [
                        'name' => $cfg['name'],
                        'keyword' => $keyword,
                        'item' => $payloadItem,
                        'publish' => 2,
                        'short_code' => '',
                    ]
                );
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
