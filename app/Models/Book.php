<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title','author','editorial','isbn','publication_year',
        'total_copies','available_copies','description','cover'
    ];

    // relaciones
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // utilidades
    public function isAvailable(): bool
    {
        return $this->available_copies > 0;
    }

    public function decrementAvailable(int $count = 1)
    {
        $this->available_copies = max(0, $this->available_copies - $count);
        $this->save();
    }

    public function incrementAvailable(int $count = 1)
    {
        $this->available_copies += $count;
        $this->save();
    }
}
