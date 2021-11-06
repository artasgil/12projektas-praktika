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
            <a href="{{route('category.create')}}" class="btn btn-success">Add category</a>
            </div>
        </div>

        <table class="table table-striped">
            <tr>
                <th width="80px"> @sortablelink('id','ID') </th>
                <th> @sortablelink('title','Title') </th>
                <th width="210px"> @sortablelink('description','Description') </th>
                <th>@sortablelink('shopTitle.title','Shop id title') </th>
                <th> Action </th>
                <th> Delete </th>
            </tr>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }} </td>
                    <td>{{ $category->title }} </td>
                    <td>{!! $category ->description !!} </td>
                    <td>{{ $category->shopTitle->title }}</td>

                    <td>
                        <div class="btn-group-vertical">
                            <a href="{{ route('category.show', [$category]) }}" class="btn btn-secondary">Show </a>
                            <a href="{{ route('category.edit', [$category]) }}" class="btn btn-primary">Edit </a>
                        </div>
                        <td>
                        <form method="post" action={{ route('category.destroy', [$category]) }}>
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

            {!! $categories->appends(Request::except('page'))->render() !!}
        </div>


@endsection
