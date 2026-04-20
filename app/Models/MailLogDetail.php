<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailLogDetail extends Model
{
    protected $fillable = ['log_id', 'email', 'recipient_name', 'status', 'error'];

    public function log()
    {
        return $this->belongsTo(MailLog::class, 'log_id');
    }
}
