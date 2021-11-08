@extends('layouts.app')

@section('content')

    <div class="container">
        @if(session()->has('error_message'))
        <div class="alert alert-danger">
        {{session()->get("error_message")}}
        </div>
        @endif

        @if(session()->has('sucess_message'))
        <div class="alert alert-success">
        {{session()->get("sucess_message")}}
        </div>
        @endif


        <div class="form-row">
            <div class="form-group">
            <a href="{{route('shop.create')}}" class="btn btn-success">Add shop</a>
            </div>
        </div>

        <table class="table table-striped">
            <tr>
                <th width="80px"> @sortablelink('id','ID') </th>
                <th> @sortablelink('title','Title') </th>
                <th width="210px"> @sortablelink('description','Description') </th>
                <th>@sortablelink('email','Email') </th>
                <th>@sortablelink('phone','Phone') </th>
                <th>@sortablelink('country','Country') </th>
                <th> Action </th>
                <th> Delete </th>
            </tr>
            @foreach ($shops as $shop)
                <tr>
                    <td>{{ $shop->id }} </td>
                    <td>{{ $shop->title }} </td>
                    <td>{!! $shop ->description !!} </td>
                    <td>{{ $shop->email }}</td>
                    <td>{{ $shop->phone }}</td>
                    <td>{{ $shop->country }}</td>


                    <td>
                        <div class="btn-group-vertical">
                            <a href="{{ route('shop.show', [$shop]) }}" class="btn btn-secondary">Show </a>
                            <a href="{{ route('shop.edit', [$shop]) }}" class="btn btn-primary">Edit </a>
                        </div>
                        <td>
                        <form method="post" action={{ route('shop.destroy', [$shop]) }}>
                            @csrf
                            <div class="form-row">
                                <div class="form-group col">
                            <button type="submit" class="btn btn-danger">DELETE</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
            {!! $shops->appends(Request::except('page'))->render() !!}
        </div>
@endsection
