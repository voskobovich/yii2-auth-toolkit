<?php

namespace voskobovich\auth\interfaces;

/**
 * Interface AuthUserInterface
 * @package voskobovich\auth\interfaces
 */
interface AuthUserInterface
{
    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password);
}