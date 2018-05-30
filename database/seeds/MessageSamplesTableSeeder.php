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
                'content' => 'Chào bạn, để đăng ký thông tin rao vặt, vui lòng soạn nội dung theo cú pháp <tên>|<nội_dung>. Ví dụ: Cà phê|123 Tên Lửa'
            ],
            [
                'name' => 'response_register_ads',
                'content' => 'Nội dung rao vặt của bạn đã được gửi và đang chờ phê duyệt. Vui lòng ghé website: http://raobanmienphi.xyz để xem'
            ]
        ];
        DB::table('message_samples')->insert($messageSamples);
    }
}
