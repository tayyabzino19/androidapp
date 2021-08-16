<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Video;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $video = new Video;
        $video->title = "Demo Video";
        $video->status = "active";
        $video->source = '1';
        $video->thumbnail = '1';
        $video->category_id = 1;
        $video->save();

    }
}
