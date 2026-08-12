<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryAndMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            $langId = 1;

            // 1. Update/Ensure Parent Product Catalogue ID 1 (Sản phẩm)
            $rootCat = DB::table('product_catalogues')->where('id', 1)->first();
            if (!$rootCat) {
                DB::table('product_catalogues')->insert(['id' => 1, 'parent_id' => 0, 'level' => 1, 'publish' => 2, 'user_id' => 1, 'lft' => 1, 'rgt' => 20]);
                DB::table('product_catalogue_language')->insert([
                    'product_catalogue_id' => 1,
                    'language_id' => $langId,
                    'name' => 'Sản phẩm',
                    'canonical' => 'san-pham',
                    'meta_title' => 'Sản phẩm',
                    'meta_keyword' => 'san pham',
                    'meta_description' => 'Tất cả sản phẩm',
                ]);
            }

            // 2. Update/Ensure Ống Inox (ID 2)
            DB::table('product_catalogues')->where('id', 2)->update(['parent_id' => 1, 'level' => 2, 'order' => 2, 'publish' => 2]);
            DB::table('product_catalogue_language')->updateOrInsert(
                ['product_catalogue_id' => 2, 'language_id' => $langId],
                [
                    'name' => 'Ống Inox',
                    'canonical' => 'ong-inox',
                    'meta_title' => 'Ống Inox',
                    'meta_keyword' => 'ong inox',
                    'meta_description' => 'Các loại ống Inox không hàn cao cấp',
                ]
            );
            DB::table('routers')->updateOrInsert(
                ['canonical' => 'ong-inox'],
                ['module_id' => 2, 'controllers' => 'App\Http\Controllers\Frontend\ProductCatalogueController', 'language_id' => $langId]
            );

            // 3. Update/Ensure Ống PCCC (ID 3)
            DB::table('product_catalogues')->where('id', 3)->update(['parent_id' => 1, 'level' => 2, 'order' => 1, 'publish' => 2]);
            DB::table('product_catalogue_language')->updateOrInsert(
                ['product_catalogue_id' => 3, 'language_id' => $langId],
                [
                    'name' => 'Ống PCCC',
                    'canonical' => 'ong-pccc',
                    'meta_title' => 'Ống PCCC',
                    'meta_keyword' => 'ong pccc',
                    'meta_description' => 'Ống PCCC Thép Carbon không hàn',
                ]
            );
            DB::table('routers')->updateOrInsert(
                ['canonical' => 'ong-pccc'],
                ['module_id' => 3, 'controllers' => 'App\Http\Controllers\Frontend\ProductCatalogueController', 'language_id' => $langId]
            );

            // 4. Create/Update Ống nhựa
            $ongNhuaCat = DB::table('product_catalogue_language')->where('canonical', 'ong-nhua')->first();
            if ($ongNhuaCat) {
                $ongNhuaId = $ongNhuaCat->product_catalogue_id;
                DB::table('product_catalogues')->where('id', $ongNhuaId)->update(['parent_id' => 1, 'level' => 2, 'order' => 3, 'publish' => 2, 'image' => '/userfiles/image/slide/anh-ong-nhua.png']);
                DB::table('product_catalogue_language')->where('product_catalogue_id', $ongNhuaId)->update(['name' => 'Ống nhựa', 'canonical' => 'ong-nhua']);
            } else {
                $ongNhuaId = DB::table('product_catalogues')->insertGetId([
                    'parent_id' => 1,
                    'level' => 2,
                    'order' => 3,
                    'publish' => 2,
                    'image' => '/userfiles/image/slide/anh-ong-nhua.png',
                    'user_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                DB::table('product_catalogue_language')->insert([
                    'product_catalogue_id' => $ongNhuaId,
                    'language_id' => $langId,
                    'name' => 'Ống nhựa',
                    'canonical' => 'ong-nhua',
                    'meta_title' => 'Ống nhựa PPR Shanghai ZHSU',
                    'meta_keyword' => 'ong nhua, ong ppr',
                    'meta_description' => 'Các loại ống nhựa PPR thương hiệu Shanghai ZHSU',
                ]);
            }
            DB::table('routers')->updateOrInsert(
                ['canonical' => 'ong-nhua'],
                ['module_id' => $ongNhuaId, 'controllers' => 'App\Http\Controllers\Frontend\ProductCatalogueController', 'language_id' => $langId]
            );

            // 5. Create/Update Parent Category: Các loại Van
            $vanParentCat = DB::table('product_catalogue_language')->where('canonical', 'cac-loai-van')->first();
            if ($vanParentCat) {
                $vanParentId = $vanParentCat->product_catalogue_id;
                DB::table('product_catalogues')->where('id', $vanParentId)->update(['parent_id' => 1, 'level' => 2, 'order' => 4, 'publish' => 2]);
                DB::table('product_catalogue_language')->where('product_catalogue_id', $vanParentId)->update(['name' => 'Các loại Van', 'canonical' => 'cac-loai-van']);
            } else {
                $vanParentId = DB::table('product_catalogues')->insertGetId([
                    'parent_id' => 1,
                    'level' => 2,
                    'order' => 4,
                    'publish' => 2,
                    'user_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                DB::table('product_catalogue_language')->insert([
                    'product_catalogue_id' => $vanParentId,
                    'language_id' => $langId,
                    'name' => 'Các loại Van',
                    'canonical' => 'cac-loai-van',
                    'meta_title' => 'Các loại Van công nghiệp & hệ thống nước',
                    'meta_keyword' => 'cac loai van, van cong nghiep, van chua chay',
                    'meta_description' => 'Tổng hợp các loại van hệ thống nước, van công nghiệp, van chữa cháy, van đồng',
                ]);
            }
            DB::table('routers')->updateOrInsert(
                ['canonical' => 'cac-loai-van'],
                ['module_id' => $vanParentId, 'controllers' => 'App\Http\Controllers\Frontend\ProductCatalogueController', 'language_id' => $langId]
            );

            // 6. Nest existing Valve sub-categories under Các loại Van (Parent ID = $vanParentId, Level = 3)
            $valveCatIds = [10, 11, 12, 13];
            foreach ($valveCatIds as $idx => $vId) {
                $exists = DB::table('product_catalogues')->where('id', $vId)->exists();
                if ($exists) {
                    DB::table('product_catalogues')->where('id', $vId)->update([
                        'parent_id' => $vanParentId,
                        'level' => 3,
                        'order' => $idx + 1,
                        'publish' => 2,
                    ]);
                }
            }

            // Rebuild LFT/RGT nested set bounds
            $this->rebuildNestedSet(0, 1, 0);

            // --- MENUS RESTRUCTURING ---

            // A. Header Menu (Catalogue 1, Parent ID 69 - Sản phẩm)
            $headerProductMenuId = 69;
            
            // Delete old sub-menu items under Parent 69 (including phụ kiện & old valve menus)
            $oldHeaderSubMenuIds = DB::table('menus')->where('parent_id', $headerProductMenuId)->pluck('id')->toArray();
            if (!empty($oldHeaderSubMenuIds)) {
                // Delete children of those sub-menus as well
                DB::table('menus')->whereIn('parent_id', $oldHeaderSubMenuIds)->delete();
                DB::table('menu_language')->whereIn('menu_id', $oldHeaderSubMenuIds)->delete();
                DB::table('menus')->whereIn('id', $oldHeaderSubMenuIds)->delete();
            }

            // Insert 4 main Header Sub-Menus
            // 1. Ống PCCC
            $mPcccId = DB::table('menus')->insertGetId(['menu_catalogue_id' => 1, 'parent_id' => $headerProductMenuId, 'order' => 1, 'user_id' => 1]);
            DB::table('menu_language')->insert(['menu_id' => $mPcccId, 'language_id' => $langId, 'name' => 'Ống PCCC', 'canonical' => 'ong-pccc']);

            // 2. Ống Inox
            $mInoxId = DB::table('menus')->insertGetId(['menu_catalogue_id' => 1, 'parent_id' => $headerProductMenuId, 'order' => 2, 'user_id' => 1]);
            DB::table('menu_language')->insert(['menu_id' => $mInoxId, 'language_id' => $langId, 'name' => 'Ống Inox', 'canonical' => 'ong-inox']);

            // 3. Ống nhựa
            $mNhuaId = DB::table('menus')->insertGetId(['menu_catalogue_id' => 1, 'parent_id' => $headerProductMenuId, 'order' => 3, 'user_id' => 1]);
            DB::table('menu_language')->insert(['menu_id' => $mNhuaId, 'language_id' => $langId, 'name' => 'Ống nhựa', 'canonical' => 'ong-nhua']);

            // 4. Các loại Van
            $mVanId = DB::table('menus')->insertGetId(['menu_catalogue_id' => 1, 'parent_id' => $headerProductMenuId, 'order' => 4, 'user_id' => 1]);
            DB::table('menu_language')->insert(['menu_id' => $mVanId, 'language_id' => $langId, 'name' => 'Các loại Van', 'canonical' => 'cac-loai-van']);

            // Sub-menus under Các loại Van
            $valvesSub = [
                ['name' => 'Van hệ thống nước', 'canonical' => 'van-he-thong-nuoc'],
                ['name' => 'Van công nghiệp', 'canonical' => 'van-cong-nghiep'],
                ['name' => 'Van chữa cháy', 'canonical' => 'van-chua-chay'],
                ['name' => 'Van đồng', 'canonical' => 'van-dong'],
            ];
            foreach ($valvesSub as $idx => $vs) {
                $subId = DB::table('menus')->insertGetId(['menu_catalogue_id' => 1, 'parent_id' => $mVanId, 'order' => $idx + 1, 'user_id' => 1]);
                DB::table('menu_language')->insert(['menu_id' => $subId, 'language_id' => $langId, 'name' => $vs['name'], 'canonical' => $vs['canonical']]);
            }

            // B. Footer Menu (Catalogue 2, Parent ID 93 - Danh mục)
            $footerCatMenuId = 93;
            $oldFooterMenuIds = DB::table('menus')->where('parent_id', $footerCatMenuId)->pluck('id')->toArray();
            if (!empty($oldFooterMenuIds)) {
                DB::table('menu_language')->whereIn('menu_id', $oldFooterMenuIds)->delete();
                DB::table('menus')->whereIn('id', $oldFooterMenuIds)->delete();
            }

            $footerItems = [
                ['name' => 'Ống PCCC', 'canonical' => 'ong-pccc'],
                ['name' => 'Ống Inox', 'canonical' => 'ong-inox'],
                ['name' => 'Ống nhựa', 'canonical' => 'ong-nhua'],
                ['name' => 'Các loại Van', 'canonical' => 'cac-loai-van'],
            ];

            foreach ($footerItems as $idx => $fi) {
                $fId = DB::table('menus')->insertGetId(['menu_catalogue_id' => 2, 'parent_id' => $footerCatMenuId, 'order' => $idx + 1, 'user_id' => 1]);
                DB::table('menu_language')->insert(['menu_id' => $fId, 'language_id' => $langId, 'name' => $fi['name'], 'canonical' => $fi['canonical']]);
            }

            DB::commit();
            $this->command->info("CategoryAndMenuSeeder completed! Created/Updated 4 main categories (Ống PCCC, Ống Inox, Ống nhựa, Các loại Van) and restructured navigation menus.");

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("CategoryAndMenuSeeder failed: " . $e->getMessage());
        }
    }

    private function rebuildNestedSet($parentId = 0, $left = 1, $level = 0)
    {
        $children = DB::table('product_catalogues')
            ->where('parent_id', $parentId)
            ->orderBy('order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        foreach ($children as $child) {
            $right = $this->rebuildNestedSet($child->id, $left + 1, $level + 1);
            DB::table('product_catalogues')->where('id', $child->id)->update([
                'lft' => $left,
                'rgt' => $right,
                'level' => $level + 1,
            ]);
            $left = $right + 1;
        }
        return $left;
    }
}
