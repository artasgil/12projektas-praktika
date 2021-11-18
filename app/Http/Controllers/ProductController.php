<?php

namespace App\Http\Controllers;
use App\Category;
use App\Product;
use PDF;
use Validator;
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

        //Request pdf failui
        $sort = $request->sort;
        $direction = $request->direction;

        if(!$amountmin && !$amountmax){
            $amountmin = 0;
            $refreshmin = $amountmin;
            $amountmax = $maxValue;
            $refreshmax = $amountmax;
        }

        $products = Product::sortable()->paginate(10);

        if(!$category_id){
            $category_id='all';
        }

        if($category_id!='all' && $amountmin==$refreshmin && $amountmax==$refreshmax)  //PAGALVOTI KAS NEGERAI
        {
            $products = Product::sortable()->where('category_id', $category_id)->whereBetween('price', [$amountmin, $amountmax])->paginate(10);
        } else
        {
            $products = Product::sortable()->whereBetween('price', [$amountmin, $amountmax])->paginate(10);
        }



        return view('product.index', ['products'=> $products, "categories" => $categories, "category_id" => $category_id, "amountmin" => $amountmin,
                     "amountmax"=>$amountmax, 'refreshmin' =>$refreshmin, 'refreshmax' => $refreshmax, 'sort'=>$sort, 'direction'=>$direction, 'maxValue' =>$maxValue, 'minValue'=>$minValue]);
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

    public function generatePDF(Request $request)
    {

        $products = Product::all();

        $sortby=$request->sort;
        $collumnName = $request->direction;

        $amountmin = $request->amountmin;
        $amountmax = $request->amountmax;
        $maxValue = Product::max('price');
        $refreshmin = $amountmin;
        $refreshmax = $amountmax;

        $category_id = $request->category_id;


        if(empty($collumnName) && empty($sortby)) {
            $sortby = 'id';
            $collumnName = 'asc';
        }

        if(!$amountmin && !$amountmax){
            $amountmin = 0;
            $refreshmin = $amountmin;
            $amountmax = $maxValue;
            $refreshmax = $amountmax;
        }

        if(!$category_id){
            $category_id='all';
        }

        // $products = Product::orderBy($sortby, $collumnName)->get();

    if($category_id) {
        if($category_id == "all") {
            $products = Product::orderBy($sortby, $collumnName)->get();
        }
        else {
            $products = Product::orderBy($sortby, $collumnName)->where("category_id", $category_id)->get();
        }
    }

        if($category_id!='all' && $amountmin && $amountmax)  //PAGALVOTI KAS NEGERAI
        {
            $products = Product::orderBy($sortby, $collumnName)->where('category_id', $category_id)->whereBetween('price', [$amountmin, $amountmax])->get();
        } else
        {
            $products = Product::orderBy($sortby, $collumnName)->whereBetween('price', [$amountmin, $amountmax])->get();
        }


        // $products = Product::orderBy($sortby, $collumnName)->whereBetween('price', [$amountmin, $amountmax])->get();

        // $products = Product::where('category_id', $category_id)->whereBetween('price', [$amountmin, $amountmax])->orderBy($sortby, $collumnName)->get();


        // $products = Product::all();

        view()->share(['products'=> $products]);
        $pdf = PDF::loadView("pdf_template", $products);

        return $pdf->download("products.pdf");

    }

    public function indexstore(Request $request)
    {
        $categories = Category::all();
        $categories_count = $categories->count();

        $product = new Product;

        $input = [
            'product_title' => $request->product_title,
            'product_excertpt' => $request->product_excertpt,
            'product_description' => $request->product_description,
            'product_price' => $request->product_price,
            // 'product_logo' => $request->product_logo,
            'product_category' => $request->product_category
        ];

        $rules = [
            'product_title' => 'required|regex:/^[\pL\s]+$/u|unique:products,title|min:6|max:225',
            'product_excertpt' => 'required|max:600',
            'product_description' => 'required|max:1500',
            'product_price' => 'required|numeric|gt:0',
            'product_logo' => 'image|mimes:jpg,jpeg,png',
            'product_category' => 'required|numeric|gt:0|lte:'.$categories_count,
        ];

        $validator = Validator::make($input, $rules);

        if($validator->passes()) {
            $product->title = $request->product_title;
            $product->excertpt = $request->product_excertpt;
            $product->description = $request->product_description;
            $product->price = $request->product_price;
            $product->category_id = $request->product_category;

            // if($request->has('product_logo'))
            // {
            //     $imageName = time().'.'.$request->product_logo->extension();
            //     $input['product_logo'] = '/images/'.$imageName;
            //     $request->product_logo->move(public_path('images'), $imageName);

            //  } else {

                $product->image = '/images/noimage.png';
            // }


            $product->save();

            $success= ['success' => 'Product added successfully'];
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
