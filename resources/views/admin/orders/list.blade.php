@extends('admin.layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Orders</h1>
            </div>
            <div class="col-sm-6 text-right">

            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">

        @include('admin.message')

        <div class="card">
            <form action="" method="get" >
                <div class="card-header">
                    <div class="card-title">
                        <button type="button" onclick="window.location.href='{{ route('orders.index') }}'" class="btn btn-default btn-sm">Reset</button>
                    </div>

                    <div class="card-tools">
                        <div class="input-group input-group" style="width: 250px;">
                            <input value="{{ Request::get('keyword') }}" type="text" name="keyword" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="card-body table-responsive mt-3 p-0">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Dinein</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Takeaway</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Delivery</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="tabs-1" role="tabpanel">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Order#</th>
                                    <th>Ordered items</th>
                                    <th>Ready time</th>
                                    <th>Table</th>
                                    <th>Notes</th>                                    
                                    <th>Amount</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($orders->isNotEmpty())
                                    @foreach ($orders as $value)
                                        @if($value->orders->order_type == 'Dinein')
                                            <tr>
                                                <td><a href="{{ route('orders.detail',$value->order_id) }}">{{ $value->order_id }}</a></td>
                                                <td>{{ $value->name }} - {{ $value->qty }}</td>
                                                <td>{{ $value->orders->ready_time }}</td>
                                                <td>Table no. {{ $value->orders->table_number }}</td>
                                                <td>{{ $value->orders->notes }}</td>
                                                <td>₹ {{ number_format($value->price,2) }}</td>
                                                <td>₹ {{ number_format($value->price*$value->qty,2) }}</td>
                                                <td>{{ \Carbon\Carbon::parse($value->created_at->format('d M, Y')) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach 
                                @else
                                    <tr>
                                        <td colspan="5">Records not found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane" id="tabs-2" role="tabpanel">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Order#</th>
                                    <th>Ordered items</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Ready time</th>
                                    <th>Notes</th>                                    
                                    <th>Amount</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($orders->isNotEmpty())
                                    @foreach ($orders as $value)
                                        @if($value->orders->order_type == 'Takeaway')
                                            <tr>
                                                <td><a href="{{ route('orders.detail',$value->order_id) }}">{{ $value->order_id }}</a></td>
                                                <td>{{ $value->name }} - {{ $value->qty }}</td>
                                                <td>{{ $value->orders->ready_time }}</td>
                                                <td>{{ $value->orders->takeaway_name }}</td>
                                                <td>{{ $value->orders->takeaway_phone }}</td>
                                                <td>{{ $value->orders->takeaway_email }}</td>
                                                <td>{{ $value->orders->notes }}</td>
                                                <td>₹ {{ number_format($value->price,2) }}</td>
                                                <td>₹ {{ number_format($value->price*$value->qty,2) }}</td>
                                                <td>{{ \Carbon\Carbon::parse($value->created_at->format('d M, Y')) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach 
                                @else
                                    <tr>
                                        <td colspan="5">Records not found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="tabs-3" role="tabpanel">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Order#</th>
                                    <th>Ordered items</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Ready time</th>
                                    <th>Notes</th>                                    
                                    <th>Amount</th>
                                    <th>Total</th>
                                    <th>Payment</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($orders->isNotEmpty())
                                    @foreach ($orders as $value)
                                        @if($value->orders->order_type == 'Delivery')
                                            <tr>
                                                <td><a href="{{ route('orders.detail',$value->order_id) }}">{{ $value->order_id }}</a></td>
                                                <td>{{ $value->name }} - {{ $value->qty }}</td>
                                                <td>{{ $value->orders->delivery_name }}</td>
                                                <td>{{ $value->orders->delivery_phone }}</td>
                                                <td>{{ $value->orders->delivery_email }}</td>
                                                <td>{{ $value->orders->ready_time }}</td>
                                                <td>Table no. {{ $value->orders->table_number }}</td>
                                                <td>{{ $value->orders->notes }}</td>
                                                <td>₹ {{ number_format($value->price,2) }}</td>
                                                <td>₹ {{ number_format($value->price*$value->qty,2) }}</td>
                                                <td>{{ \Carbon\Carbon::parse($value->created_at->format('d M, Y')) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach 
                                @else
                                    <tr>
                                        <td colspan="5">Records not found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card-footer clearfix">
                {{-- {{ $orders->links() }} --}}
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
