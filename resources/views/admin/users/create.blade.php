
@extends('layouts.app')

@section("content")
<div class="container">
    <div class="col-sm-6">

        <div class="card">
            <div class="card-header">
                <h4>Create User</h4>
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
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Username</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter new username" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter new email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter new password" required>
                    </div>

                    <div class="form-group">
                        <input type="file" class="form-control-file mt-3" id="exampleFormControlFile1" name="image" required>
                    </div>

                    <button type="submit" class="btn btn-dark">Create</button>
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
