<?php

namespace App;

use App\Http\Controllers\Helpers\Helpers;
use App\Traits\UserRoleTrait;
use App\Traits\PersonalAccessTokenTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Auth;
use Laravel\Passport\Passport;
use \Illuminate\Database\Eloquent\Relations\HasMany,
    \Illuminate\Database\Eloquent\Relations\BelongsToMany,
    \Illuminate\Database\Eloquent\Relations\HasOne;
use App\Notifications\UserResetPasswordNotification;


class User extends Authenticatable
{
    use PersonalAccessTokenTrait, HasApiTokens, Notifiable, UserRoleTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'email', 'status', 'image', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public $userInfo = ['imagePath' => '/assets/images/user_profiles/', 'preThumb' => '96x96-'];
    protected $defaultStatus = ['pending', 'approved', 'disabled'];

    /**
     * @StartActions
     */

    /**
     * @todo delete user all related user information
     * @return bool
     */
    public function destroyInfo(): bool
    {
        if ($this->image === 'logo.png') {
            return true;
        }
        $deleted = Helpers::removeFile($this->userInfo['imagePath'] . $this->userInfo['preThumb'] . $this->image);
        return $deleted && Helpers::removeFile($this->userInfo['imagePath'] . $this->image);
    }

    /**
     * @todo change user status
     * @param $status
     * @return bool
     */
    public function setStatus($status): bool
    {
        if ($this->status !== $status && in_array($status, $this->defaultStatus, true)) {
            $this->status = $status;
            $this->save();
            //check if status changed to disabled and sign user out
            if ($status === 'disabled') {
                $this->revokeAllValidTokens();
            }
            //end check if status changed to disabled and sign user out
            return true;
        }
        return false;
    }

    /**
     * @EndActions
     */

    /**
     * @User Educations, Careers
     */
    public function member_educations()
    {
        $educations = $this->educations;
        $educations->map(function ($education) {
            $degree = $education->degree;
            $year = $education->year_of_graduation;
            unset($education->degree);
            $education->degree = ['label' => $degree->name, 'value' => $degree->id];
            $education->year_of_graduated = ['text' => $year, 'value' => (int)$year];
            $education->university = $education->university_graduation;
            $education->validate = json_decode(json_encode([], JSON_FORCE_OBJECT));
            $this->removeEducationUnnecessary($education);
            return $education;
        });
        $shorted = $educations->sortByDesc(function ($education, $key) {
            return $education['year_of_graduated']['value'];
        });
        return $shorted->values();
    }

    public function removeEducationUnnecessary($education): void
    {
        unset($education->user_id, $education->year_of_graduation, $education->university_graduation, $education->created_at, $education->updated_at, $education->education_degree_id);
    }

    public function member_careers()
    {
        $careers = $this->careers;
        $careers->map(function ($career) {
            $career->type_of_organize = $career->organizeData();
            unset($career->organize);
            $start_year = Helpers::toFormatDateString($career->start_date, 'Y');
            $end_year = Helpers::toFormatDateString($career->end_date, 'Y');
            $career->start_year = ['text' => $start_year, 'value' => (int)$start_year];
            $career->end_year = ['text' => $end_year, 'value' => (int)$end_year];
            $career->member_of_state = $career->member_of_state === 'yes';
            $career->work_categories = $career->workCategoriesData();
            $career->validate = json_decode(json_encode([], JSON_FORCE_OBJECT));
            $this->removeCareerUnnecessary($career);
            return $career;
        });
        $shorted = $careers->sortByDesc(function ($career, $key) {
            return $career['end_year']['value'];
        });
        return $shorted->values();
    }

    public function removeCareerUnnecessary($career): void
    {
        unset($career->user_id, $career->created_at, $career->updated_at, $career->start_date, $career->end_date, $career->organize_id);
    }

    /**
     * @User Educations, Careers
     */

    /**
     * @Model relationship
     */
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    /**@Department */

    /**@Relationship */
    public function careers(): HasMany
    {
        return $this->hasMany(MemberCareer::class);
    }

    public function educations(): HasMany
    {
        return $this->hasMany(MemberEducation::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function userType(): HasOne
    {
        return $this->hasOne(UserType::class);
    }

    public function getTypeOfUserAttribute()
    {
        $user = self::find(Auth::user()->id)->userType;
        if (isset($user)) {
            return $user->typeUser;
        }
        return null;
    }

    public function hasRole($role)
    {
        return $this->roles->pluck('name')->contains($role);
    }

    /**@Relationship */

    public function getTokenName()
    {
        return config('app.name', 'Laravel') . '_trusted_token';
    }

    public function getPersonalTokenExpiresDaysInSeconds(): int
    {
        return Helpers::days_to_seconds(config('auth.days_tokens_expire_in'));
    }

    public function transformUser(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'thumb_image' => $this->userInfo['imagePath'] . $this->userInfo['preThumb'] . $this->image,
            'image' => $this->userInfo['imagePath'] . $this->image,
            'email' => $this->email,
            'last_name' => $this->last_name,
            'type' => base64_encode($this->userType->typeUser->name),
        ];
    }

    public function revokeAllValidTokens()
    {
        $validTokens = Passport::$tokenModel::where('user_id', $this->id)
            ->where('client_id', 1)->where('revoked', 0)
            ->update(['revoked' => 1]);

        return $validTokens;
    }

    /**
     * Send mail to the user who request to forgot password
     * @param string $token
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new UserResetPasswordNotification($token));
    }

}
