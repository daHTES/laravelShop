@extends('master')
@section('title', 'Все категории товаров')
@section('content')
<div class="container">
    <div class="starter-template">
        @foreach($categories as $category)
            <div class="panel">
                <a href="{{route('category', $category->code)}}">
                    <img src="/img/iphonex56.png">
                    <h2>{{$category->name}}</h2>
                </a>
                <p>
                    {{$category->description}}
                </p>
            </div>
        @endforeach

    </div>
</div>
@endsection
