<?php

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
const content = <<<EOD
<div style="color:#be2120; font-size:22px; margin-bottom:20px; margin-left:0px; margin-right:0px; margin-top:25px">高豐海產誠摯邀請您</div>
<div style="color:#707070; font-size:16px; line-height:24px">職人海鮮盡在高豐<br>
展出日期：2019/06/19~06/22 ｜ 攤位位置•B0336（由B出入口進入.面對台北101金融中心<br>
展場資訊：台北世貿展覽一館（地址: 臺北市信義路五段五號<br>
聯絡我們：<br>
+886-2-22901180<br>
http://www.hi-rich.com.tw<br>
hi.rich@msa.hinet.net</div>
EOD;
  
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        News::truncate();

        $newsCatIds = \App\Models\Category\NewsCategory::main()->get()->pluck('id')->toArray();

        $maxId = max($newsCatIds);
        $minId = min($newsCatIds);

        foreach (range(1, 30) as $value) {
            $weeksBeforeFromNow = random_int(-10, -1);
            $weeksAfterFromNow = random_int(1, 3);

            factory(News::class)->create([
                'cat_id' => random_int($minId, $maxId),
                'body' => self::content,
                'published_since' => \Carbon\Carbon::parse($weeksBeforeFromNow . ' weeks'),
                'published_until' => \Carbon\Carbon::parse($weeksAfterFromNow . ' weeks')
            ]);
        }
    }
}
