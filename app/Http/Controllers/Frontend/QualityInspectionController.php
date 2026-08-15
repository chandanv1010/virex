<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Services\V1\Core\SlideService;

class QualityInspectionController extends FrontendController
{
    protected $language;
    protected $system;
    protected $slideService;

    public function __construct(
        SlideService $slideService
    ) {
        $this->slideService = $slideService;
        parent::__construct();
    }

    public function index($id = null, Request $request = null)
    {
        $slideKeywords = [
            'quality-authorization',
            'quality-pccc-iso',
            'quality-pccc-smai',
            'quality-pccc-kqkn',
            'quality-inox',
            'quality-nhua',
            'quality-van'
        ];

        $slides = $this->slideService->getSlide($slideKeywords, $this->language);

        $seo = [
            'meta_title' => 'Kiểm định chất lượng & Ủy quyền phân phối - VIREX',
            'meta_description' => 'Xem chi tiết biên bản ủy quyền độc quyền phân phối và hồ sơ kiểm định chất lượng, tiêu chuẩn ISO, kết quả kiểm nghiệm sản phẩm VIREX.',
            'meta_keyword' => 'kiem dinh chat luong, giay uy quyen, iso, kqkn, smai, virex',
            'meta_image' => isset($slides['quality-authorization']['item'][0]['image']) ? $slides['quality-authorization']['item'][0]['image'] : '',
            'canonical' => write_url('kiem-dinh-chat-luong')
        ];

        $config = $this->config();
        $system = $this->system;
        $template = 'frontend.quality_inspection.index';

        return view($template, compact(
            'slides',
            'config',
            'seo',
            'system'
        ));
    }

    private function config()
    {
        return [
            'language' => $this->language,
            'css' => [],
            'js' => []
        ];
    }
}
