<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
        ];
    }

    /**
     * Map legacy database role values to application role names.
     */
    protected function getRoleAttribute($value)
    {
        return $value === 'staff_warehouse' ? 'admin_gudang' : $value;
    }

    /**
     * Keep admin_gudang values stored as staff_warehouse in the database.
     */
    protected function setRoleAttribute($value)
    {
        $this->attributes['role'] = $value === 'admin_gudang' ? 'staff_warehouse' : $value;
    }

    public function isAdminGudang(): bool
    {
        return $this->role === 'admin_gudang';
    }

    public function isManager(): bool
    {
        return $this->role === 'manager';
    }
}
