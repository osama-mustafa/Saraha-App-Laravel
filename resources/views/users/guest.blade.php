@include('layouts.app')

@guest

<div class="container">

    <div class="card">

        <div class="card-header">
            <h3>
                <i class="fas fa-envelope"></i> Leave a constructive message to <strong> {!! $user->name !!} </strong>
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
        
        <div class="card-body">


            {{-- Show The Message Form Form  For Guests or Not Authenticated Users --}}

                <div class="col-md-6">
                    <form action="{{ route('user.profile.message', ['name' => request()->route('name')]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="message_body">Message</label>
                            <textarea name="message_body" id="message_body" cols="20" rows="10" class="form-control" placeholder="Leave a constructive message :)"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fas fa-envelope"></i> Send Message</button>
                    </form>
                </div>

            {{-- /Show The Message Form For Guests or Not Authenticated Users --}}

        </div>

    </div>


</div>


@endguest

@auth 

    <div class="container">

        <div class="alert alert-dark" role="alert">
            <h2 class="alert-heading">Sorry!</h2>
            <hr>
            <h3>You Cannot Send Private Saraha Messages to Yourself!</h3>
            <hr>
            <h3 class="mb-0">You Can Share This Link with Others to Know What They Say about You!</h3>
            <hr>
            <h3 id="public_profile">{{ route('guest.profile', ['name' => $auth_user->name]) }}</h3>
          </div>          

    </div>

@endauth