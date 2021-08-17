<?php

namespace App\Http\Livewire;

use App\Repositories\SharedContactsRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ContactShared extends Component
{
    use WithPagination;

    public function render(SharedContactsRepository $sharedContactsRepo): Factory|View|Application
    {
        return view('livewire.contact-shared', [
            'contacts' => $sharedContactsRepo->getSharedContactsWithPagination(6)
        ]);
    }
}
