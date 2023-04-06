@extends('layouts.app')
@section('content')

    @guest

        <!-- User Avatar -->
        <div class="container mb-4">
            <div class="row justify-content-center">
                @if ($user->image)
                    <div class="col-md-6 text-center">
                        <img class="big-avatar img-fluid" src="{{ asset('storage/images') }}/{{ $user->image }}" alt="avatar">
                    </div>
                @else
                    <div class="col-md-6 text-center">
                        <img class="big-avatar img-fluid" src="{{ asset('/images/profile.png') }}" alt="avatar">
                    </div>
                @endif
            </div>
        </div>

        <div class="container">
            @unless ($user->is_blocked)
                <div class="card">

                    <div class="card-header text-center">
                        <h3 class="">
                            <i class="fas fa-envelope"></i> Leave a constructive message to <strong>{!! $user->name !!}</strong>
                        </h3> 
                    </div>

                    @if (session('message_sent'))
                        <div class="alert alert-success">
                            {{ session('message_sent') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    
                    <div class="container">
                    <div class="card-body d-flex justify-content-center">
                        <div class="col-md-6">
                            <form action="{{ route('user.profile.message', ['name' => request()->route('name')]) }}" method="POST">
                                @csrf
                                <div class="form-group text-center">
                                    <textarea 
                                        name="body" 
                                        id="message_body" 
                                        cols="20" 
                                        rows="10" 
                                        class="form-control"
                                        placeholder="Leave a constructive message :)"
                                    ></textarea>
                                </div>
                                <div class="form-group text-center">
                                <button type="submit" class="btn btn-dark btn-sm"><i class="fas fa-envelope"></i> Send Message</button>

                                </div>
                            </form>
                        </div>
                    </div>

                    </div>
                    @if ($user->is_blocked)
                        <form>
                            <button type="submit" class="btn btn-danger btn-sm report-button"><i class="fas fa-flag"></i> Report User</button>
                        </form>
                    @endif

                </div>
            @else 
                <div class="card">

                    <div class="card-header text-center">
                        <h3>
                            <i class="fas fa-envelope"></i> Leave a constructive message to <strong> {!! $user->name !!} </strong>
                        </h3> 
                    </div>
                    
                    <div class="card-body text-center">
                        <div class="col-md-12">
                            <h3>
                                <span class="reported-user-name"><strong> {!! $user->name !!} </strong></span> has been blocked due to violating our services, so he cannot receive any private messages
                            </h3>
                        </div>
                    </div>
                </div>
            @endunless
        </div>
    @endguest

    @auth 
        <div class="container mt-5">
            <div class="alert alert-dark" role="alert">
                <h2 class="alert-heading">Sorry!</h2>
                    <hr>
                <h3>You Cannot Send Private Saraha Messages to Yourself!</h3>
                    <hr>
                <h3 class="mb-0">You Can Share This Link with Others to Know What They Say about You!</h3>
                    <hr>
                <h3 id="public_profile">{{ route('guest.profile', ['name' => auth()->user()->name]) }}</h3>
            </div>          
        </div>
    @endauth

@endsection
