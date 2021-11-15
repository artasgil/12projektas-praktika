@extends('layouts.app')
{{-- <style>
.price-range-slider {
  width: 100%;
  float: left;
  padding: 10px 20px;
}
.price-range-slider .range-value {
  margin: 0;
}
.price-range-slider .range-value input {
  width: 100%;
  background: none;
  color: #000;
  font-size: 16px;
  font-weight: initial;
  box-shadow: none;
  border: none;
  margin: 20px 0 20px 0;
}
.price-range-slider .range-bar {
  border: none;
  background: #000;
  height: 3px;
  width: 96%;
  margin-left: 8px;
}
.price-range-slider .range-bar .ui-slider-range {
  background: #06b9c0;
}
.price-range-slider .range-bar .ui-slider-handle {
  border: none;
  border-radius: 25px;
  background: #fff;
  border: 2px solid #06b9c0;
  height: 17px;
  width: 17px;
  top: -0.52em;
  cursor: pointer;
}
.price-range-slider .range-bar .ui-slider-handle + span {
  background: #06b9c0;
}
</style> --}}

@section('content')


    <div class="container">
        {{$refreshmin}}

        {{$refreshmax}}

        <div class="form-row">
            <div class="form-group">
            <a href="{{route('product.create')}}" class="btn btn-success">Add product</a>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <button class= "btn btn-primary" type = "submit" id="addfirst">Add Product AJAX</button>
            </div>
        </div>

        <div class="ajaxForm " >

            <div class="form-group row">
                <label for="book_title"
                    class="col-md-4 col-form-label text-md-right">{{ __('Product title') }}</label>

                <div class="col-md-6">
                    <input id="product_title" type="text" class="form-control @error('product_title') is-invalid @enderror" name="product_title" autofocus>
                        @error('product_title')
                        <span role="alert" class="invalid-feedback">
                            <strong>*{{$message}}</strong>
                        </span>
                        @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="product_excertpt"
                    class="col-md-4 col-form-label text-md-right">{{ __('Product excertpt') }}</label>

                <div class="col-md-6">
                    <textarea class="summernote @error('product_excertpt') is-invalid @enderror" cols="38" rows="5" name="product_excertpt"> </textarea>
                        @error('product_excertpt')
                        <span role="alert" class="invalid-feedback">
                            <strong>*{{$message}}</strong>
                        </span>
                        @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="product_description"
                    class="col-md-4 col-form-label text-md-right">{{ __('Product description') }}</label>

                <div class="col-md-6">
                    <textarea class="summernote @error('product_description') is-invalid @enderror" cols="38" rows="5" name="product_description"> </textarea>
                        @error('product_description')
                        <span role="alert" class="invalid-feedback">
                            <strong>*{{$message}}</strong>
                        </span>
                        @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="product_price"
                    class="col-md-4 col-form-label text-md-right">{{ __('Product Price') }}</label>

                <div class="col-md-2">
                    <div class="input-group">
                    <input id="book_isbn" type="integer" class="form-control @error('product_price') is-invalid @enderror" name="product_price" autofocus>
                        <span class="input-group-text">$</span>
                      </div>
                        @error('product_price')
                        <span role="alert" class="invalid-feedback">
                            <strong>*{{$message}}</strong>
                        </span>
                        @enderror
                </div>
            </div>
            <div class="form-group row">

                <label for="product_logo"
                    class="col-md-4 col-form-label text-md-right">{{ __('Product logo') }}</label>
                <div class="col-md-6">
                    <input id="imageurl" type="file" class="form-control @error('product_logo') is-invalid @enderror" name="product_logo">
                    @error('product_logo')
                    <span role="alert" class="invalid-feedback">
                        <strong>*{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="product_category"
                    class="col-md-4 col-form-label text-md-right">{{ __('Product Category') }}</label>
                <div class="col-md-6">
                    <select class="form-control @error('product_category') is-invalid @enderror" name="product_category">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                    @error('product_category')
                    <span role="alert" class="invalid-feedback">
                        <strong>*{{$message}}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Create') }}
                    </button>
                </div>
            </div>



        <form action="{{ route('product.index') }}" method="GET">
            @csrf
            <div class="form-row">
                <label for="product_title" class="col-form-label text-md-right">{{ __('Filter by title category and price: ') }}</label>
                <div class="form-group col-md-2">
                    <select class="form-control" name="category_id">
                        <option value="all" @if ($category_id == 'all') selected @endif > Visi </option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if ($category_id == $category->id) selected @endif>{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

            <div class="form-group">
                <label for="price_range">{{ __('Price range now: ') }}</label>
                <input style="border: none; background: none; box-shadow: none; "  type="text" id="amountslider" readonly>
            </div>
            <div class="form-group">
                <label for="price_range">{{ __('Change price range: ') }}</label>
                <input  type="text" maxlength="5" id="amount" name="amountmin" > -
                <input  type="text" id="amount2" name="amountmax" >
             </div>

            <div class="form-group">
            <div id="slider-range" type="range" class="form-control-range col-4" >
            </div>
            </div>


            <div class="form-group">
         <button type="submit" class="btn btn-info">Filter</button>
        </form>

         <a  href="{{ route('product.index') }}" name="clear" class="btn btn-info">Clear filter </a>

         <form method="get" action="{{route('products.pdf')}}">
            <input style="display:none" name="sort" value='{{$sort}}'  />
            <input style="display:none" name="direction" value='{{ $direction }}' />
            <input style="display:none" name="category_id" value='{{ $category_id }}' />
            <input style="display:none" name="amountmin" value='{{ $amountmin }}' />
            <input style="display:none" name="amountmax" value='{{ $amountmax }}' />

            <button class="btn btn-dark">Export products table to pdf </button>
         </form>
            </div>

        <table class="table table-striped">
            <tr>
                <th width="80px"> @sortablelink('id','ID') </th>
                <th> @sortablelink('title','Title') </th>
                <th> @sortablelink('excertpt','Excertpt') </th>
                <th width="210px"> @sortablelink('description','Description') </th>
                <th> @sortablelink('price','Price') </th>
                <th>@sortablelink('productCategory.title','title') </th>
                <th>Product shop title</th>
                <th> Action </th>
                <th> Delete </th>
            </tr>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }} </td>
                    <td>{{ $product->title }} </td>
                    <td>{!! $product->excertpt !!} </td>
                    <td>{!! $product ->description !!} </td>
                    <td>{{ $product ->price}} $</td>
                    <td>{{ $product->productCategory->title }}</td>
                    <td>{{ $product->productCategory->shopTitle->title }}</td>


                    <td>
                        <div class="btn-group-vertical">
                            <a href="{{ route('product.show', [$product]) }}" class="btn btn-secondary">Show </a>
                            <a href="{{ route('product.edit', [$product]) }}" class="btn btn-primary">Edit </a>
                        </div>
                        <td>
                        <form method="post" action={{ route('product.destroy', [$product]) }}>
                            @csrf
                            <div class="form-row">
                                <div class="form-group col">
                            <button type="submit" class="btn btn-danger">DELETE</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

        {{-- {{$book->links()}} --}}

            {!! $products->appends(Request::except('page'))->render() !!}
        </div>
        {{--  1.07 EINA NUO VIENETO--}}
        {{--  2.98 eina nuo 2--}}
        {{$minValue}}
        <script>
