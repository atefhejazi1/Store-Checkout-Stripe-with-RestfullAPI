<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'logo_image',
        'cover_image',
        'business_phone',
        'payout_details',
        'status',
        'vendor_status',
    ];

    protected $casts = [
        'payout_details' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (Store $store) {
            $store->slug = Str::slug($store->name);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function approve(): void
    {
        $this->update(['vendor_status' => 'approved', 'status' => 'active']);
    }

    public function block(): void
    {
        $this->update(['vendor_status' => 'blocked', 'status' => 'inactive']);
    }

    public function scopePending($q)
    {
        return $q->where('vendor_status', 'pending');
    }

    public function scopeApproved($q)
    {
        return $q->where('vendor_status', 'approved');
    }

    public function scopeBlocked($q)
    {
        return $q->where('vendor_status', 'blocked');
    }
}
