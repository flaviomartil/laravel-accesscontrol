<?php

namespace App\Models\User;

use App\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\GroupAccess\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasUuids;
    use Notifiable;
    use LogsActivity;

    protected $fillable = [
        'email',
        'document',
        'password',
        'status',
        'identifier',
        'last_password_update',
        'created_by',
        'updated_by'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Hash::make($value)
        );
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function acceptTermsofUse()
    {
        return $this->hasOne(UserUseTermAcceptance::class, 'user_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->useLogName('User')
            ->logOnly(['email', 'document', 'password', 'status', 'identifier', 'last_password_update','remember_token'])
            ->logOnlyDirty();
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }


    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'created_by', 'id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'group_access', 'user_id', 'role_id');
    }

    public function permissions()
    {
        return $this->roles()->with('permissions')->get()->pluck('permissions')->flatten()->unique('id');
    }

    public function modules()
    {
        return $this->permissions()->map(function ($permission) {
            return $permission->module;
        })->unique('id');
    }

    public function getAccessDetails()
    {
        $roles = $this->roles;
        $modules = $this->modules();
        $permissions = $this->permissions();

        $accessDetails = [
            'roles' => $roles->pluck('name'),
            'modules' => $modules->mapWithKeys(function ($module) {
                return [
                    $module->name => [
                        'permissions' => $module->permissions->pluck('name')
                    ]
                ];
            }),
        ];

        return $accessDetails;
    }
}
