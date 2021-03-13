@include('layouts.app')
<div class="container">
    
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


    <div class="col-md-10">
        <div class="card-header">
            <h3 class="text-center">Deleted Messages</h3>
        </div>
        @if ($messages->count() > 0)
            <table class="table table-responsive-sm table-hover">
                <thead>
                    <tr>
                        <th>Message</th>
                        <th>Sent to</th>
                        <th>Restore</th>
                        <th>Delete Forever!</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($messages as $message)
                            <tr>
                                <td style="width: 25%">{{ $message->message_body }}</td>
                                <td style="width: 25%">{{ $message->user->name }}</td>
                                <td>
                                    <form action="{{ route('restore.messages', $message->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Restore</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('force.delete.messages', $message->id) }}" class="mb-3" method="POST">
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
            @else 
                <div class="card-body">
                    <h4 class="card-title">There is no trashed messages!</h4>
                </div>
            @endif
    </div>
</div>