<?php

use App\Models\WebConfig;
use Illuminate\Database\Seeder;

class WebConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $webConfig = [
            // company info
            'company_name' => config('app.name'),
            'address' => config('app.address'),
            'tel' => config('app.phone'),
            'email' => config('app.email'),
            'fax' => config('app.fax'),
            'copyright_declare' => '©高豐海產股份有限公司',

            // marketing info
            'slogan' => config('app.slogan'),
            'slogan_sub' => config('app.slogan_sub'),
            'product' => '嚴選各國優質冷凍海鮮，產品類別有：蝦類、貝類、魚類、軟體類、甲殼類。 主要產地如下：加拿大、中美洲、智利、東南亞、台灣、日本、韓國、中國、俄羅斯。',
            'place' => '行銷通路有：餐廳、飯店、外燴、各盤商、漁市場攤商、大賣場、超市....等等。 主要夥伴大多為團購業務及電子商務業者，竭誠歡迎異業商談合作與結盟。',
            'service_week' => '星期一至星期五',
            'service_hour' => '上午8：30~12：30；下午1：30~5：30',

            // page info
            'title' => config('app.title')
        ];

        WebConfig::firstOrCreate()->update($webConfig);

        // logo
        $logoAPhotoPath = $this->copyPhoto(
            'logo-black.png',
            public_path(config('filesystems.app.origin_home_image_baseDir'))
        );

        $logoBPhotoPath = $this->copyPhoto(
            'logo-white.png',
            public_path(config('filesystems.app.origin_home_image_baseDir'))
        );

        WebConfig::firstOrCreate()->update([
            'logoA_photoPath' => $logoAPhotoPath,
            'logoB_photoPath' => $logoBPhotoPath,
        ]);
    }

    private function copyPhoto($fileName, $fileDir)
    {
        $newPhotoPath = str_random(40) . '.jpg';

        $targetOriginFile = $fileDir . '/' . $fileName;
        $targetDestFile = public_path(
            config('filesystems.app.public_storage_root') . '/images/' . $newPhotoPath);

        File::copy($targetOriginFile, $targetDestFile);

        return 'images/' . $newPhotoPath;
    }
}
