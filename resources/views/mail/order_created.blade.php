<h3> Уважаемый {{$name}} </h3>

<p>Ваш заказ на сумму {{$fullSum}} создан</p>

<table>
    <tbody>
    @foreach($order->products as $product)
        <tr>
            <td>
                <a href="{{route('products', [$product->category->code, $product->code])}}"><img height="56px" src="{{Storage::url($product->image)}}">{{$product->name}} </a>
            </td>
        <td><span class="badge">{{$product->countInOrder}}</span>
            <div class="btn-group form-inline">
                {{$product->description}}
            </div>
        </td>
        <td>{{$product->price}}{{$currencySymbol}}</td>
        <td>{{$product->getPriceForCount()}}{{$currencySymbol}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
