<?php

namespace voskobovich\auth\interfaces;

/**
 * Interface UserAuthInterface
 * @package voskobovich\auth\interfaces
 */
interface UserAuthInterface
{
    /**
     * @return bool
     */
    public function validatePassword();
}