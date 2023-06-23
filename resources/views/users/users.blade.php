@extends('dashboard.permit')
@extends('dashboard.layout')
@section('title','Dashboard | Users')
@section('content')

<!-- Hover table card start -->
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>Users Table</h5>
            <a class="btn waves-effect waves-light btn-success" href="{{route('users.create')}}">
                <i class="fas fa-pencil-alt"></i>
                Add User
            </a> 
            <span>These are users who can log in to the system</span>
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="card-header-right">
                <ul class="list-unstyled card-option">
                    <li><i class="fa fa fa-wrench open-card-option"></i></li>
                    <li><i class="fa fa-window-maximize full-card"></i></li>
                    <li><i class="fa fa-minus minimize-card"></i></li>
                    <li><i class="fa fa-refresh reload-card"></i></li>
                    <li><i class="fa fa-trash close-card"></i></li>
                </ul>
            </div>
        </div>
        <div class="card-block table-border-style">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Full Names</th>
                            <th>Email</th>
                            <th>Contacts</th>
                            <th>Location</th>
                            <th>Role</th>
                            <th>Date Created</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($all_users as $user)
                            <tr>
                                <th scope="row">{{ $user->id }}</th>
                                <td><img src="{{ asset('storage/profile_photo')}}/{{$user->profile_photo_path }}" style="max-width: 70px" alt="avatar" /></td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->contact }}</td>
                                <td>{{ $user->location }}</td>
                                <td>@if($user->role == 1){{__('Normal User')}} @elseif($user->role == 2) {{__('Administrator')}} @else{{('No Role')}} @endif</td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    @if($user->status == 1) 
                                        <a class="btn waves-effect waves-light btn-success" href="{{ route('users.activate', $user->id) }}">
                                            Enabled
                                        </a>
                                    @else
                                        <a class="btn waves-effect waves-light btn-disabled" href="{{ route('users.activate', $user->id) }}">
                                            Disabled
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn waves-effect waves-light btn-info" href="{{ route('users.edit', $user->id) }}">
                                        <i class="fas fa-pencil-alt"></i>
                                        Edit
                                    </a>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('users.destroy', $user->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn waves-effect waves-light btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11">
                                    <div class="alert alert-danger">
                                        {{ __('No User Available') }}
                                    </div>
                                </td>
                            </tr>
                        @endforelse  
                    </tbody>
                </table>
            </div>
            <div class="pagination justify-content-center"> {{-- Add 'justify-content-center' class --}}
                {{ $all_users->links('pagination::bootstrap-4') }} {{-- Use bootstrap-4 pagination style --}}
            </div>
        </div>
    </div>
</div>
<!-- Hover table card end -->

@endsection
