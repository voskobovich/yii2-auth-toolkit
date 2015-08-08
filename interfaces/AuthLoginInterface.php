<?php

namespace voskobovich\auth\interfaces;

/**
 * Interface AuthLoginInterface
 * @package voskobovich\auth\interfaces
 */
interface AuthLoginInterface
{
    /**
     * Auth user logic
     * @return bool
     */
    public function login();
}