@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Shop') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('shop.update', [$shop]) }}">
                            @csrf
                            <div class="form-group row">
                                <label for="shop_title"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Shop title') }}</label>

                                <div class="col-md-6">
                                    <input id="shop_title" type="text" class="form-control @error('shop_title') is-invalid @enderror" name="shop_title" value="{{$shop->title}}" autofocus>
                                        @error('shop_title')
                                        <span role="alert" class="invalid-feedback">
                                            <strong>*{{$message}}</strong>
                                        </span>
                                        @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="shop_description"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Shop description') }}</label>

                                <div class="col-md-6">
                                    <textarea class="summernote @error('shop_description') is-invalid @enderror" cols="38" rows="5" name="shop_description">{{$shop->description}} </textarea>
                                        @error('shop_description')
                                        <span role="alert" class="invalid-feedback">
                                            <strong>*{{$message}}</strong>
                                        </span>
                                        @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="shop_email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Shop email') }}</label>

                                <div class="col-md-6">
                                    <input id="shop_email" type="text" class="form-control @error('shop_email') is-invalid @enderror" name="shop_email" value="{{$shop->email}}" autofocus>
                                        @error('shop_email')
                                        <span role="alert" class="invalid-feedback">
                                            <strong>*{{$message}}</strong>
                                        </span>
                                        @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="shop_phone" class="col-md-4 col-form-label text-md-right">{{ __('Shop phone') }}</label>
                                    <div class="col-md-6">
                                    <input id="shop_phone" type="text" class="form-control @error('shop_phone') is-invalid @enderror" name="shop_phone" value="{{$shop->phone}}" autofocus>
                                        </span>
                                        @error('shop_phone')
                                        <span role="alert" class="invalid-feedback">
                                            <strong>*{{$message}}</strong>
                                        </span>
                                        @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="shop_country"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Shop country') }}</label>

                                <div class="col-md-6">
                                    <input id="shop_country" type="text" class="form-control @error('shop_country') is-invalid @enderror" name="shop_country" value="{{$shop->country}}" autofocus>
                                        @error('shop_country')
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
