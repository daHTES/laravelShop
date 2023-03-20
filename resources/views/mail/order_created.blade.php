<h3> Уважаемый {{$name}} </h3>

<p>Ваш заказ на сумму {{$fullSum}} создан</p>

<table>
    <tbody>
    @foreach($order->products as $product)
        <td><span class="badge">{{$product->pivot->count}}</span>
            <div class="btn-group form-inline">
                {{$product->description}}
            </div>
        </td>
        <td>{{$product->price}}</td>
        <td>{{$product->getPriceForCount($product->pivot->count)}}</td>
    @endforeach
    </tbody>
</table>
