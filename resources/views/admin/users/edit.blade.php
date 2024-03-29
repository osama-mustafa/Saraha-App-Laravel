
@extends('layouts.app')

@section("content")
<div class="container">
    <div class="col-sm-6">

        <div class="card">
            <div class="card-header">
                <h4>Edit User</h4>
            </div>
            @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
            @endif

            @if (session('profile_updated'))
                <div class="alert alert-success">
                    {!! session('profile_updated') !!}
                </div>
            @endif
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                    </div>
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter new password">
                    </div>

                    <!-- Profile image -->

                    @if ($user->image)
                        <div>
                            <img class="big-avatar mb-3" src="{{ asset('storage/images') }}/{{ $user->image }}" alt="avatar">
                        </div>
                    @else
                        <div>
                            <img class="big-avatar mb-3" src="{{ asset('/images/profile.png') }}" alt="avatar">
                        </div>
                    @endif

                    <button type="submit" class="btn btn-dark">Update</button>
                </form>        
            </div>
        </div>    
    </div>
</div>
@endsection

@section("scripts")
    <script>
    </script>
@endsection
