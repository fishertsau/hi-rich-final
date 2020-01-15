<?php

use App\Models\About;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
   
const content1 = <<<EOD
<p>高豐海產股份有限公司是由一群專業海產的熱誠團隊在2002年創立於台北。</p>
<br />
<p>豐富的海產經驗及誠信面對每個客戶；高豐與國外廠商及客戶之間建立良好的信譽，</p>
<p>歷經幾年來各界的支持，高豐團隊整合成立台北、台中和高雄地區營業據點，</p>
<p>以更廣親切的服務範圍行銷產品於全省各市場。</p>
<br />
<p>高豐海產以專業的眼光從世界各國進口數十種新鮮海產來符合各層級市場需求</p>
<p>每年更持續研發多種新產品來提升市場競爭力，</p>
<p>以各合理的價格成本創造雙贏互利合作關係。</p>
EOD;

const content2 = <<<EOD
<p>高豐嚴厲控管海產品質，從國外源頭至消費者手中，</p>
<p>每個環節小心且謹慎精選確保產品的品質加上專業的物流服務配合客戶要求，</p>
<p>以最有效益的時間送達目的地高豐本著<span style="color:#e88f13">「誠信、穩健、超越分享」</span>的經營理念，</p>
<p>以客戶至上的承諾為目標，以誠信合理的價格為原則，</p>
<p>供應穩定的貨源，持續為客戶創造更大的商機及美食的世界。</p>
EOD;

const content3 = <<<EOD
<p>2002年 高豐海產股份有限公司在2002年創立於台北，開始經營冷凍海鮮產品。</p>
<p>2002年 高豐成立南部營業據點--高雄營業所。</p>
<p>2002年 高豐開始進口第一項冷凍海鮮--草蝦。</p>
<p>2005年 高豐成立中部營業據點--台中營業所。</p>
<p>2010年 開始進口東南亞冷凍海鮮。</p>
<p>2010年 開始進口中美洲冷凍海鮮。</p>
<p>2019年 第一次參加食品展舉辦相關活動宣傳，成功打響高豐品牌並獲得廠商與消費者青睞。</p>
EOD;

const content4 = <<<EOD
<p>未來展望未來展望未來展望未來展望未來展望未來展望未來展望未來展望</p>
<p>未來展望未來展望未來展望未來展望未來展望未來展望未來展望未來展望</p>
<p>未來展望未來展望未來展望未來展望未來展望未來展望未來展望未來展望</p>
<p>未來展望未來展望未來展望未來展望未來展望未來展望未來展望未來展望</p>
EOD;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        About::truncate();

        factory(About::class)->create([
            'ranking' => 1,
            'published' => true, 
            'title' => '公司簡介',
            'photoPath' => $this->copyPhoto('c01.jpg') ,
            'body' => self::content1
        ]);

        factory(About::class)->create([
            'ranking' => 2,
            'published' => true,
            'title' => '公司理念',
            'photoPath' => $this->copyPhoto('c02.jpg'),
            'body' => self::content2
        ]);

        factory(About::class)->create([
            'ranking' => 3,
            'published' => true,
            'title' => '公司沿革',
            'photoPath' => $this->copyPhoto('c03.jpg'),
            'body' => self::content3
        ]);
        
        factory(About::class)->create([
            'ranking' => 4,
            'published' => true,
            'title' => '未來展望',
            'photoPath' => $this->copyPhoto('c04.jpg'),
            'body' => self::content4
        ]);
    }
    
    private function copyPhoto($fileName)
    {
        $newPhotoPath = str_random(40) . '.jpg';

        $targetOriginFile = public_path(config('filesystems.app.origin_abouts_image_baseDir') . '/' . $fileName);
        $targetDestFile = public_path(
            config('filesystems.app.public_storage_root') . '/images/' . $newPhotoPath);

        File::copy($targetOriginFile, $targetDestFile);

        return 'images/' . $newPhotoPath;
    }
}
