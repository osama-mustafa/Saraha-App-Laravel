@include('layouts.app')
<div class="container">
    
    @if (session('message_deleted'))
        <div class="alert alert-danger">
            {{ session('message_deleted') }}
        </div>
    @endif

    <div class="col-md-10">
        <div class="card-header">
            <h3 class="text-center">All Messages</h3>
        </div>
        <table class="table table-responsive-sm table-hover">
            <thead>
                <tr>
                    <th>Message</th>
                    <th>Sent To</th>
                    <th>Sent At</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($messages as $message)
                    <tr>
                        <td style="width: 25%">{{ $message->message_body }}</td>
                        <td>
                            <a href="{{ route('user.profile', $message->user->id) }}">{{ $message->user->name }}</a>
                        </td>
                        <td>{{ $message->created_at->toDateTimeString() }}</td>
                        <td>
                            <form action="{{ route('user.delete.message', $message->id) }}" class="mb-3" method="POST">
                                @csrf 
                                @method('DELETE')
                                <button class="btn btn-danger ml-3"><i class="fas fa-trash"></i> Delete</button>
                            </form>    
                        </td>
                    </tr>
                @endforeach
            </tbody>
            
        </table>    
        <div>
            {!! $messages->links() !!}
        </div>
    </div>
</div>