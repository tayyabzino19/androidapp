<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::with('category')->get();
        return view('videos.index', compact('videos'));
    }







    public function create()
    {
        $categories = Category::where('status', 'active')->get();
        return view('videos.create', compact('categories'));
    }






    public function edit($id)
    {

        $video =  Video::findOrFail($id);
        $categories = Category::where('status', 'active')->get();
        return view('videos.edit', compact('video', 'categories'));
    }



    public function delete(Request $request)
    {

        $request->validate([
            'id' => 'required',
        ]);

        $find =  Video::findOrFail($request->id);




        if ($find->delete()) {
            return redirect()->back()->with('success', ' Video Deleted');
        } else {
            return redirect()->back()->with('error', 'Error While Deleting Video');
        }
    }





    public function save(Request $request)
    {
        $request->validate([

            'title' => 'required|unique:videos,title|max:250',
            'status' => 'required',
            'category' => 'required|numeric|min:1',
            'video' => 'required|mimes:mp3,mp4|max:8048',

        ]);

        if ($request->status == 1) {
            $status = 'active';
        } else {
            $status = 'inactive';
        }

        if ($request->hasFile('video')){
            $filenameWithExt = $request->file('video')->getClientOriginalName();
            // Get Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just Extension
            $extension = $request->file('video')->getClientOriginalExtension();
            // Filename To store
            $new_name = str_replace(' ', '_', $request->title);
            $fileNameToStore = $new_name . time() . '.' . $extension;
            $path = $request->file('video')->storeAs("public/", $fileNameToStore);

            $command = "design/ffmpeg";
            $tmp = $_FILES['video']['tmp_name'];
            $img = 'Thumbnail_' . $new_name . time() . '.jpg';
            $size = '80x90';
            $size = '300x300';
            $second = 5;
            $cmd = "$command -i $tmp -an -ss $second -s $size $img";
            system($cmd);
            $command2 = "design/ffmpeg";
            $tmp2 = $_FILES['video']['tmp_name'];
            $img2 = 'Thumbnail2_' . $new_name . time() . '.jpg';
            $size2 = '80x90';
            $size2 = '300x300';
            $second2 = 5;
            $cmd2 = "$command2 -i $tmp2 -an -ss $second2 -s $size2 $img2";
            system($cmd2);
            $thumbnail = $img;
            $thumbnail2 = $img2;
        }else{
            $fileNameToStore = 'Dummy.mp3';
            $thumbnail = 'no_img.png';
            $thumbnail2 = 'no_img.png';
        }


        $video = new Video;
        $video->title  = $request->title;
        $video->status = $status;

        $video->category_id =  $request->category;
        $video->source =  $fileNameToStore;
        $video->thumbnail = $thumbnail;
        //-- Saving Thumbnail for 300 x 300
        $video->thumbnail300 = $thumbnail2;

        if ($video->save()) {

            return redirect()->route('videos.index')->with('success', 'New Video Added');
        } else {
            return redirect()->back()->with('error', 'Error While Adding Video');
        }
    }


    public function update(Request $request)
    {

        $request->validate([
            'video_id' => 'required|numeric|min:1',
            'video' => 'required|mimes:mp3,mp4|max:8048',
        ]);

        $find =  Video::findOrFail($request->video_id);



        if ($request->status == 1) {
            $status = 'active';
        } else {
            $status = 'inactive';
        }

        if ($request->hasFile('video')){
            $filenameWithExt = $request->file('video')->getClientOriginalName();
            // Get Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just Extension
            $extension = $request->file('video')->getClientOriginalExtension();
            // Filename To store
            $new_name = str_replace(' ', '_', $request->title);
            $fileNameToStore = $new_name . time() . '.' . $extension;
            $path = $request->file('video')->storeAs("public/", $fileNameToStore);

            $command = "design/ffmpeg";
            $tmp = $_FILES['video']['tmp_name'];
            $img = 'Thumbnail_' . $new_name . time() . '.jpg';
            $size = '80x90';
            $size = '300x300';
            $second = 5;
            $cmd = "$command -i $tmp -an -ss $second -s $size $img";
            system($cmd);
            $command2 = "design/ffmpeg";
            $tmp2 = $_FILES['video']['tmp_name'];
            $img2 = 'Thumbnail2_' . $new_name . time() . '.jpg';
            $size2 = '80x90';
            $size2 = '300x300';
            $second2 = 5;
            $cmd2 = "$command2 -i $tmp2 -an -ss $second2 -s $size2 $img2";
            system($cmd2);
            $thumbnail = $img;
            $thumbnail2 = $img2;
        }else{
            $fileNameToStore = $find->source;
            $thumbnail = $find->thumbnail;
            $thumbnail2 = $find->thumbnail300;
        }

        $find->title  = $request->title;
        $find->status = $status;
        $find->category_id =  $request->category;
        $find->source =  $fileNameToStore;
        $find->thumbnail = $thumbnail;
        $find->thumbnail300 = $thumbnail2;

        if ($find->save()) {

            return redirect()->route('videos.index')->with('success', 'Video Updated');
        } else {
            return redirect()->back()->with('error', 'Error While Updating Video');
        }



    }



    public function apivideos($key)
    {

         $user = User::where('key',$key)->first();
         if($user == null){
             return 'Invalid Access';
         }else{
            $videos = Video::with('category')->where('status','active')->get();
            return $videos;
         }




        return view('videos.index', compact('videos'));
    }


}
