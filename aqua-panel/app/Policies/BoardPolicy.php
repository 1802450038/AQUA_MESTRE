<?php

namespace App\Policies;

use App\Models\Board;
use App\Models\User;

class BoardPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Board $board)
    {
        // Admin pode tudo, Dono pode editar a sua, Gerente NÃO pode
        if ($user->role === 'admin') return true;
        if ($user->role === 'manager') return false;

        return $user->id === $board->user_id;
    }

    public function viewAny(User $user)
    {
        // Todos podem ver (mas filtramos no Filament o que eles veem)
        return true;
    }
}
