<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class AllUsers extends Component
{
   
    use WithPagination;
    public $name;
    public $email;
    public $location;
    public $contact;
    public $search;
    public function render()
    {
        $searchTerm = trim($this->search);

        return view('livewire.all-users', [
            'all_users' => User::query()
                ->when($searchTerm, function ($query) use ($searchTerm) {
                    $query->search($searchTerm);
                })
                ->when($this->name, function ($query) {
                    $query->where('name', $this->name);
                })
                ->when($this->email, function ($query) {
                    $query->where('email', $this->email);
                })
                ->when($this->location, function ($query) {
                    $query->where('location', $this->location);
                })
                ->when($this->contact, function ($query) {
                    $query->where('contact', $this->contact);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(4),
        ]);
    }
}
