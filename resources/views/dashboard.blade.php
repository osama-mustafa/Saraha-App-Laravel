@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                
                @if (auth()->user()->is_admin)
                <div class="card-header">
                    <h3>Application Statistics</h3>
                </div>
                @endif

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @auth 
                        {{ __('You are logged in!') }}
                        <h3 class="mt-2">
                            <a href="{{ route('user.profile') }}" class="badge badge-dark"><i class="fas fa-envelope"></i> Your Messages</a>
                        </h3>
                    @endauth

                    @if (auth()->user()->is_admin)
                    <hr>
                    <div class="row">

                        @if ($users->count() > 0)
                        <div class="card bg-dark mb-3 mr-2" style="max-width: 18rem;">
                            <div class="card-header text-white">
                               <h4> <i class="fas fa-users"></i> Registered Users </h4> 
                            </div>
                            <div class="card-body text-white">
                                <h4 class="card-title">
                                    <a href="{{ route('users') }}" class="text-white">
                                        {{ $users->count() }} </i>
                                    </a>
                                </h4>
                            </div>
                        </div>
                        @endif
    
                        @if ($messages->count() > 0) 
                            <div class="card bg-dark mb-3 mr-2" style="max-width: 20rem;">
                                <div class="card-header text-white">
                                    <h4><i class="fas fa-envelope"></i> Messages</h4> 
                                </div>
                                <div class="card-body text-white">
                                    <h4 class="card-title">
                                        <a href="{{ route('messages') }}" class="text-white">
                                            {{ $messages->count() }} </i>
                                        </a>
                                    </h4>
                                </div>
                            </div>
                        @endif
                
                    </div> 
                    @endif                                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
