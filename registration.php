<?php

/**
 * Equaltrue - Suvankar Paul
 *
 * This source file is subject to the Equaltrue license
 *
 * @category  Support
 * @package   Equaltrue_Support
 * @copyright Copyright (c) Equaltrue (https://equaltrue.com)
 * @author    Suvankar Paul
 */

declare(strict_types=1);

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Equaltrue_Support',
    __DIR__
);
