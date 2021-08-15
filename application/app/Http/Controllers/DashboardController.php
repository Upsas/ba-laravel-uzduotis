<?php

namespace App\Http\Controllers;

use App\Repositories\ContactsRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function __construct(private ContactsRepository $contactsRepo)
    {}

    public function index(): Factory|View|Application
    {
        $params = [
            'userId' => Auth::id(),
            'perPage' => 8
        ];
        $contacts = $this->contactsRepo->getAllContactsByUserIdWithPagination($params);
        return view('dashboard', ['contacts' => $contacts]);
    }
}
