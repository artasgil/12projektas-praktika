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

            <div class="form-group">
                <label for="price_range">{{ __('Price range now: ') }}</label>
                      <input  type="text" id="amount" name="amountmin" hidden>
                      <input  type="text" id="amount2" name="amountmax" hidden>
                      <input style="border: none; background: none; box-shadow: none; "  type="text" id="amountslider" readonly>
             </div>

            <div class="form-group">
            <div id="slider-range" type="range" class="form-control-range col-4" >
            </div>
            </div>


            <div class="form-group">
         <button type="submit" class="btn btn-info">Filter</button>
            </div>
        </form>

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
        <script>
'use strict'
    // var integerParts = parseInt({{$refreshmax}});
    // var decimalPart = {{$refreshmax}} - integerParts;

    // var vienas = {{$refreshmax}}

    var number = {{$refreshmax}},
    decimalAsInt = Math.round((number - parseInt(number)) * 100);
    var number2 = decimalAsInt ;

    // var fixedmax = Math.round( vienas * 100) / 100).toFixed(2)

    if (decimalAsInt > 0) {
    var prideti = {{$refreshmax}} +1;
    } else {
        var prideti = {{$refreshmax}};
    }

$(function () {
  $("#slider-range").slider({
    range: true,
    min: {{$refreshmin}},
    max: prideti,
    values: [0 , {{$refreshmax}}],
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
