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
        <div class="form-row">
            <div class="form-group">
                <button class= "btn btn-primary" type = "submit" id="addfirst">Add Shop AJAX</button>
            </div>
        </div>

        <div class="ajaxForm d-none" >
            <div class="form-group row">
                <label for="shop_title"
                    class="col-md-4 col-form-label text-md-right">{{ __('Shop title') }}</label>

                <div class="col-md-4">
                    <input id="shop_title" type="text" class="form-control" name="shop_title" autofocus>
                    <span class="invalid-feedback shop_title" role="alert">
                        <strong></strong>
                        </span>
                </div>
            </div>
            <div class="form-group row">
                <label for="shop_description"
                    class="col-md-4 col-form-label text-md-right">{{ __('Shop description') }}</label>

                <div class="col-md-4">
                    <textarea class="summernote form-control" name="shop_description" id="shop_description"> </textarea>
                    <span class="invalid-feedback shop_description" role="alert">
                        <strong></strong>
                        </span>
                </div>
            </div>
            <div class="form-group row">
                <label for="shop_email"
                    class="col-md-4 col-form-label text-md-right">{{ __('Shop email') }}</label>

                <div class="col-md-4">
                    <input id="shop_email" type="text" class="form-control" name="shop_email" id="shop_email" autofocus>
                    <span class="invalid-feedback shop_email" role="alert">
                        <strong></strong>
                        </span>
                </div>
            </div>
            <div class="row">
                <label for="shop_phone" class="col-md-4 col-form-label text-md-right">{{ __('Shop phone') }}</label>
                    <div class="form-group col-md-1">
                    <input id="shop_code" type="text" class="form-control @error('shop_code') is-invalid @enderror" name="shop_code" value="+370" autofocus>
                    </div>
                    <div class="form-group col-md-3">
                    <input id="shop_phone" type="text" class="form-control @error('shop_phone') is-invalid @enderror" name="shop_phone" autofocus>
                    <span class="invalid-feedback shop_phone" role="alert">
                        <strong></strong>
                        </span>
                </div>
            </div>


            <div class="form-group row">
                <label for="shop_country"
                    class="col-md-4 col-form-label text-md-right">{{ __('Shop country') }}</label>

                <div class="col-md-4">
                    <input id="shop_country" type="text" class="form-control" name="shop_country" autofocus>
                    <span class="invalid-feedback shop_country" role="alert">
                        <strong></strong>
                        </span>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary" id="add">
                        {{ __('Create') }}
                    </button>
                </div>
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
        var shop_title = $("#shop_title").val();
        var shop_description = $("#shop_description").val();
        var shop_email = $("#shop_email").val();
        var shop_code = $("#shop_code").val();
        var shop_phone = $("#shop_phone").val();
        var shop_country = $("#shop_country").val();


        $.ajax({
            type: 'POST',
            url: '{{route("shop.indexstore")}}',
            data: {shop_title: shop_title,  shop_description: shop_description, shop_email: shop_email, shop_code: shop_code, shop_phone: shop_phone, shop_country:shop_country},
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
