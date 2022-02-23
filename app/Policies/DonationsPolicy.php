<?php

namespace App\Policies;

use App\Models\Donation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DonationsPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function before(User $user)
    {
        return $user->email === "sbc640964@gmail.com";
    }

    public function viewAny(User $user): bool
    {
        dd('any', $user);
        return in_array($user->id, [1,2,3,4]);
    }

    public function view(User $user, Donation $donation): bool
    {
        dd('view', $user);

        return in_array($user->id, [1,2,3,4]);
    }

    public function create(User $user): bool
    {
        dd('create', $user);

        return in_array($user->id, [1,3]);
    }

    public function update(User $user, Donation $donation): bool
    {
        return in_array($user->id, [1,3,]);
    }

    public function delete(User $user, Donation $donation): bool
    {
        return in_array($user->id, [1,3]);
    }

//    public function restore(User $user, Donation $donation): bool
//    {
//        //
//    }
//
//    public function forceDelete(User $user, Donation $donation): bool
//    {
//        //
//    }
}
