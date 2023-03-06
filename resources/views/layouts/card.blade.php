<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
        <img src="/img/iphonex56.png" alt="iPhone X 64GB">
        <div class="caption">
            <h3>{{$product->name}}</h3>
            <p>{{$product->price}} грн</p>
            <p>
                <form action="{{route('basket-add', $product->id)}}" method="POST">
                <button  type="submit" class="btn btn-primary" role="button">В корзину</button>
                {{$product->category->name}}
                <a href="{{route('product', [$product->category->code, $product->code])}}" class="btn btn-default"
                   role="button">Подробнее</a>
                @csrf
            </form>
            </p>
        </div>
    </div>
</div>
