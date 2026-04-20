<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailLog extends Model
{
    protected $fillable = ['subject', 'from_name', 'record_id', 'total', 'sent', 'failed'];

    public function details()
    {
        return $this->hasMany(MailLogDetail::class, 'log_id');
    }

    public function record()
    {
        return $this->belongsTo(ExcelColumnData::class, 'record_id');
    }

    /** Success rate as a percentage */
    public function successRate(): int
    {
        return $this->total > 0 ? (int) round(($this->sent / $this->total) * 100) : 0;
    }
}
