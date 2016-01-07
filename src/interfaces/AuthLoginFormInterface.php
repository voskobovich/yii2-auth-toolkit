<?php

namespace voskobovich\auth\interfaces;

/**
 * Interface AuthLoginFormInterface
 * @package voskobovich\auth\interfaces
 */
interface AuthLoginFormInterface
{
    /**
     * Auth user logic
     * @return bool
     */
    public function login();
}