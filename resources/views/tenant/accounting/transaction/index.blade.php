@extends('tenant.layouts.main')

@section('heading')
Transaction
@stop

@section('content')
<!-- <div class="box box-solid">
    <div class="box-body">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <ul>
                    @foreach($transactions as  $key => $transaction)
                        <li>
                           <p>
                               {{ $transaction->created_at->format('Y-m-d') }}
                               {{ $transaction->id  }}
                               {{ $transaction->description  }}
                               {{ $transaction->type ? 'Bill' : 'Expense' }}
                               #{{ $transaction->type_id }}
                               {{ $transaction->amount }}
                           </p>
                            <table class="table table-hover">
                            <thead>
                                 <tr>
                                        <th>Accound Number</th>
                                        <th>Name</th>
                                        <th style="text-align: right">Amount</th>
                                        <th style="text-align: center">Vat Code</th>
                                 </tr>
                            </thead>
                            <tbody>
                                @foreach($transaction->entries as $k => $entry)
                                    <tr>
                                           <td>{{ $entry->account_code() }}</td>
                                           <td>{{ $entry->description }}</td>
                                           <td style="text-align: right">{{ $entry->amount }}</td>
                                           <td style="text-align: center">{{ $entry->vatCode }}</td>

                                    </tr>
                                @endforeach
                              </tbody>
                            </table>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div>


        <div id="close-ac-modal-data" class="hide">
            <div class="box box-solid">
                <div class="box-header">
                    <h3 class="box-title">Close Accounting Year</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                Check that the balance of accounts 1000-2999 = <strong>0</strong>
                            </p>
                            <p>
                                Check that the balance of accounts 3000-8999 = <strong>0</strong>
                            </p>
                            <p>
                                Check that all <strong>VAT <font class="uppercase">reports for the year has status sent</font></strong>
                            </p>
                            <br />
                            <p class="align-right">
                                <a href="#" class="btn btn-danger">Close Accounting Year</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->


        <div class="box box-solid">
            <div class="box-body">
                <div class="box-header pad-0">
                    <h3 class="box-title">Transaction</font></h3>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <ul class="no-list-style">
                            <li>
                                <div class="accord">
                                    <p class="accord-list">10.02.2015 - <span><strong>Payment</strong></span> <span><strong>Bill number 10001</strong></span></p>
                                </div>
                                <div class="detail-sec table-responsive">
                        
                                    <table class="table detail-table">
                                        <tbody>
                                        <tr>
                                            <th>S.N</td>
                                            <th>Account number</td>
                                            <th>Name</td>
                                            <th>Amount</td>
                                            <th>VAT Code:</td>

                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>2701</td>
                                            <td>2701 Output value added tax high rate</td>
                                            <td>Kr 3 750,00</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>3000</td>
                                            <td>3000 Sales revenue, high tax rate</td>
                                            <td>Kr 15 000,00</td>
                                            <td>Sales high tax</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>1500:10001</td>
                                            <td>Customer name</td>
                                            <td>Kr -18 750,00</td>
                                            <td></td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </li>
                        </ul>
                    </div>
                    

                </div>
            </div>
        </div>



        <script type="text/javascript">
            $(function(){
                $('.accord-list').click(function(){
                    $(this).parent().parent().find('.detail-sec').slideToggle();                    
                
                });
            });
        </script>

        {{--Load JS--}}
        {{FB::registerModal()}}

        @stop

