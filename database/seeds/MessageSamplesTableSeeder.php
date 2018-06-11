<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSamplesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $messageSamples = [
            [
                'name' => 'register_account_success',
                'content' => '0|Ban da dang ky tai khoan thanh cong'
            ],
            [
                'name' => 'update_account_success',
                'content' => '0|Ban da cap nhat tai khoan thanh cong'
            ],
            [
                'name' => 'register_fail',
                'content' => '3|Sai Command Code'
            ],
            [
                'name' => 'guide_register_ads',
                'content' => 'Tai khoan cua ban da duoc tao thanh cong. De xac nhan thong tin. Vui long soan theo cu phap TEN#CODE. Vi du: Nguyen Hung#123'
            ],
            [
                'name' => 'response_register_ads',
                'content' => 'Noi dung cua ban dang duoc phe duyet. Vui long ghe website: http://raobanmienphi.xyz để xem them chi tiet'
            ]
        ];
        DB::table('message_samples')->insert($messageSamples);
    }
}
