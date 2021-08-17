<?php

namespace App\Repositories;

use App\Models\SharedContact;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Ramsey\Collection\Collection;

class SharedContactsRepository
{
    public function getSharedContactsWithPagination(int $perPage): LengthAwarePaginator
    {
        return SharedContact::where('contact_shared_user_id', Auth::id())->orWhere('user_id', Auth::id())->paginate($perPage);
    }
}
