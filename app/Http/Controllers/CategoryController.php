<?php

namespace App\Http\Controllers;

use App\Category;
use App\Shop;
use Validator;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = Shop::all();

        $categories = Category::sortable()->paginate(10);

        return view('category.index', ['categories'=> $categories, 'shops'=>$shops]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shops = Shop::all();
        return view('category.create', ['shops' => $shops]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $shops = Shop::all();
        $shops_count = $shops->count();

        $category = new Category;

        $validateVar = $request->validate([
            'category_title' => 'required|regex:/^[\pL\s]+$/u|unique:products,title|min:6|max:225',
            'category_description' => 'required|max:1500',
            'category_shop' => 'required|numeric|gt:0|lte:'.$shops_count,

        ]);

        $category->title = $request->category_title;
        $category->description = $request->category_description;
        $category->shop_id = $request->category_shop;

        $category->save();
        return redirect()->route("category.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view ('category.show', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $shops = Shop::All();

        return view('category.edit', ['category'=>$category, 'shops'=>$shops]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $shops = Shop::all();
        $shops_count = $shops->count();

        $validateVar = $request->validate([
            'category_title' => 'required|regex:/^[\pL\s]+$/u|unique:products,title|min:6|max:225',
            'category_description' => 'required|max:1500',
            'category_shop' => 'required|numeric|gt:0|lte:'.$shops_count,

        ]);

        $category->title = $request->category_title;
        $category->description = $request->category_description;
        $category->shop_id = $request->category_shop;

        $category->save();
        return redirect()->route("category.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $products_count = $category->manyProducts->count();
        if($products_count!==0) {
            return redirect()->route("category.index")->with('error_message','Category can not be deleted, because has products');
        }
        $category->delete();
        return redirect()->route("category.index")->with('sucess_message','Category deleted successfully');
    }

    public function indexstore(Request $request)
    {
        $shops = Shop::all();
        $shops_count = $shops->count();

        $input = [
            'category_title' => $request->category_title,
            'category_description' => $request->category_description,
        ];

        $rules = [
            'category_title' => 'required|regex:/^[\pL\s]+$/u|unique:products,title|min:6|max:225',
            'category_description' => 'required|max:1500',
            'category_shop' => 'numeric|gt:0|lte:'.$shops_count
        ];

        $validator = Validator::make($input, $rules);

        if($validator->passes()) {
            $category = new Category;
            $category->title = $request->category_title;
            $category->description = $request->category_description;
            $category->shop_id = $request->category_shop;

            $category->save();

            $success= ['success' => 'Category added successfully'];
            $success_json = response()->json($success);
            return $success_json;

        }

        $error = [
            'error' => $validator->messages()->get("*")
        ];

        $error_json = response()->json($error);

        return $error_json;

    }
}

