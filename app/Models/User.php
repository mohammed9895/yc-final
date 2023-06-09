<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Freelancers;
use Carbon\Carbon;
use App\Models\GCCCamp;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Interfaces\MustVerifyMobile as IMustVerifyMobile;

class User extends Authenticatable implements HasAvatar
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

//    public function canAccessFilament(): bool
//    {
//        return str_ends_with($this->email, '@yc.om');
//    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getFilamentAvatarUrl(): ?string
    {
        return '/storage/' . $this->avatar;
    }

    public function isAdmin()
    {
        $this->hasRole('super_admin');
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function disability()
    {
        return $this->belongsTo(Disability::class);
    }


    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function educationType()
    {
        return $this->belongsTo(EducationType::class);
    }

    public function employeeType()
    {
        return $this->belongsTo(EmployeeType::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function workshops()
    {
        return $this->hasMany(Workshop::class);
    }

    public function events()
    {
        return $this->hasMany(Booking::class);
    }

    public function attendees()
    {
        return $this->hasMany(Attendees::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluate::class);
    }

    public function hasVerifiedPhone()
    {
        return !is_null($this->phone_verified_at);
    }

    public function threeD()
    {
        return $this->hasMany(ThreeD::class);
    }
    public function trainingApplication()
    {
        return $this->hasMany(TrainingApplication::class);
    }


    public function freelancers()
    {
        return $this->hasMany(Freelancers::class);
    }

    public function company()
    {
        return $this->hasMany(Company::class);
    }

    public function GCCCamps()
    {
        return $this->hasMany(GCCCamp::class);
    }

    public function markPhoneAsVerified()
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
    }
}
