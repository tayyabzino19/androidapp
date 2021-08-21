<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoController extends Controller
{


    public function index()
    {
        $videos = Video::with('category')->orderBy('priority', 'asc')->get();
        return view('videos.index', compact('videos'));
    }







    public function create()
    {
        $getLastSortid = Video::select('priority')->orderby('priority', 'desc')->first();
        $categories = Category::where('status', 'active')->get();

        if ($getLastSortid) {

            $priority = $getLastSortid->priority;
        } else {
            $priority =  0;
        }
        return view('videos.create', compact('categories', 'priority'));
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

        $path = public_path() . '/storage/data/' . $find->source;

        // $path = "public/storage/videos/".$find->source;
        $thumbnail = public_path() . '/' . $find->thumbnail;


        if (File::exists($path)) {
            File::delete($path);
            File::delete($thumbnail);

        } else {
            $find->delete();
            return redirect()->back()->with('error', "Deleted But File Not Exists");
        }



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
            'video' => 'required|mimes:mp4|max:6048',
            'priority' => 'required|numeric',

        ]);





        if ($request->status == 1) {
            $status = 'active';
        } else {
            $status = 'inactive';
        }

        if ($request->hasFile('video')) {
            $prefix =  'vd-';

            $lastVideo = Video::orderBy('number','desc')->first();
            if ($lastVideo != null) {
                $newName =  $lastVideo->number + 1;
            } else {
                $newName =  0;
                $prefix =  'vd-';
            }



            $filenameWithExt = $request->file('video')->getClientOriginalName();
            // Get Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just Extension
            $extension = $request->file('video')->getClientOriginalExtension();
            // Filename To store
            $new_name = str_replace(' ', '_', $request->title);

            $fileNameToStore = $prefix . ($newName) . '.' . $extension;

            $path = $request->file('video')->storeAs("public/data", $fileNameToStore);
            //$path = $request->file('video')->move(public_path('storage/data/'), $fileNameToStore);


            $command = "/usr/bin/ffmpeg";
            $tmp = $_FILES['video']['tmp_name'];
            $img = 'Thumbnail_' . $newName . '.jpg';
            $size = '300x300';
            $second = 5;
            $cmd = "$command -i $tmp -an -ss $second -s $size $img";
            system($cmd);
            $thumbnail = $img;
        } else {
            $fileNameToStore = 'Dummy.mp3';
            $thumbnail = 'no_img.png';
            $prefix = 0;
            $newName = 0;
        }


        $video = new Video;
        $video->title  = $request->title;
        $video->status = $status;
        $video->priority = $request->priority;
        $video->category_id =  $request->category;
        $video->source =  $fileNameToStore;
        $video->thumbnail = $thumbnail;
        $video->video_prefix = $prefix;
        $video->number = $newName;
        //-- Saving Thumbnail for 300 x 300



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
            'video' => 'mimes:mp4|max:6048',
        ]);

        $find =  Video::findOrFail($request->video_id);



        if ($request->status == 1) {
            $status = 'active';
        } else {
            $status = 'inactive';
        }

        if ($request->hasFile('video')) {

            $prefix =  'vd-';
            //$lastVideo = Video::select('number')->orderBy('id', 'asc')->first();
            $lastVideo = Video::orderBy('number','desc')->first();
            $newName =  $lastVideo->number+1;



            $filenameWithExt = $request->file('video')->getClientOriginalName();
            // Get Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just Extension
            $extension = $request->file('video')->getClientOriginalExtension();
            // Filename To store
            $new_name = str_replace(' ', '_', $request->title);

            $fileNameToStore = $prefix . ($newName) . '.' . $extension;
            //$fileNameToStore = $new_name . time() . '.' . $extension;
            //$fileNameToStore = $prefix . ($newName) . '.' . $extension;
            //$delpath = asset('storage/data').'/'.$find->source;
            // $path = public_path() . '/storage/data/' . $find->source;
            // File::delete($path);

            File::delete(public_path($find->thumbnail));

            File::delete(public_path('storage/data/'.$find->source));




            $path = $request->file('video')->storeAs("public/data", $fileNameToStore);

            // Delete Video Files


            // Delete Video Thumbnails



            $command = "/usr/bin/ffmpeg";
            $tmp = $_FILES['video']['tmp_name'];
            $img = 'Thumbnail_' . $newName.'.jpg';
            $size = '300x300';
            $second = 5;
            $cmd = "$command -i $tmp -an -ss $second -s $size $img";
            system($cmd);

            $thumbnail = $img;
            $find->number = $newName;
        } else {
            $fileNameToStore = $find->source;
            $thumbnail = $find->thumbnail;

        }



        $find->title  = $request->title;
        $find->status = $status;
        $find->category_id =  $request->category;
        $find->source =  $fileNameToStore;
        $find->thumbnail = $thumbnail;

        $find->priority = $request->priority;



        if ($find->save()) {

            // Delete Old Video File


            return redirect()->route('videos.index')->with('success', 'Video Updated');
        } else {
            return redirect()->back()->with('error', 'Error While Updating Video');
        }
    }



    public function apivideos($key,$catId)
    {

        $category = Category::findOrFail($catId);
        if($category){
            $user = User::where('key',$key)->first();
            if ($user == null) {
                return 'Invalid Access';
            } else {
                $videos = Video::select('title','thumbnail','source','category_id','priority','created_at')->where('status', 'active')->where('category_id',$catId)->get();
                return response()->json([$videos]);
            }

        }




    }
}
