@extends('layouts.master')

@section('title', 'Товар')

@section('content')

        <h1>{{$products->name}}</h1>
        <h2>{{$products->category->name}}</h2>
        <p>Цена: <b>{{$products->price}}</b></p>
        <img src="{{Storage::url($products->image)}}" height=250 width=250">
        <p>{{$products->description}}</p>
        <form action="{{route('basket-add', $products->id)}}" method="POST">
            @if($products->isAvailable())
                <button type="submit" class="btn btn-primary" role="button">В корзину</button>
            @else
                Не доступен
            @endif
            @csrf
        </form>
@endsection
