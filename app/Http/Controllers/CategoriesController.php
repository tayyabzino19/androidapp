<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::orderby('priority', 'asc')->get();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:categories,name|max:250',
            'status' => 'required',
            'prioty' => 'required|numeric|min:1',

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
            return redirect()->back()->with('success', 'Category Updated');
        } else {
            return redirect()->back()->with('error', 'Error While Updating Category');
        }
    }
}
