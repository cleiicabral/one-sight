<?php

namespace App\Resource;

use App\Entity\User;
use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\SerializedName;

class UserResource{

    /**
     * @SerializedName("id")
     */
    public string $id;

    /**
     * @SerializedName("name")
     */
    public string $name;

    /**
     * @SerializedName("email")
     */
    public string $email;

    /**
     * @SerializedName("created_at")
     */
    public DateTimeImmutable $created_at;

    public function __construct(User $user)
    {
        
        $this->id = $user->getId();
        $this->name = $user->getName();
        $this->email = $user->getEmail();
        $this->created_at = $user->getCreatedAt();

    }
}