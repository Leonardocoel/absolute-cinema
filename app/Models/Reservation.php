<?php

namespace App\Models;

use App\Models\Seat;
use App\Models\Ticket;
use App\Models\UserAccount;
use App\Models\SessionSchedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;


    public function userAccount(): BelongsTo
    {
        return $this->belongsTo(UserAccount::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function sessionSchedule(): BelongsTo
    {
        return $this->belongsTo(SessionSchedule::class);
    }

    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class);
    }
}
