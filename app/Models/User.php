<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    use HasFactory, Notifiable;

    public const ID_COLUMN = 'id';
    public const STATUS_COLUMN = 'status';
    public const EMAIL_COLUMN = 'email';
    public const NAME_COLUMN = 'name';
    public const PASSWORD_COLUMN = 'password';
    public const VERIFICATION_TOKEN_COLUMN = 'verification_token';
    public const REMEMBER_TOKEN_COLUMN = 'remember_token';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::STATUS_COLUMN,
        self::EMAIL_COLUMN,
        self::NAME_COLUMN,
        self::PASSWORD_COLUMN,
        self::VERIFICATION_TOKEN_COLUMN,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        self::PASSWORD_COLUMN,
        self::REMEMBER_TOKEN_COLUMN,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public function getId(): string
    {
        return $this->getAttribute(self::ID_COLUMN);
    }

    public function getName(): string
    {
        return $this->getAttribute(self::NAME_COLUMN);
    }

    public function getEmail(): string
    {
        return $this->getAttribute(self::EMAIL_COLUMN);
    }

    public function getStatus(): int
    {
        return $this->getAttribute(self::STATUS_COLUMN);
    }

    public function getVerificationToken(): ?string
    {
        return $this->getAttribute(self::VERIFICATION_TOKEN_COLUMN);
    }

    public function getJWTIdentifier(): string
    {
        return $this->getId();
    }

    public function getJWTCustomClaims(): array
    {
        return [
            'name'   => $this->getName(),
            'email'  => $this->getEmail(),
            'status' => $this->getStatus(),
        ];
    }
}
