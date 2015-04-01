  <table id="table-stock" class="table table-hover">
                <thead>
                    <tr>
                      <th>Product ID</th>
                      <th>Product Number</th>
                      <th>Product Name</th>
                      <th>Total Product</th>
                      <th>Used Product</th>
                      <th>Remaining Product</th>
                      
                    </tr>
                </thead>

                 <tbody>
                  @if($product_list)
                  @foreach($product_list as $product)
                  <tr>
                    <td>{{$product->id}}</td>
                    <td>{{$product->number}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->total_product}}</td>
                    <td>{{$product->total_bill}}</td>
                    <td>{{$product->remaining}}</td>
                  </tr>
                  @endforeach
                  @endif
                </tbody>
              </table>

@if($product_list->total() > 1)
<p class="align-right">
<?php
$items = count($product_list->items());
$to = ($product_list->currentPage()-1) * $product_list->perPage() + $items;
if($items >= $product_list->perPage())
$from =  $to - $product_list->perPage()+1;
else
$from =  $to - $product_list->perPage()+1+($product_list->perPage()-$items);
?>
<span class="color-grey">{{$from}}-{{$to}} of {{$product_list->total()}}</span>
    @if($from !=1)
      <a href="#{{$product_list->currentPage()-1}}" data class="mg-lr-5 mail-previous color-grey"><i class="fa  fa-chevron-left"></i></a>
    @endif
    @if($to != $product_list->total())
      <a href="#{{$product_list->currentPage()+1}}"  class="color-grey mail-next"><i class="fa  fa-chevron-right"></i></a>
    @endif
</p>
@endif