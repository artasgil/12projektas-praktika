<?php

namespace App\Http\Controllers;

use App\Shop;
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
            // 'shop_phone' => 'required|max:1500',
            'shop_country' => 'required|max:1500',


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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        //
    }
}
