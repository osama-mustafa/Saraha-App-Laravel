@include('layouts.app')


<div class="container">

    <div class="card">
        @auth 
            <div class="card-header">
                <h3>Welcome   
                    <span class="font-weight-bold">{!! auth()->user()->name !!}</span>  
                    You have {{ auth()->user()->messages->count() }} {{ Str::plural('message', auth()->user()->messages->count()) }} <i class="fas fa-envelope fa-sm"></i>
                </h3>
            </div>
        @endauth

        <div class="card-body">

            @if (session('message_sent'))
                <div class="alert alert-success">
                    {!! session('message_sent') !!}
                </div>
            @endif

            @if (session('message_deleted'))
                <div class="alert alert-danger">
                    {!! session('message_deleted') !!}
                </div>
            @endif
            

            @if (session('message_restored'))
                <div class="alert alert-success">
                    {!! session('message_restored') !!}
                </div>
            @endif



            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Show The Message Form For Guests or Not Authenticated Users --}}

            @guest
                <h5 class="card-title">Leave a constructive message <i class="far fa-comment-alt fa-xs"></i></h5>
                <div class="col-md-6">
                    <form action="{{ route('user.profile.message', request()->route('id')) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="body">Message</label>
                            <textarea name="body" id="body" cols="20" rows="10" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-dark">Send Message</button>
                    </form>
                </div>
            @endguest

            {{-- /Show The Message Form For Guests or Not Authenticated Users --}}


            {{-- Show The Messages For The Authenticated User --}}

            @auth 
                {{-- <h5 class="card-title">Your Messages</i></h5> --}}
                <div class="row">
                    @if (auth()->user()->messages->count() > 0)
                        @foreach (auth()->user()->messages as $message)
                        <div class="col-md-6">
                            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                                {{-- <div class="card-header">Message</div> --}}
                                <div class="card-body">
                                    <h5 class="card-text">{{ $message->body }}</h5>
                                </div>
                            </div>
                            <form action="{{ route('user.delete.message', $message->id) }}" class="mb-3" method="POST">
                                @csrf 
                                @method('DELETE')
                                <button class="btn btn-dark ml-3 btn-sm"><i class="fas fa-trash"></i> Delete</button>
                            </form>    
                        </div>
                        @endforeach
                    @endif
                </div>
            @endauth

            {{-- /Show The Messages For The Authenticated User --}}

        </div>

    </div>

</div>
