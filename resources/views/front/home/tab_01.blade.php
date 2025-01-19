{{-- <form action="" method="POST" id="diningForm" name="diningForm">
    @csrf --}}
    
    <input type="hidden" name="order_type" value="Dinein">

    <div class="basket-page__content__notes">
        <textarea name="notes" placeholder="Add note 🙏🏻..." ></textarea>
    </div>

    <div class="basket-page__content__delivery-content">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
            fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
            <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z">
            </path>
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z">
            </path>
        </svg>
        <select class="form-select" aria-label="Default select example" name="ready_time">
            <option selected>Ready time</option>
            <option value="1">10:00</option>
            <option value="2">11:00</option>
            <option value="3">12:00</option>
        </select>                                            
    </div>

    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php" title="Products">Home</a>
        </li> -->

        @if ($areas->isNotEmpty())
            @foreach ($areas as $value )
                <li class="nav-item dropdown">
                    <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ $value->name }}
                    </button>

                    @if ($value->seating->isNotEmpty())
                        <ul class="dropdown-menu dropdown-menu-dark">
                            @foreach ($value->seating as $seat)
                                <li><a class="dropdown-item nav-link" href="{{ route('front.restaurant',[$value->areaSlug, $seat->areaSlug])}}">{{ $seat->name }} {{ $seat->areaSlug }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        @endif
      </ul>

    {{-- <select class="form-select" aria-label="Default select example" name="table_number">
        @if ($areas->isNotEmpty())
            @foreach ($areas as $value )
                <option>{{ $value->name }}
                    @if ($value->seating->isNotEmpty())
                        <select class="form-select" aria-label="Default select example" name="table_number">
                            @foreach ($value->seating as $seat)
                                <option>{{ $seat->name }}</option>
                            @endforeach
                        </select>
                    @endif
                </option>
            @endforeach
        @endif
    </select> --}}

    <button type="submit" class="btn btn-primary">Order</button>
</form>