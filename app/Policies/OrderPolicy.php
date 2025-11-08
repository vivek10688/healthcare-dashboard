<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function view(User $user, Order $order)
    {
        return $user->id === $order->user_id || $user->role === 'admin';
    }

    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'provider']);
    }

    public function dispatch(User $user, Order $order)
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Order $order)
    {
        return $user->id === $order->user_id || $user->role === 'admin';
    }

    public function delete(User $user, Order $order)
    {
        return $user->role === 'admin';
    }
}
