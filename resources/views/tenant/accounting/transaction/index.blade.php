@extends('tenant.layouts.main')

@section('heading')
Transaction
@stop

@section('content')
<div class="box box-solid">
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
@stop