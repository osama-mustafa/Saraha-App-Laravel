@include('layouts.app')
<div class="container">
    
    @if (session('user_deleted'))
        <div class="alert alert-danger">
            {{ session('user_deleted') }}
        </div>
    @endif

    @if (session('admin_message'))
        <div class="alert alert-success">
            {{ session('admin_message') }}
        </div>
    @endif

    <div class="card-header">
        <h3 class="text-center">Users</h3>
    </div>

    <table class="table table-responsive-md table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Active Messages</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Admin</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $index => $user)
                <tr>
                    <th scope="row">{{ $index + 1 }}</th>
                    <td>
                       {{ $user->name }}
                    </td>
                    <td>{{ $user->messages->count() }}</td>
                    <td>
                        <a href="{{ route('edit.user', $user->id) }}" class="btn btn-dark btn-sm">
                            <i class="fa fa-user-edit"></i>
                            Edit
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('delete.user', $user->id) }}" method="POST">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" class="btn btn-dark btn-sm">
                                <i class="fa fa-user-times"></i>
                                Delete
                            </button>
                        </form>
                    </td>

                    @if ($user->is_admin == true)
                        <td>
                            <form action="{{ route('remove.admin', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-dark btn-sm">
                                    <i class="fa fa-lock"></i>
                                    Remove Admin
                                </button>
                            </form>
                        </td>
                    @endif

                    @if ($user->is_admin == false)
                        <td>
                            <form action="{{ route('make.admin', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-dark btn-sm">
                                    <i class="fa fa-lock-open"></i>
                                    Make Admin
                                </button>
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