<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;

class AllOrders extends Component
{
    use WithPagination;
    public $name,$email,$phone,$message,$search;
    public function render()
    {
        $searchTerm = trim($this->search);

        return view('livewire.all-orders',[
            'orders'=>Order::query()->where('status',0)
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->search($searchTerm);
            })
            ->when($this->name, function ($query) {
                $query->where('name', $this->name);
            })
            ->when($this->email, function ($query) {
                $query->where('email', $this->email);
            })
            ->when($this->phone, function ($query) {
                $query->where('phone', $this->phone);
            })
            ->when($this->message, function ($query) {
                $query->where('message', $this->message);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5),
        ]);
    }
}
