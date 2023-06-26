<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Device;
use App\Models\User;
use Livewire\WithPagination;

class AllDevices extends Component
{
    use WithPagination;

    public $name, $user, $search;

    public function render()
    {
        $searchTerm = trim($this->search);

        return view('livewire.all-devices', [
            'all_devices' => Device::query()
                ->when($searchTerm, function ($query) use ($searchTerm) {
                    $query->search($searchTerm);
                })
                ->when($this->name, function ($query) {
                    $query->where('name', $this->name);
                })
                ->when($this->user, function ($query) use ($searchTerm) {
                    $query->where('user',$this->user);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(5),
        ]);
    }
}
