<div>
@if(auth()->user()->status==1 && auth()->user()->role==2)
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Devices Table</h5>
                <a class="btn waves-effect waves-light btn-success" href="{{route('device.create')}}">
                    <i class="fas fa-pencil-alt"></i>
                    Add Device
                </a>    
                <span>These are Devices Registered in the System</span>
                @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card-header-right">
                    <div class="p-15 p-b-0">
                        <div class="form-group form-primary">
                            <input type="text" placeholder="Search device..." wire:model.debounce.350ms="search" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Device Name</th>
                                <th>Current Location</th>
                                <th>Device Owner</th>
                                <th>Updated Time</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($all_devices as $device)
                                <tr>
                                    <th scope="row">{{ $device->id }}</th>
                                    <td>{{ $device->name }}</td>
                                    <td>
                                        <a class="btn waves-effect waves-light btn-success" href="{{ route('device.show',$device) }}">
                                            <i class="ti-map-alt"></i></i>
                                            Device Location
                                        </a>
                                    </td>
                                    <td>{{ $device->userz->name }}</td>
                                    <td>{{ $device->updated_at }}</td>
                                    <td>
                                        @if($device->status == 1) 
                                            <a class="btn waves-effect waves-light btn-success" href="{{ route('device.active',$device) }}">
                                                Enabled
                                            </a>
                                        @else
                                            <a class="btn waves-effect waves-light btn-disabled" href="{{ route('device.active',$device) }}">
                                                Disabled
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn waves-effect waves-light btn-info" href="{{ route('device.edit', $device) }}">
                                            <i class="fas fa-pencil-alt"></i>
                                            Edit
                                        </a>
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('device.destroy', $device) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure?')" class="btn waves-effect waves-light btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <div class="alert alert-Danger">
                                    {{ __('No Device Available') }}
                                </div>
                            @endforelse  
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="pagination justify-content-center"> {{-- Add 'justify-content-center' class --}}
                {{ $all_devices->links('pagination::bootstrap-4') }} {{-- Use bootstrap-4 pagination style --}}
            </div>
        </div>
    </div> 
@elseif(auth()->user()->status==1 && auth()->user()->role==1)
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Your Devices</h5>  
                <span>These are Devices Registered in your Name in the System</span>
                @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card-header-right">
                    <div class="p-15 p-b-0">
                        <div class="form-group form-primary">
                            <input type="text" placeholder="Search user..." wire:model.debounce.350ms="search" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Device Name</th>
                                <th>Device Owner</th>
                                <th>Current Location</th>
                                <th>Updated Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($all_devices as $device)
                                @if($device->user == auth()->user()->id)
                                    <tr>
                                        <th scope="row">{{ $device->id }}</th>
                                        <td>{{ $device->name }}</td>
                                        <td>{{ $device->userz->name }}</td>
                                        <td>
                                            <a class="btn waves-effect waves-light btn-success" href="{{ route('device.show',$device) }}">
                                                <i class="ti-map-alt"></i></i>
                                                Device Location
                                            </a>
                                        </td>
                                        <td>{{ diffForHumans($device->updated_at) }}</td>
                                        <td>
                                            @if($device->status == 1) 
                                                <a class="btn waves-effect waves-light btn-success" href="//">
                                                    Enabled
                                                </a>
                                            @else
                                                <a class="btn waves-effect waves-light btn-disabled" href="//">
                                                    Disabled
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <div class="alert alert-Danger">
                                    {{ __('No Device Available') }}
                                </div>
                            @endforelse  
                        </tbody>
                    </table>
                </div>
                <div class="pagination justify-content-center"> {{-- Add 'justify-content-center' class --}}
                    {{ $all_devices->links('pagination::bootstrap-4') }} {{-- Use bootstrap-4 pagination style --}}
                </div>

            </div>
            
        </div>
        
    </div>  
@else
    <div class="pcoded-inner-content">
        <!-- Primary-color Breadcrumb card start -->
        <div class="card borderless-card">
            <div class="card-block primary-breadcrumb">
                <div class="breadcrumb-header">
                    <h5>Hello! {{auth()->user()->name}}, Your Account has been Temporarily suspended</h5>
                    <span>Either your account is not activated or you have not been assigned a role</span>
                    <span>Try contacting your system administrators for reinstatement to access our services</span>
                </div>
            </div>
        </div>
        <!-- Primary-color Breadcrumb card end -->
    </div>
@endif
</div>
