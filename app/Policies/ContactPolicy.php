<?php

namespace App\Policies;

use App\Models\Contact;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function before(User $user)
    {
        if($user->email === "sbc640964@gmail.com"){
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        return true; //in_array($user->id, []);
    }

    public function view(User $user, Contact $contact): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->id, [1,2]);
    }

    public function update(User $user, Contact $contact): bool
    {
        return in_array($user->id, [1,2]);
    }

    public function delete(User $user, Contact $contact): bool
    {
        return in_array($user->id, [1,2]);
    }

}
