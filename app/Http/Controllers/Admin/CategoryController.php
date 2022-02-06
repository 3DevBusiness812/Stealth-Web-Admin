<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;

use DataTables;
use DB;
use Session;
use Validator;

class CategoryController extends Controller
{
    //

    public function index(){

        $category = new Category();
        $category_count = $category->getAllCategory_count();

        return view('category.category_list')->with('category_count', $category_count);

    }

    public function list_category_dt(Request $request)
    {

        $category = new Category();
        $get_category = $category->getAllCategory();
        return Datatables::of($get_category)->make(true);

    }

    public function create_category()
    {
        return view('category.create_category');        
    }

    public function store_category(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'categoryname' => 'required|unique:categories'
        ]);

        if($validator->fails())
        {
            $errors = $validator->errors()->toArray();

            if(isset($errors['categoryname'][0]))
            {
                $error_message = "This category name has already been taken.";
            }
            else
            {
                $error_message = 'Failed, Validation error';
            }

            Session::flash('error_message', $error_message);
            return redirect('admin/create_category')->withErrors($validator)->withInput();
            
        }
        else
        {

            $category = new Category();
            $category->categoryname = $request->input('categoryname');
            $category->save();
            Session::flash('message', 'The category has been added successfully.');
            return redirect('admin/list_category');

        }

        exit(0);

    }

    public function edit_category($id)
    {
        $category = Category::find($id);
        if(isset($category))
        {
            return view('category.edit_category')->with('category', $category);        
        }
        else
        {
            Session::flash('message', 'Category not found');
            return redirect('admin/list_category');
        }
    }

    public function update_category($id, Request $request)
    {

        $category = Category::find($id);
        if(isset($category))
        {

            $category->categoryname = $request->input('categoryname');
            $category->save();

            Session::flash('message', 'The category has been updated successfully.');
            return redirect('admin/list_category');

        }
        else
        {
            Session::flash('message', 'Category not found');
            return redirect('admin/list_category');
        }

    }

}
