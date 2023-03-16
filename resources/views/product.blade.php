@extends('layouts.master')

@section('title', 'Товар')

@section('content')

        <h1>{{$products->name}}</h1>
        <h2>{{$products->category->name}}</h2>
        <p>Цена: <b>{{$products->price}}</b></p>
        <img src="{{Storage::url($products->image)}}" height=250 width=250">
        <p>{{$products->description}}</p>
        @if($products->isAvailable())
            <a class="btn btn-success" href="{{route('basket-add', $products)}}">Добавить в корзину</a>
        @else
            Не доступен
        @endif

@endsection
