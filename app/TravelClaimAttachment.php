<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravelClaimAttachment extends Model
{
    public function attachment_types()
    {
        return $this->belongsTo('App\Conveyance', 'attachment_type', 'id');
    }
}