'use strict'
    // var integerParts = parseInt({{$refreshmax}});
    // var decimalPart = {{$refreshmax}} - integerParts;

    // var vienas = {{$refreshmax}}
            var minValue = {{$minValue}};
            minValue = Math.floor(minValue);

            var maxValue = {{$maxValue}};
            maxValue = Math.ceil(maxValue);

    // var number = {{$refreshmax}},
    // // decimalAsInt = Math.round((number - parseInt(number)) * 100);
    // decimalAsInt = Math.ceil(number);
    // var number2 = decimalAsInt ;

    // var fixedmax = Math.round( vienas * 100) / 100).toFixed(2)

    // if (decimalAsInt > 0) {
    // var prideti = {{$refreshmax}} +1;
    // } else {
    //     var prideti = {{$refreshmax}};
    // }

$(function () {
  $("#slider-range").slider({
    range: true,
    min: minValue,
    max: maxValue,
    values: [{{$refreshmin}} , {{$refreshmax}}],
    slide: function (event, ui) {
      $("#amountslider").val("$" + ui.values[0] + " - $" + ui.values[1]);

      $("#amount").val(ui.values[0]);
      $("#amount2").val(ui.values[1]);
    }
  });
  $("#amount").val(
      +
      $("#slider-range").slider("values", 0)
  );
  $("#amount2").val(
      +
  $("#slider-range").slider("values", 1)
  );

  $("#amountslider").val(
    "$" +
      $("#slider-range").slider("values", 0) +
      " - $" +
      $("#slider-range").slider("values", 1)
  );
});
    </script>


@endsection
