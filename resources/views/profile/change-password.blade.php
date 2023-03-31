@include('layouts.app')

<div class="container">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <h3>Change Password</h3>
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

            @if (session('incorrect_password'))
                <div class="alert alert-danger">
                    {{ session('incorrect_password') }}
                </div>
            @endif

            @if (session('password_updated'))
                <div class="alert alert-success">
                    {{ session('password_updated') }}
                </div>
            @endif


            <div class="card-body">
                <form action="{{ route('update.password', Auth::id()) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Current Password (First)</label>
                        <input type="password" name="password" class="form-control" placeholder="Current Password">
                    </div>
                    <div class="form-group">
                        <label for="newpassword">New Password</label>
                        <input type="password" name="newpassword" class="form-control" placeholder="New Password">
                    </div>
                    <div class="form-group">
                        <label for="newpassword_confirmation">Confirm New Password</label>
                        <input type="password" name="newpassword_confirmation" class="form-control" placeholder="Confirm New Password">
                    </div>
                    <button type="submit" class="btn btn-dark">Update Password</button>
                </form>        
            </div>
        </div>    


    </div>
</div>