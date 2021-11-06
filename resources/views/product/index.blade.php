@extends('layouts.app')

@section('content')

    <div class="container">
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

                    <div class="form-group col-md-2">
                    <button type="submit" class="btn btn-info">Filter</button>
                    </div>
            </div>
        <table class="table table-striped">
            <tr>
                <th width="80px"> @sortablelink('id','ID') </th>
                <th> @sortablelink('title','Title') </th>
                <th> @sortablelink('excertpt','Excertpt') </th>
                <th width="210px"> @sortablelink('description','Description') </th>
                <th> @sortablelink('price','Price') </th>
                <th>@sortablelink('productCategory.title','title') </th>
                <th>Product shop</th>


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


@endsection
