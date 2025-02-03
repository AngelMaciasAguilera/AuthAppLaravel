<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>The Users</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="{{asset('assets/css/usersview.css')}}">

</head>

<body>
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="deleteModalBody">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="undo-delete">Close</button>
                    <form action="" id="formToDelete" method="post">
                        @csrf
                        @method('delete')
                        <button type="button" class="btn btn-primary" id="confirm-delete"
                            data-href="{{ url('users/') }}">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Create the user</h5>
                </div>
                <div class="modal-body" id="modalBody">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email">
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password">
                        @if ($actualuser->role == 'superadmin')
                            <label for="role">Role:</label>
                            <select name="role" id="role">
                                @foreach ($roles as $role)
                                    @if ($role != 'superadmin')
                                        <option value="{{ $role }}">{{ $role }}</option>
                                    @endif
                                @endforeach
                            </select>
                        @endif
                        <button class="btn btn-primary">Create</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="undo-delete">Close</button>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>




    @if (session('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            {{ $errors->first() }}
        </div>
    @endif



    <h2>All the users</h2>

    <a class="dropdown-item" href="{{ route('logout') }}"
        onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
        {{ __('Logout') }}
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <div class="create-users-buttons">
        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"
            data-bs-whatever="@getbootstrap">Create user</a>

    </div>

    <div class="users-container">
        @foreach ($users as $user)
            <ul class="user-data-list">
                <li>Name: {{ $user->name }}</li>
                <li>Email: {{ $user->email }}</li>
                <li>Role: {{ $user->role }}</li>
                <li>Created at: {{ $user->created_at }}</li>
                <li>Updated at: {{ $user->updated_at }}</li>
                <li>Verified:
                    @if ($user->email_verified_at)
                        {{ $user->email_verified_at }}
                    @else
                        Not verified yet
                    @endif
                </li>


                <div class="modal fade" id="updateModal{{ $user->id }}" tabindex="-1"
                    aria-labelledby="updateModal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="">Update the user</h5>
                            </div>
                            <div class="modal-body" id="modalBody">
                                <form action="{{ route('users.update', [$user->id]) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <label for="email">Email:</label>
                                    <input type="email" name="email" id="email"
                                        value=" {{ $user->email }}">
                                    <label for="name">Name:</label>
                                    <input type="text" name="name" id="name"
                                        value="{{ $user->name }}">
                                    <label for="password">Password:</label>
                                    <input type="password" min="8" max="20" name="password"
                                        id="password" value="{{ $user->password }}">
                                    @if ($actualuser->role == 'superadmin')
                                        <label for="role">Role:</label>
                                        <select name="role" id="role">

                                            @foreach ($roles as $role)
                                                @if ($role != 'superadmin')
                                                    <option value="{{ $role }}"
                                                        {{ old('role') == $role ? 'selected' : ($role == $user->role ? 'selected' : '') }}>
                                                        {{ $role }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif

                                    @if ($user->email_verified_at == null)
                                        <input type="checkbox" id="email_verified_at" name="email_verified_at">
                                        <label for="verfied">Verify this account now?</label>
                                    @endif

                                    <button class="btn btn-primary">Update</button>
                                </form>

                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                    id="undo-delete">Close</button>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div>

                <li><a href="" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#updateModal{{ $user->id }}">Update</a></li>

                <li><a href="" class="btn btn-primary deleteUserBtn" data-bs-toggle="modal"
                        data-bs-target="#deleteModal" data-email="{{ $user->email }}"
                        data-id="{{ $user->id }}" data-role="{{ $user->role }}">Delete</a></li>
            </ul>
        @endforeach
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script src="{{ asset('js/index.js') }}"></script>
</body>

</html>
