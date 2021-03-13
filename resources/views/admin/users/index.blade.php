@include('layouts.app')
<div class="container">
    
    @if (session('user_deleted'))
        <div class="alert alert-danger">
            {{ session('user_deleted') }}
        </div>
    @endif

    @if (session('admin_message'))
        <div class="alert alert-success">
            {!! session('admin_message') !!}
        </div>
    @endif

    <div class="card-header">
        <h3 class="text-center">All Users</h3>
    </div>

    <table class="table table-responsive-md table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>ِActive Messages</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Admin</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>
                       {{ $user->name }}
                    </td>
                    <td>{{ $user->messages->count() }}</td>
                    <td>
                        <a href="{{ route('edit.user', $user->id) }}" class="btn btn-secondary">Edit</a>
                    </td>
                    <td>
                        <form action="{{ route('delete.user', $user->id) }}" method="POST">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                    @if ($user->admin == true)
                    <td>
                        <form action="{{ route('remove.admin', $user->id) }}" method="POST">
                            @csrf
                            {{-- @method('POST') --}}
                            <button type="submit" class="btn btn-danger">Remove Admin</button>
                        </form>
                    </td>
                    @endif
                    {{-- @if ($user->admin == false)
                        <td>
                            <a href="{{ route('make.admin', $user->id) }}" class="btn btn-primary">Make Admin</a>
                        </td>
                    @endif --}}
                    @if ($user->admin == false)
                    <td>
                        <form action="{{ route('make.admin', $user->id) }}" method="POST">
                            @csrf
                            {{-- @method('POST') --}}
                            <button type="submit" class="btn btn-primary">Make Admin</button>
                        </form>
                    </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
      </table>
      <div>
          {{ $users->links() }}
      </div>
</div>