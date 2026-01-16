<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ColumnTranslation
{
    public function getNameAttribute()
    {
        if (app()->getLocale() == 'ar') {
            return $this->name_ar ??
                ($this->name_en ?? ($this->attributes['name'] ?? null));
        }
        return $this->name_en ??
            ($this->name_ar ?? ($this->attributes['name'] ?? null));
    }

    public function getDescriptionAttribute()
    {
        if (app()->getLocale() == 'ar') {
            return $this->description_ar;
        }
        return $this->description_en;
    }

    public function getHealCasesAttribute()
    {
        if (app()->getLocale() == 'ar') {
            return $this->heal_cases_ar;
        }
        return $this->heal_cases_en;
    }

    public function getAddressAttribute()
    {
        if (app()->getLocale() == 'ar') {
            return $this->address_ar;
        }
        return $this->address_en;
    }

    public function getTitleAttribute()
    {
        if (app()->getLocale() == 'ar') {
            return $this->title_ar;
        }
        return $this->title_en;
    }

    public function getBodyAttribute()
    {
        if (app()->getLocale() == 'ar') {
            return $this->body_ar;
        }
        return $this->body_en;
    }

    public function getSlugAttribute()
    {
        if (app()->getLocale() == 'ar') {
            return $this->slug_ar;
        }
        return $this->slug_en;
    }

    public function getLabelAttribute()
    {
        if (app()->getLocale() == 'ar') {
            return $this->label_ar;
        }
        return $this->label_en;
    }

    public function scopeOfName(Builder $builder, ?string $name = null): void
    {
        $builder->where('name_ar', $name)->orWhere('name_en', $name);
    }

    public function scopeOfTitle(Builder $builder, ?string $title = null): void
    {
        $builder->where('title_ar', $title)->orWhere('title_en', $title);
    }

    public function scopeOfDescription(
        Builder $builder,
        ?string $description = null,
    ): void {
        $builder
            ->where('description_ar', $description)
            ->orWhere('description_en', $description);
    }

    public function scopeHealCases(
        Builder $builder,
        ?string $description = null,
    ): void {
        $builder
            ->where('heal_cases_ar', 'like', "%$description%")
            ->orWhere('heal_cases_en', 'like', "%$description%");
    }
}
