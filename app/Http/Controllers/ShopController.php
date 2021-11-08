<?php

namespace App\Http\Controllers;

use App\Shop;
use App\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = Shop::sortable()->paginate(10);

        return view('shop.index', ['shops'=>$shops]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shop.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $shop = new Shop;

        $validateVar = $request->validate([
            'shop_title' => 'required|regex:/^[\pL\s]+$/u|unique:shops,title|min:6|max:225',
            'shop_description' => 'required|max:1500',
            'shop_email' => 'required|email|max:255',
            'shop_phone' => 'required|numeric|max:15',
            'shop_country' => 'required|max:225',


        ]);

        $shop->title = $request->shop_title;
        $shop->description = $request->shop_description;
        $shop->email = $request->shop_email;
        $shop->phone = $request->shop_code.$request->shop_phone;
        $shop->country = $request->shop_country;


        $shop->save();
        return redirect()->route("shop.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        return view('shop.show', ['shop'=>$shop]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        return view('shop.edit', ['shop'=>$shop]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop)
    {
        $validateVar = $request->validate([
            'shop_title' => 'required|regex:/^[\pL\s]+$/u|min:6|max:225',
            'shop_description' => 'required|max:1500',
            'shop_email' => 'required|email|max:255',
            'shop_phone' => 'required|max:15',
            'shop_country' => 'required|max:225',

        ]);

        $shop->title = $request->shop_title;
        $shop->description = $request->shop_description;
        $shop->email = $request->shop_email;
        $shop->phone = $request->shop_phone;
        $shop->country = $request->shop_country;


        $shop->save();
        return redirect()->route("shop.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        $category_count = $shop->manyCategories->count();
        if($category_count!==0) {
            return redirect()->route("shop.index")->with('error_message','Shop can not be deleted, because has categories');
        }
        $shop->delete();
        return redirect()->route("shop.index")->with('sucess_message','Shop deleted successfully');
    }
}
