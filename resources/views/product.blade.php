@extends('layouts.master')

@section('title', 'Товар')

@section('content')

        <h1>{{$products->name}}</h1>
        <h2>{{$products->category->name}}</h2>
        <p>Цена: <b>{{$products->price}} {{$currencySymbol}}</b></p>
        <img src="{{Storage::url($products->image)}}" height=250 width=250">
        <p>{{$products->description}}</p>

            @if($products->isAvailable())
                <form action="{{route('basket-add', $products->id)}}" method="POST">
                <button type="submit" class="btn btn-primary" role="button">В корзину</button>
                </form>
                @csrf
            @else
                <span>Не доступен</span>
                <br>
                <br>
                <span>Сообщить когда товар будет в наличии</span>
                @if($errors->get('email'))
                    {!! $errors->get('email')[0] !!}
                @endif
                <form method="POST" action="{{route('subscription', $products)}}">
                    @csrf
                    <input type="text" name="email">
                    <button type="submit">Отправить</button>
                </form>
            @endif

@endsection
