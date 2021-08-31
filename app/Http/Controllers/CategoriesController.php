<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::orderby('priority', 'asc')->get();

        $getLastSortid = Category::select('priority')->orderby('priority','desc')->first();


        return view('categories.index', compact('categories','getLastSortid'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:categories,name|max:250',
            'status' => 'required',
            'prioty' => 'required|numeric|min:1',
            'photo' => 'required|image|mimes:jpg,png',
        ]);


        $category = new Category;
        $getprioty = Category::select('priority')->first();

        if ($getprioty == '') {
            $prioty = 1;
        } else {
            $prioty = $request->prioty;
        }





        if ($request->status == 1) {
            $status = 'active';
        } else {
            $status = 'inactive';
        }

        $category->name = $request->name;
        $category->priority = $prioty;
        $category->status = $status;

        if ($category->save()) {

            if ($request->hasFile('photo')){
                $filenameWithExt = $request->file('photo')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('photo')->getClientOriginalExtension();
                $fileNameToStore = 'cat_' . $category->id . '.' . $extension;
                $upload_status = $request->file('photo')->storeAs("public/data/", $fileNameToStore);

            }else{

                $fileNameToStore = 'dummy.png';


            }
            $cat =  Category::find($category->id);
            $cat->icon = $fileNameToStore;
            $cat->save();

            return redirect()->back()->with('success', 'New Category Added');
        } else {
            return redirect()->back()->with('error', 'Error While Adding Category');
        }
    }


    public function delete(Request $request)
    {

        $request->validate([
            'id' => 'required',
        ]);

        $find =  Category::findOrFail($request->id);
        if ($find->delete()) {
            return redirect()->back()->with('success', ' Category Deleted');
        } else {
            return redirect()->back()->with('error', 'Error While Adding Category');
        }
    }

    public function edit($id)
    {

        $category =  Category::findOrFail($id);

        return view('categories.edit', compact('category'));
    }



    public function update(Request $request)
    {

        $request->validate([
            'name' => 'required|max:250',
            'status' => 'required',
            'priority' => 'required',
            'id'=>'required',
            'update_photo' => 'image|mimes:jpg,png',


        ]);
        $category =  Category::findOrFail($request->id);
        if ($request->status == 1) {
                $status = 'active';
            }else {
                $status = 'inactive';
            }

        $category->name = $request->name;
        $category->status = $status;
        $category->priority = $request->priority;


        if ($category->save()) {



            if ($request->hasFile('update_photo')){
                $filenameWithExt = $request->file('update_photo')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('update_photo')->getClientOriginalExtension();
                $fileNameToStore = 'cat_' . $category->id . '.' . $extension;
                $upload_status = $request->file('update_photo')->storeAs("public/data/", $fileNameToStore);

            }else{

                $fileNameToStore = $category->icon;


            }
            $update_cat =  Category::find($category->id);
            $update_cat->icon = $fileNameToStore;

            $update_cat->save();

            return redirect()->back()->with('success', 'Category Updated');
        } else {
            return redirect()->back()->with('error', 'Error While Updating Category');
        }
    }


    public function categories($key)
    {

         $user = User::where('key',$key)->first();
         if($user == null){
             return 'Invalid Access';
         }else{
            $categories = Category::Select('name','priority','created_at','id')->where('status','active')->get();


            return response()->json([$categories]);


         }
    }



}
