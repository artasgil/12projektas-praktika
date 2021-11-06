@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Category') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('category.update', [$category]) }}">
                            @csrf
                            <div class="form-group row">
                                <label for="category_title"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Category title') }}</label>

                                <div class="col-md-6">
                                    <input id="category_title" type="text" class="form-control @error('category_title') is-invalid @enderror" name="category_title" value="{{$category->title}}" autofocus>
                                        @error('category_title')
                                        <span role="alert" class="invalid-feedback">
                                            <strong>*{{$message}}</strong>
                                        </span>
                                        @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="category_description"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Category description') }}</label>

                                <div class="col-md-6">
                                    <textarea class="summernote @error('category_description') is-invalid @enderror" cols="38" rows="5" name="category_description">{{$category->description}} </textarea>
                                        @error('category_description')
                                        <span role="alert" class="invalid-feedback">
                                            <strong>*{{$message}}</strong>
                                        </span>
                                        @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="category_shop"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Category shop title') }}</label>
                                <div class="col-md-6">
                                    <select class="form-control @error('category_shop') is-invalid @enderror" name="category_shop">
                                        @foreach ($shops as $shop)
                                            <option value="{{ $shop->id }}" @if($category->shop_id == $shop->id) selected @endif>{{ $shop->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_shop')
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
