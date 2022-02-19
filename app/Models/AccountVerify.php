<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountVerify extends Model
{
    use HasFactory;
    protected $table = "account_verify";
    protected $fillable = ["phone", "verify_code"];
}
