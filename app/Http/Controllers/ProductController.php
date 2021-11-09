<?php

namespace App\Http\Controllers;
use App\Category;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $products = Product::all();
        $categories = Category::all();
        $category_id = $request->category_id;
        $amountmin = $request->amountmin;
        $amountmax = $request->amountmax;
        $minValue = Product::min('price');
        $maxValue = Product::max('price');
        $refreshmin = $amountmin;
        $refreshmax = $amountmax;

        if(!$amountmin && !$amountmax){
            $amountmin = 0;
            $refreshmin = $amountmin;
            $amountmax = $maxValue;
            $refreshmax = $amountmax;
        }


        $products = Product::sortable()->paginate(10);




        if($category_id!='all' && $amountmin && $amountmax)
        {
            $products = Product::sortable()->where('category_id', $category_id)->whereBetween('price', [$amountmin, $amountmax])->paginate(10);
        }



        return view('product.index', ['products'=> $products, "categories" => $categories, "category_id" => $category_id, "amountmin" => $amountmin,
                     "amountmax"=>$amountmax, 'refreshmin' =>$refreshmin, 'refreshmax' => $refreshmax]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = Category::all();
        return view('product.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $categories = Category::all();
        $categories_count = $categories->count();

        $product = new Product;

        $validateVar = $request->validate([
            'product_title' => 'required|regex:/^[\pL\s]+$/u|unique:products,title|min:6|max:225',
            'product_excertpt' => 'required|max:600',
            'product_description' => 'required|max:1500',
            'product_price' => 'required|numeric|gt:0',
            'product_logo' => 'image|mimes:jpg,jpeg,png',
            'product_category' => 'required|numeric|gt:0|lte:'.$categories_count,

        ]);

        $product->title = $request->product_title;
        $product->excertpt = $request->product_excertpt;
        $product->description = $request->product_description;
        $product->price = $request->product_price;
        $product->category_id = $request->product_category;

        if($request->has('product_logo'))
        {
            $imageName = time().'.'.$request->product_logo->extension();
            $product->image = '/images/'.$imageName;
            $request->product_logo->move(public_path('images'), $imageName);

         } else {

            $product->image = '/images/noimage.png';
        }

        $product->save();
        return redirect()->route("product.index");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('product.show',["product" => $product]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('product.edit', ['categories' => $categories, 'product'=>$product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $categories = Category::all();
        $categories_count = $categories->count();


        $validateVar = $request->validate([
            'product_title' => 'required|regex:/^[\pL\s]+$/u|min:6|max:225',
            'product_excertpt' => 'required|max:600',
            'product_description' => 'required|max:1500',
            'product_price' => 'required|gt:0',
            'product_logo' => 'image|mimes:jpg,jpeg,png',
            'product_category' => 'required|numeric|gt:0|lte:'.$categories_count,

        ]);

        $product->title = $request->product_title;
        $product->excertpt = $request->product_excertpt;
        $product->description = $request->product_description;
        $product->price = $request->product_price;
        $product->category_id = $request->product_category;

        if($request->has('product_logo'))
        {
            $imageName = time().'.'.$request->product_logo->extension();
            $product->image = '/images/'.$imageName;
            $request->product_logo->move(public_path('images'), $imageName);

         } else {

            $product->image = '/images/noimage.png';
        }

        $product->save();
        return redirect()->route("product.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route("product.index");
    }
}
