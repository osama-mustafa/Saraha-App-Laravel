@extends('layouts.app')

@section('content')
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

             @if (session('email_exists'))
                <div class="alert alert-danger">
                    {{ session('email_exists') }}
                </div>
            @endif 

        <div class="card-body">
            <form action="{{ route('update.profile', auth()->id()) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}">
                </div>

                <!-- Profile image -->
                @if (auth()->user()->image)
                    <div>
                        <img class="big-avatar" src="{{ asset('storage/images') }}/{{ auth()->user()->image }}" alt="avatar">
                    </div>
                @else
                    <div>
                        <img class="big-avatar" src="{{ asset('/images/profile.png') }}" alt="avatar">
                    </div>
                @endif

                <div class="form-group">
                    <input type="file" class="form-control-file mt-3" id="exampleFormControlFile1" name="image">
                </div>
                <button type="submit" class="btn btn-dark">Update</button>
            </form>
        </div>
    </div>
</div>

@endsection

