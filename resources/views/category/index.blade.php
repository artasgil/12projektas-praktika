@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="alert alert-danger error-messages" style="display:none">
            <ul>
            </ul>
        </div>
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


        <div class="form-row">
            <div class="form-group">
                <button class= "btn btn-primary" type = "submit" id="addfirst">Add category AJAX</button>
            </div>
        </div>



        <div class="ajaxForm d-none" >

            <div class="form-group row">
                    <label for="category_title" class="col-md-4 col-form-label text-md-right">{{ __('Category title') }}</label>
            <div class="col-md-4">
                    <input class="form-control"  type = "text" name="category_title" id="category_title"/>
                    <span class="invalid-feedback category_title" role="alert">
                    <strong></strong>
                    </span>
            </div>
            </div>

            <div class="form-group row">
                <label for="category_description" class="col-md-4 col-form-label text-md-right">{{ __('Category description') }}</label>
                <div class="col-md-4">
            <textarea class="form-control" name="category_description" id="category_description"/>  </textarea>
            <span class="invalid-feedback category_description" role="alert">
                <strong></strong>
            </span>
        </div>
            </div>
            <div class="form-group row">
                <label for="category_shop"
                    class="col-md-4 col-form-label text-md-right">{{ __('Category shop') }}</label>
                    <div class="col-md-4">
                    <select class="form-control" name="category_shop" id="category_shop">
                        @foreach ($shops as $shop)
                            <option value="{{ $shop->id }}">{{ $shop->title }}</option>
                        @endforeach
                    </select>
                    <span class="invalid-feedback category_shop" role="alert">
                        <strong></strong>
                    </span>
                </div>
            </div>
                <div class="form-group row">
                    <div class="offset-md-4">
                <button class= "btn btn-primary" type = "submit" id="add">Add</button>
                    </div>
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



    <script>
            $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        }
    });

 $("#addfirst").click(function() {
     $(".ajaxForm").toggleClass("d-none");
    });
     $("#add").click(function() {
        var category_title = $("#category_title").val();
        var category_description = $("#category_description").val();
        var category_shop = $("#category_shop").val();
        console.log(category_shop);
        $.ajax({
            type: 'POST',
            url: '{{route("category.indexstore")}}',
            data: {category_title: category_title,  category_description: category_description, category_shop: category_shop },
            success: function(data) {

                if($.isEmptyObject(data.error)) {
                    $(".error-messages").css('display','none');
                    $(".invalid-feedback").css('display','none');
                    $(".ajaxForm").toggleClass("d-none");
                    alert(data.success);
                } else {

                    $(".error-messages ul").html('');
                    $(".error-messages").css('display','block');

                    $(".invalid-feedback").css('display','none');
                    $.each( data.error, function(key, error) {
                        var errorSpan = "." + key;
                        $(errorSpan).css('display', 'block');
                        $(errorSpan).html('');
                        $(errorSpan).append("<strong>"+error+"</strong");
                        $(".error-messages ul").append("<li>"+ error + "</li>");
                    })
                }
            }
        });
});


        </script>
@endsection
