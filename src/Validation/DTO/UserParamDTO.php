<?php

namespace App\Validation\DTO;

use App\Validation\Normalizer\Value\BooleanValue;
use App\Validation\Normalizer\Value\IntegerArrayValue;
use App\Validation\Normalizer\Value\LastLoginAtValue;

class UserParamDTO
{
    private BooleanValue $isActive;

    private BooleanValue $isMember;

    private LastLoginAtValue $lastLoginAt;

    private IntegerArrayValue $userTypes;

    public function __construct()
    {
        $this->isActive = new BooleanValue(null);
        $this->isMember = new BooleanValue(null);
        $this->lastLoginAt = new LastLoginAtValue(['start' => null, 'end' => null]);
        $this->userTypes = new IntegerArrayValue([]);
    }

    public function getIsActive(): BooleanValue
    {
        return $this->isActive;
    }

    public function setIsActive(BooleanValue $isActive): UserParamDTO
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getIsMember(): BooleanValue
    {
        return $this->isMember;
    }

    public function setIsMember(BooleanValue $isMember): UserParamDTO
    {
        $this->isMember = $isMember;
        return $this;
    }

    public function getLastLoginAt(): LastLoginAtValue
    {
        return $this->lastLoginAt;
    }

    public function setLastLoginAt(LastLoginAtValue $lastLoginAt): UserParamDTO
    {
        $this->lastLoginAt = $lastLoginAt;
        return $this;
    }

    public function getUserTypes(): IntegerArrayValue
    {
        return $this->userTypes;
    }

    public function setUserTypes(IntegerArrayValue $userTypes): UserParamDTO
    {
        $this->userTypes = $userTypes;
        return $this;
    }


}