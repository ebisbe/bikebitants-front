<div class="product-labels">
    @if($product->is_featured)
        <span class="label label-info"><span class="fa fa-star"></span> </span>
    @endif
    @if($product->is_discounted)
        <span class="label label-info">Oferta Bikebitants</span>
    @endif
    @if($product->stock == 0)
        <span class="label label-danger">Out of stock</span>
    @endif
    @foreach($product->labels as $label)
        <span class="label label-{{ $label->css }}">{{ $label->name }}</span>
    @endforeach
</div>