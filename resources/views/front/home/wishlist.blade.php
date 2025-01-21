@extends('front.layouts.app')

@section('content')

<div class="mainCartWrapper">
        @if(session('wishlist'))
            @foreach(session('wishlist') as $id => $details)
                <p>{{ $details['quantity'] }} x {{ $details['name'] }}</p>
            @endforeach
        @endif
</div>

@endsection

@section('customJs')
<script>

   
</script>
@endsection