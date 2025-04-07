<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements JWTSubject, AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $guard_name = "api";

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function ExpertSKill()
    {
        return $this->hasOne(ExpertSkillRate::class, 'user_id');        
    }

    public function ExpertService()
    {
        return $this->hasOne(ExpertService::class, 'user_id');        
    }

    public function ExpertSecurityQuestion()
    {
        return $this->hasOne(ExpertSecurityQuestion::class, 'user_id');        
    }

    public function ExpertInformation()
    {
        return $this->hasOne(ExpertInformation::class, 'user_id');        
    }

    public function ExpertEducation()
    {
        return $this->hasOne(ExpertEducation::class, 'user_id');        
    }


    public function ExpertExperience()
    {
        return $this->hasOne(ExpertExperience::class, 'user_id');        
    }


    public function favorite()
    {
        return $this->hasOne(Favorite::class, 'expert_id');        
    }

    
    public function ticket()
    {
        return $this->hasOne(Ticket::class, 'user_id');        
    }


}
