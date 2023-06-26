<div>
<div class="card">
        <div class="card-header">
            <h5>Orders Table</h5>
            <span>Orders Received and Not Worked Upon yet</span>
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="card-header-right">
                <div class="p-15 p-b-0">
                    <div class="form-group form-primary">
                        <input type="text" placeholder="Search order..." wire:model.debounce.350ms="search" class="form-control">
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
                            <th>Full Names</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Devices</th>
                            <th>Purpose</th>
                            <th>Date Created</th>
                            <th>Status</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <th scope="row">{{ $order->id }}</th>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->phone }}</td>
                                <td>{{ $order->devices }}</td>
                                <td>{{ $order->message }}</td>
                                <td>{{ $order->created_at }}</td>
                                <td>
                                    @if($order->status == 1) 
                                        <a class="btn waves-effect waves-light btn-success" href="//">
                                            Serviced
                                        </a>
                                    @else
                                        <a class="btn waves-effect waves-light btn-disabled" href="//">
                                            Not Serviced
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('order.destroy', $order->id) }}">
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
                                {{ __('No Orders Available') }}
                            </div>
                        @endforelse  
                    </tbody>
                </table>
            </div>
            <div class="pagination justify-content-center"> {{-- Add 'justify-content-center' class --}}
                {{ $orders->links('pagination::bootstrap-4') }} {{-- Use bootstrap-4 pagination style --}}
            </div>
        </div>
    </div>
</div>
