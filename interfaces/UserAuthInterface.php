<?php

namespace voskobovich\auth\interfaces;

/**
 * Interface UserAuthInterface
 * @package voskobovich\auth\interfaces
 */
interface UserAuthInterface
{
    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password);
}