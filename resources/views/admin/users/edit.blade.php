@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Update User</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('users.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <form action="" method="post" id="userForm" name="userForm">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label for="name">Name</label>
                        <input value="{{ $user->name }}" type="text" name="name" id="name" class="form-control" placeholder="Name">
                        <p></p>
                    </div>
                    <div class="col-md-4">
                        <label for="email">Email</label>
                        <input value="{{ $user->email }}" type="text" name="email" id="email" class="form-control" placeholder="Email">
                        <p></p>
                    </div>
                    <div class="col-md-4">
                        <label for="status">Role</label>
                        <div class="row">
                            @if($roles->isNotEmpty())
                                @foreach ($roles as $value)                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input {{ ($hasRoles->contains($value->id)) ? 'checked' : '' }} type="checkbox" id="role-{{ $value->id }}" class="rounded" name="role[]" value="{{ $value->name }}" />
                                            <label for="role-{{ $value->id }}">{{ $value->name }}</label>
                                        </div>        
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('users.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
    </form>
</section>
@endsection

@section('customJs')
    <script>
        $("#userForm").submit(function(event){
            event.preventDefault();
            var element = $(this);
            $("button[type=submit]").prop('disabled', true);
            $.ajax({
                url: '{{ route("users.update",$user->id) }}',
                type: 'put',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response){
                    $("button[type=submit]").prop('disabled', false);

                    if(response["status"] == true){
                        $('#name').removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");

                        $('#email').removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");

                        $('#password').removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");

                        $('#phone').removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");

                        window.location.href="{{ route('users.index') }}"

                    } else {
                        var errors = response['errors']
                        if(errors['name']){
                            $('#name').addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback').html(errors['name']);
                        } else {
                            $('#name').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html("");
                        }

                        if(errors['email']){
                            $('#email').addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback').html(errors['email']);
                        } else {
                            $('#email').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html("");
                        }

                        if(errors['password']){
                            $('#password').addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback').html(errors['password']);
                        } else {
                            $('#password').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html("");
                        }

                        if(errors['phone']){
                            $('#phone').addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback').html(errors['phone']);
                        } else {
                            $('#phone').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html("");
                        }
                    }

                }, error: function(jqXHR, exception) {
                    console.log("Something event wrong");
                }
            })
        });
    </script>
@endsection
