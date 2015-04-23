@extends('tenant.layouts.main')

@section('heading')
Transaction
@stop

@section('content')
<div class="box box-solid">
    <div class="box-body">
        <div class="row">
            <div class="col-md-12 table-responsive">




                {!! Form::open(array('method' => 'get')) !!}
                    <div class="row">
                     <div class="col-xs-2">
                       <label>From</label>
                       <input type="text" name="from" value="<?php echo $get->from;?>" autocomplete="off" class="form-control date-picker" placeholder="Date">
                     </div>
                     <div class="col-xs-2">
                       <label>To</label>
                       <input type="text" name="to" value="<?php echo $get->to;?>" autocomplete="off" class="form-control date-picker" placeholder="Date">
                     </div>
                     <div class="col-xs-2">
                       <label> Filter by</label>
                       <select name="type" class="form-control">
                          <option value="">All</option>
                          <option <?php echo ($get->type == 1) ? 'selected="selected"': '' ?> value="1">Bill</option>
                          <option <?php echo ($get->type == 2) ? 'selected="selected"': '' ?> value="2">Expense</option>
                        </select>
                     </div>
                      <div class="col-xs-2">
                         <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                    </div>
                {!! Form::close() !!}

                <script>
                $(function(){
                   $(".date-picker").datepicker({'format': 'yyyy-mm-dd'});
                })
                </script>
             @if($transactions->total()>0)

                <div class="box-group" id="accordion">
                    @foreach($transactions as  $key => $transaction)

                     <div class="panel box box-solid">
                          <div class="box-header with-border">
                              <a data-toggle="collapse" data-parent="#accordion" href="#transaction-{{$key+1}}" aria-expanded="false" class="collapsed">
                                 {{ $transaction->id  }})
                                  {{ $transaction->created_at->format('F d, Y') }} -
                                  {{ $transaction->description  }} -
                                  {{ $transaction->type ? 'Bill' : 'Expense' }}
                                  #{{ $transaction->type_id }}
                                 <span style="float: right">{{ $transaction->amount }}</span>
                              </a>
                          </div>
                          <div id="transaction-{{$key+1}}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                            <div class="box-body">
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
                                                 <td>{{ $entry->accountCode() }}</td>
                                                 <td>{{ $entry->description }}</td>
                                                 <td style="text-align: right">{{ $entry->type==1 ? '-' : '+' }} {{ $entry->amount }}</td>
                                                 <td style="text-align: center">{{  display_vat($entry->account_code) }}</td>

                                          </tr>
                                      @endforeach
                                    </tbody>
                                    </table>
                            </div>
                          </div>
                        </div>
                    @endforeach
                </div>

                {!! $transactions->appends((array)$get)->render() !!}

                @else

                <p>Transaction not found.</p>

                @endif

            </div>
        </div>
    </div>
    <div>
@stop

