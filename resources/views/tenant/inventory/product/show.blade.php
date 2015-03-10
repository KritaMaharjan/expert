<div class="box box-solid">
<div class="box-header">
    <h3 class="box-title">{{$product->name or ''}}</h3>
    </div>
<div class="box-body table-responsive">
                  <table class="table table-hover">
                    <tbody>
                        <tr>
                          <th>Product ID</th>
                          <td>{{$product->id or ''}}</td>
                        </tr>
                        <tr>
                          <th>Product Number</th>
                          <td>{{$product->number or ''}}</td>
                        </tr>
                        <tr>
                          <th>Product Name</th>
                          <td>{{$product->name or ''}}</td>
                        </tr>
                        <tr>
                          <th>Quantity</th>
                          <td>{{$product->quantity or ''}}</td>
                        </tr>

                         <tr>
                          <th>Vat</th>
                          <td>{{$product->vat()}}</td>
                        </tr>

                        <tr>
                         <th>Purchase Cost (per Item)</th>
                         <td>{{$product->purchase_cost()}}</td>
                       </tr>

                       <tr>
                         <th>Selling Price (per Item)</th>
                         <td>{{$product->selling_price()}}</td>
                       </tr>


                        <tr>
                          <th>Total Purchase Cost</th>
                          <td>{{$product->totalPurchaseCost()}}</td>
                        </tr>

                        <tr>
                          <th>Total Selling Price</th>
                          <td>{{$product->totalSellingPrice()}}</td>
                        </tr>


                        <tr>
                          <th>Created By</th>
                          <td>{{ \App\Models\Tenant\User::find($product->user_id)->fullname}}</td>
                        </tr>

                         <tr>
                          <th>Created On</th>
                          <td>{{ $product->created_at->diffForHumans()}}</td>
                        </tr>


                  </tbody>
                  </table>
                </div>
 </div>