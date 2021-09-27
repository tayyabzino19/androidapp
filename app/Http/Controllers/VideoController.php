<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Lakshmaji\Thumbnail\Facade\Thumbnail;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\User;
use Illuminate\Support\Facades\File;

class VideoController extends Controller
{



    public function allvideos(Request $request)
    {

        $videos = Video::orderBy('priority', 'asc')->get();
        if ($request->ajax()) {

            $videos = Video::with('category')->get();
            return json_encode($videos);
        }
    }

    public function allvideos2()
    {


        $videos = Video::with('category')->orderBy('priority', 'asc')->get();
        //return json($videos);

        return response()->json(['data' => $videos]);
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
    public function index()
    {
        $categories  = Category::where('status', 'active')->get();
        $videos = Video::with('category')->orderBy('priority', 'asc')->get();
        return view('videos.index', compact('videos', 'categories'));
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
        $thumbnail = public_path() . '/storage/data/' . $find->thumbnail;


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
            $status = 'activated';
        } else {
            $status = 'inactive';
        }


        if ($request->hasFile('video')) {
            $lastVideo = Video::orderBy('number', 'desc')->first();
            $prefix =  'vd-';
            if ($lastVideo == null) {
                $newName =  0;
            } else {
                $newName =  $lastVideo->number + 1;
            }

            $filenameWithExt = $request->file('video')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('video')->getClientOriginalExtension();
            $fileNameToStore = $prefix . ($newName) . '.' . $extension;
            $upload_status = $request->file('video')->storeAs("public/data/", $fileNameToStore);
            if ($upload_status) {
                $thumbnail  = 'thumb-' . $newName . ".jpg";
                $thumbnail_status = Thumbnail::getThumbnail(public_path('storage/data/' . $fileNameToStore), public_path('storage/data/'), $thumbnail, 8);
            }
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
            $status = 'activated';
        } else {
            $status = 'inactive';
        }




        if ($request->hasFile('video')) {


            File::delete(public_path() . '/storage/data/' . $find->thumbnail);
            File::delete(public_path() . '/storage/data/' . $find->source);

            $prefix =  'vd-';
            //$lastVideo = Video::select('number')->orderBy('id', 'asc')->first();
            $lastVideo = Video::orderBy('number', 'desc')->first();
            $newName =  $lastVideo->number + 1;
            $filenameWithExt = $request->file('video')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just Extension
            $extension = $request->file('video')->getClientOriginalExtension();
            $fileNameToStore = $prefix . ($newName) . '.' . $extension;
            $upload_status = $request->file('video')->storeAs("public/data", $fileNameToStore);
            if ($upload_status) {
                $thumbnail  = 'thumb-' . $newName . ".jpg";
                $thumbnail_status = Thumbnail::getThumbnail(public_path('storage/data/' . $fileNameToStore), public_path('storage/data/'), $thumbnail, 1);
            }

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

    public function apivideos($catId)
    {

        $category = Category::where('id', $catId)->first();
        if ($category == null) {
            return response()->json([
                'status' => false,
                'message' => 'No record found'
            ]);
        }
        $videos = Video::select('title', 'thumbnail', 'source', 'category_id', 'priority', 'created_at')->where('status', 'activated')->where('category_id', $catId)->get();
        if ($videos == null) {

            return response()->json([
                'status' => true,
                'message' => 'Videos not found'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'data' => $videos
            ]);
        }
    }
}
