<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ShanghaiZhsuProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('seeders/pdf_products_data.json');

        if (!File::exists($jsonPath)) {
            $this->command->error("JSON data file not found at {$jsonPath}");
            return;
        }

        $productsData = json_decode(File::get($jsonPath), true);
        if (empty($productsData)) {
            $this->command->error("No product data found in JSON.");
            return;
        }

        // Target Product Catalogue: Ống nhựa (ong-nhua)
        $ongNhuaCat = DB::table('product_catalogue_language')->where('canonical', 'ong-nhua')->first();
        if ($ongNhuaCat) {
            $catalogueId = $ongNhuaCat->product_catalogue_id;
        } else {
            $catalogueId = 2; // Fallback
        }

        $imported = 0;
        $updated = 0;

        foreach ($productsData as $item) {
            $canonical = $item['canonical'];
            $name = $item['name'];
            $code = $item['code'];
            $image = $item['image'];
            $content = $item['content'];
            $description = $item['description'] ?? "Sản phẩm {$name} thương hiệu Shanghai ZHSU Pipe Co., Ltd chính hãng.";

            DB::beginTransaction();
            try {
                // Check if route already exists
                $existingRoute = DB::table('routers')->where('canonical', $canonical)->first();

                if ($existingRoute) {
                    $productId = $existingRoute->module_id;

                    // Update product
                    DB::table('products')->where('id', $productId)->update([
                        'product_catalogue_id' => $catalogueId,
                        'image' => $image,
                        'code' => $code,
                        'publish' => 2,
                        'updated_at' => now(),
                    ]);

                    // Update product_language
                    DB::table('product_language')
                        ->where('product_id', $productId)
                        ->where('language_id', 1)
                        ->update([
                            'name' => $name,
                            'description' => $description,
                            'content' => $content,
                            'meta_title' => $name,
                            'meta_keyword' => "{$name}, Shanghai ZHSU, ống inox, ống PPR",
                            'meta_description' => "Thông số kỹ thuật sản phẩm {$name} Shanghai ZHSU",
                            'updated_at' => now(),
                        ]);

                    // Ensure pivot exists
                    $pivotExists = DB::table('product_catalogue_product')
                        ->where('product_id', $productId)
                        ->where('product_catalogue_id', $catalogueId)
                        ->exists();

                    if (!$pivotExists) {
                        DB::table('product_catalogue_product')->insert([
                            'product_id' => $productId,
                            'product_catalogue_id' => $catalogueId,
                        ]);
                    }

                    $updated++;
                } else {
                    // Create new product
                    $productId = DB::table('products')->insertGetId([
                        'product_catalogue_id' => $catalogueId,
                        'image' => $image,
                        'publish' => 2,
                        'follow' => 2,
                        'order' => 0,
                        'user_id' => 1,
                        'code' => $code,
                        'made_in' => 'Shanghai ZHSU',
                        'price' => 0,
                        'stock' => 999,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // Insert product_language
                    DB::table('product_language')->insert([
                        'product_id' => $productId,
                        'language_id' => 1,
                        'name' => $name,
                        'canonical' => $canonical,
                        'description' => $description,
                        'content' => $content,
                        'meta_title' => $name,
                        'meta_keyword' => "{$name}, Shanghai ZHSU, ống inox, ống PPR",
                        'meta_description' => "Thông số kỹ thuật sản phẩm {$name} Shanghai ZHSU",
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // Insert product_catalogue_product pivot
                    DB::table('product_catalogue_product')->insert([
                        'product_id' => $productId,
                        'product_catalogue_id' => $catalogueId,
                    ]);

                    // Insert router
                    DB::table('routers')->insert([
                        'canonical' => $canonical,
                        'module_id' => $productId,
                        'controllers' => 'App\Http\Controllers\Frontend\ProductController',
                        'language_id' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $imported++;
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $this->command->error("Failed to import {$name}: " . $e->getMessage());
            }
        }

        $this->command->info("Shanghai ZHSU Product Seeder completed! Imported: {$imported}, Updated: {$updated}. Category ID: {$catalogueId}");
    }
}
