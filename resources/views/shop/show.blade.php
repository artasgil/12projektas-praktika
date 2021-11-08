@extends('layouts.app')

@section('content')

    <div class="container">

        <table class="table table-striped">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Country</th>
            </tr>
                <tr>
                    <td>{{ $shop->id }} </td>
                    <td>{{ $shop->title }} </td>
                    <td>{!! $shop ->description !!} </td>
                    <td>{{ $shop->email }}</td>
                    <td>{{ $shop->phone }}</td>
                    <td>{{ $shop->country }}</td>
                </tr>
        </table>
        </div>
@endsection
