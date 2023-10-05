<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'account_method', 'id');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_name','id');
    }
}
