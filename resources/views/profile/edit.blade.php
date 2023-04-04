
@include('layouts.app')

<div class="container">
    <div class="col-sm-6">

        <div class="card">
            <div class="card-header">
                <h3>Edit Profile</h3>
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

            {{-- @if (session('email_exists'))
                <div class="alert alert-danger">
                    {{ session('email_exists') }}
                </div>
            @endif --}}

            <div class="card-body">
                <form action="{{ route('update.profile', auth()->id()) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}">
                    </div>
                    <button type="submit" class="btn btn-dark">Update</button>
                </form>        
            </div>
        </div>    
    </div>
</div>

