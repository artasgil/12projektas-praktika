@extends('layouts.app')

@section('content')


    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Product') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('product.update', [$product]) }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="book_title"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Product title') }}</label>

                                <div class="col-md-6">
                                    <input id="product_title" type="text" class="form-control @error('product_title') is-invalid @enderror" name="product_title" value="{{$product->title}}" autofocus>
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
                                    <textarea class="summernote @error('product_excertpt') is-invalid @enderror" cols="38" rows="5" name="product_excertpt">{{$product->excertpt}}</textarea>
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
                                    <textarea class="summernote @error('product_description') is-invalid @enderror" cols="38" rows="5" name="product_description">{{$product->description}}</textarea>
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

                                <div class="col-md-3">
                                    <div class="input-group">
                                    <input id="book_isbn" type="integer" class="form-control @error('product_price') is-invalid @enderror" name="product_price" value="{{$product->price}}" autofocus>
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
                                    <img src="{{$product->image}}" alt="{{$product->title}}" width="100" height="100">
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
                                            <option value="{{ $category->id }}"@if($product->category_id == $category->id) selected @endif>{{ $category->title }}</option>
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
                                        {{ __('Edit') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote();
        });
    </script>
@endsection
