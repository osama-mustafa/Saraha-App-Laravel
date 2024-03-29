@include('layouts.app')
<div class="container">
    
    @if (session('message_deleted'))
        <div class="alert alert-danger">
            {!! session('message_deleted') !!}
        </div>
    @endif

    <div class="col-md-10">
        <div class="card-header">
            <h3 class="text-center">Messages</h3>
        </div>
        @if ($messages->count() > 0)
            <table class="table table-responsive-sm table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Message</th>
                        <th>Sent To</th>
                        <th>Sent At</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($messages as $index => $message)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td style="width: 25%">{{ $message->body }}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $message->user_id) }}">
                                    {{ $message->user->name }}
                                </a>
                            </td>
                            <td>{{ $message->created_at->toDateTimeString() }}</td>
                            <td>
                                <form action="{{ route('user.delete.message', $message->id) }}" class="mb-3" method="POST">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn btn-dark btn-sm"><i class="fas fa-trash"></i> Delete</button>
                                </form>    
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                
            </table>  
            <div>
                {!! $messages->links() !!}
            </div>    
        @else  
            <div>
                There is no messages
            </div>
        @endif
    </div>
</div>