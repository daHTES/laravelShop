@extends('layouts.master')
@section('title', 'Все категории товаров')
@section('content')
    <div class="starter-template">
        @foreach($categories as $category)
            <div class="panel">
                <a href="{{route('category', $category->code)}}">
                    <img class="categoriesProduct" src="{{Storage::url($category->image)}}">
                    <h2>{{$category->name}}</h2>
                </a>
                <p>
                    {{$category->description}}
                </p>
            </div>
        @endforeach

    </div>
@endsection
