@extends('layouts.app')

@section('content')

    <div class="container">

        <table class="table table-striped">
            <tr>
                <th> ID </th>
                <th> Title</th>
                <th> Description </th>
                <th> Shop title </th>

            </tr>
                <tr>
                    <td>{{ $category->id }} </td>
                    <td>{{ $category->title }} </td>
                    <td>{!! $category ->description !!} </td>
                    <td>{{ $category->shopTitle->title }}</td>
                </tr>
        </table>

        </div>

@endsection
