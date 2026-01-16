<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

/**
 * App\Models\WithdrawRequest
 *
 * @property int $id
 * @property int|null $doctor_id
 * @property string $amount
 * @property string $status
 * @property string|null $answered_by
 * @property int|null $transaction_id
 * @property string $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Doctor|null $doctor
 * @property-read \App\Models\Transaction|null $transaction
 * @mixin \Eloquent
 * @mixin IdeHelperWithdrawRequest
 */
class WithdrawRequest extends Model
{
    const WAITING = 'waiting';
    const REFUSED = 'refused';
    const ACCEPTED = 'accepted';
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'doctor_id' => 'integer',
        'id' => 'integer',
        'amount' => 'decimal:2',
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function billable()
    {
        return $this->morphMany(Transaction::class, 'billable');
    }

    public function scopeOfDoctor(Builder $builder, $doctor_id): void
    {
        $builder->where('doctor_id', $doctor_id);
    }

    public function scopeCreationType(Builder $builder, $type)
    {
        $builder
            ->when(
                $type == 'monthly',
                fn($q) => $q->whereMonth('created_at', now()),
            )
            ->when(
                $type == 'yearly',
                fn($q) => $q->whereYear('created_at', now()),
            );
    }

    /**
     * accept withdraw transaction
     *
     * @return WithdrawRequest
     * @throws \Throwable
     */
    public function accept($bank_transaction_id = null)
    {
        DB::beginTransaction();
        $transaction = $this->maketransaction();
        $this->fill([
            'status' => self::ACCEPTED,
            'answered_by' => auth()->id(),
            'transaction_id' => $transaction->id,
            'bank_transaction_id' => $bank_transaction_id,
        ])->save();
        DB::commit();
        return $this;
    }

    /**
     * refused to withdraw transaction
     *
     * @param mixed $notes
     * @return WithdrawRequest
     */
    public function refused(string $notes)
    {
        $this->fill([
            'status' => self::REFUSED,
            'answered_by' => auth()->id(),
            'notes' => $notes,
        ]);
        $this->save();
        return $this;
    }

    /**
     * make transaction
     *
     * @return Transaction
     */
    public function maketransaction(): Transaction
    {
        $wallet = Doctor::where('id',$this->doctor_id)->select('*')
        ->addSelect(DB::raw("GetDoctorWallet($this->doctor_id) as wallet"))->first();

        return $this->billable()->create([
            'receiver_type' => Admin::class,
            'receiver_id' => auth()->id(),
            'sender_type' => Doctor::class,
            'sender_id' => $this->doctor_id,
            'amount' => $this->amount,
            'gateway' => 'cash',
            'currency' => env('CASHIER_CURRENCY'),
            'description' => 'Accept Transaction withdraw',
            'previous_amount' => $wallet->wallet
        ]);
    }
}
