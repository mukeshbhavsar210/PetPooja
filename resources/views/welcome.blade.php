<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <style>
        body {
            align-items: center;
            height: 80vh;
        }

        .export-btn {
            padding: 15px 30px;
            font-size: 18px;
            background: #0099FF;
            margin-top: 20px;
        }

        .products {
            margin-top: 20px;
        }

        .caption {
            text-align: center;
        }

        .img-size {
            width: 225px !important;
            height: 153px;
            margin-left: 20px;
            margin-top: 10px;
        }

        .adding-cart {
            display: none;
        }

        #adding-cart {
            display: none;
        }
    </style>
</head>

<body>
    @extends('layouts.layout')
    
    @section('content')
   
    <div class="container products">
        <div class="row">
            @if(!empty($products))
            @foreach($products as $product)
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit(strtolower($product->description), 50) }}</p>
                        <p class="card-text"><strong>Price: </strong> ${{ $product->price }}</p>
                        <a href="javascript:void(0);" data-product-id="{{ $product->id }}" id="add-cart-btn-{{ $product->id }}" class="btn btn-warning btn-block text-center add-cart-btn add-to-cart-button">Add to cart</a>
                        <span id="adding-cart-{{ $product->id }}" class="btn btn-warning btn-block text-center added-msg" style="display:none;">Added.</span>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div><!-- End row -->
    </div>

    <table id="cart" class="table table-bordered table-hover table-condensed mt-3">
        <tbody>
            <?php $total = 0 ?>
            @if(session('cart'))
            @foreach(session('cart') as $id => $details)
            <?php $total += $details['price'] * $details['quantity'] ?>
            <tr>
                <td data-th="Product">
                    <div class="row">
                        <div class="col-sm-3 hidden-xs"><img src="{{ $details['photo'] }}" width="50" height="" class="img-responsive" />

                        </div>

                        <div class="col-sm-9">
                            <p class="nomargin">{{ $details['name'] }}</p>
                            <p class="remove-from-cart cart-delete" data-id="{{ $id }}" title="Delete">Remove</p>
                        </div>
                    </div>
                </td>
                <td data-th="Quantity">
                    <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity" />
                </td>
                <td data-th="Subtotal" class="text-center">${{ $details['price'] * $details['quantity'] }}</td>
            </tr>

            @endforeach
            @endif
        </tbody>
        <tfoot>
            @if(!empty($details))
            <tr class="visible-xs">
                <td class="text-right" colspan="2"><strong>Total</strong></td>
                <td class="text-center"> ${{ $total }}</td>
            </tr>
            @else
            <tr>
                <td class="text-center" colspan="3">Your Cart is Empty.....</td>
            <tr>
                @endif
        </tfoot>

    </table>
    @endsection

    @section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.add-to-cart-button').on('click', function() {
                var productId = $(this).data('product-id');

                $.ajax({
                    type: 'GET',
                    url: '/add-to-cart/' + productId,
                    success: function(data) {
                        $("#adding-cart-" + productId).show();
                        $("#add-cart-btn-" + productId).hide();
                        window.location.href='{{ route("front.home") }}';
                    },
                    error: function(error) {
                        console.error('Error adding to cart:', error);
                    }
                });
            });
        });
    </script>
    @endsection

</body>
</html>