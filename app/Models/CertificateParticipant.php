<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CertificateParticipant extends Model
{
    public function certificate(): BelongsTo
    {
        return $this->belongsTo(Certificate::class);
    }
}
