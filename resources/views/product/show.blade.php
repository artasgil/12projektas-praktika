@extends('layouts.app')

@section('content')

<div class="container">
        <table class="table table-striped">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Excertpt</th>
                <th>Description</th>
                <th>Price</th>
                <th>Category title</th>
                <th>Product image</th>


            </tr>
                <tr>
                    <td>{{ $product->id }} </td>
                    <td>{{ $product->title }} </td>
                    <td>{!! $product->excertpt !!} </td>
                    <td>{!! $product ->description !!} </td>
                    <td>{{ $product ->price}} $</td>
                    <td>{{ $product->productCategory->title }}</td>
                    <td><img src="{{$product->image}}" alt="{{$product->title}}" width="100" height="100"></td>
                </tr>
        </table>
    </div>


@endsection
