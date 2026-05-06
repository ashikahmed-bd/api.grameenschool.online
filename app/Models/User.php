<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\WithHashId;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, WithHashId, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google_token',
        'disk',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'google_token' => 'array',
        ];
    }


    public function routeNotificationForSms()
    {
        return $this->phone;
    }

    public function getAvatarUrlAttribute(): string
    {
        if (! $this->avatar) {
            return Storage::disk('public')->url('avatars/default.png');
        }

        return Storage::disk($this->disk)->url($this->avatar);
    }


    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }


    public function instructor(): HasOne
    {
        return $this->hasOne(Instructor::class);
    }

    public function enrollments()
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'user_id', 'course_id')
            ->withTimestamps();
    }

    public function canAccessCourse(Course $course)
    {
        return $this->enrollments->contains($course) || $this->courses->contains($course);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }


    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }


    public function getBalanceFormattedAttribute()
    {
        return money($this->balance, config('money.defaults.currency'), true)->format();
    }

    /**
     * Deposit money to the user's account.
     */
    public function deposit(float $amount): void
    {
        $this->increment('balance', $amount);
    }

    /**
     * Withdraw money from the user's account.
     */
    public function withdraw(float $amount): bool
    {
        if ($this->balance < $amount) {
            return false;
        }

        $this->decrement('balance', $amount);
        return true;
    }

    /**
     * Get the current balance.
     */
    public function getBalance(): float
    {
        return $this->balance;
    }


    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function homeworks()
    {
        return $this->hasManyThrough(Homework::class, Lecture::class, 'course_id', 'lecture_id');
    }
}
