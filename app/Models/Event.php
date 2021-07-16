<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;
    use HasFactory;

    public const EVENT_TYPE_SELECT = [
        'OPEN_TENDER'  => 'Open Tender',
        'NORMAL_EVENT' => 'Normal Event',
    ];

    public $table = 'events';

    protected $dates = [
        'expired_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'label',
        'description',
        'event_type',
        'expired_date',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getExpiredDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setExpiredDateAttribute($value)
    {
        $this->attributes['expired_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
