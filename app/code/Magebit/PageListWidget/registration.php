<?php
declare(strict_types=1);

/**
 * Registration file for the Magebit_PageListWidget module.
 *
 * This file registers the module with Magento 2's ComponentRegistrar.
 */

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Magebit_PageListWidget',
    __DIR__
);

