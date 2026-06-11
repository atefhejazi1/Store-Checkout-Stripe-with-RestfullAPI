<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'category_id',
        'store_id',
        'price',
        'compare_price',
        'status',
    ];

    protected $hidden = [
        'image',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'image_url',
    ];

    protected static function booted()
    {
        static::creating(function (Product $product) {
            $product->slug = Str::slug($product->name);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id')->withDefault([
            'name' => 'No Category',
        ]);
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id')->withDefault([
            'name' => 'No Store',
        ]);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://www.incathlab.com/images/products/default_product.png';
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return asset('uploads/' . $this->image);
    }

    public function getSalePercentAttribute()
    {
        if (!$this->compare_price || $this->compare_price == 0) {
            return 0;
        }
        $discount = 100 * ($this->compare_price - $this->price) / $this->compare_price;
        return round($discount, 1);
    }

    public function scopeForVendor(Builder $builder, User $user): Builder
    {
        return $builder->where('store_id', optional($user->store)->id ?? 0);
    }

    public function scopeFilter(Builder $builder, array $filters)
    {
        $options = array_merge([
            'store_id'    => null,
            'category_id' => null,
            'status'      => 'active',
        ], $filters);

        // Only surface products from approved, active stores on the storefront
        $builder->whereHas('store', fn ($q) => $q->where('vendor_status', 'approved')->where('status', 'active'));

        $builder->when($options['status'], fn ($q, $status) => $q->where('status', $status));
        $builder->when($options['store_id'], fn ($q, $v) => $q->where('store_id', $v));
        $builder->when($options['category_id'], fn ($q, $v) => $q->where('category_id', $v));
    }
}
