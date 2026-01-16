<?php

namespace App\Models\Concerns\Traits;

use App\Models\Doctor;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Payable
{
    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'billable');
    }

    public function online_transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'billable')->where(
            'gateway',
            '!=',
            'wallet',
        );
    }

    public function bill(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'billable');
    }

    public function getCommissionAttribute(): float|int
    {
        return $this->price * ($this->percentage / 100);
    }

    public function calculateCommission($amount): float|int
    {
        return $amount * ($this->percentage / 100);
    }

    public function calculateNetAmount($gross_amount): float|int
    {
        return $gross_amount - $this->calculateCommission($gross_amount);
    }

    public function getAmountAttribute()
    {
        return $this->price - $this->commission;
    }

    public function getTotalAttribute()
    {
        return $this->price;
    }

    public function payWallet(): Model|Transaction
    {
        $bill = $this->bill()->create([
            'sender_id' => $this->user_id,
            'sender_type' => User::class,
            'receiver_type' => Doctor::class,
            'receiver_id' => $this->doctor_id,
            'gateway' => 'wallet',
            'amount' => $this->price,
            'commission' => calculateAppCommission($this->price),
            'vat_tax' => floatval(getPriceVatTax($this->patient->national_id,$this->wallet)),
            'status' => 'SUCCESS',
            'total' => $this->wallet,
            'currency' => config('services.stripe.currency'),
            'description' => $this->description,
        ]);

        $this->fill(['transaction_id' => $bill->id])->save();
        return $bill;
    }

    public function payOnline(?string $gateway = null): Model|Transaction
    {
        $commission = calculateAppCommission($this->price);
        $bill = $this->bill()->create([
            'sender_id' => $this->user_id,
            'sender_type' => User::class,
            'receiver_type' => Doctor::class,
            'receiver_id' => $this->doctor_id,
            'gateway' => $gateway ?? 'online',
            'amount' => $this->price - $commission,
            'commission' => $commission,
            'vat_tax' => floatval(getPriceVatTax($this->patient->national_id,$this->online)),//splitPriceVatAndCommission($this->patient->national_id,$this->online)['vat'],
            'total' => $this->online,
            'currency' => config('myfatoorah.country_iso'),
            'description' => $this->description,
            'invoice_id' => $this->invoice_id,
        ]);

        $this->fill(['transaction_id' => $bill->id])->save();
        return $bill;
    }
}
