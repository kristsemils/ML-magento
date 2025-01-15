<?php
/**
 * @copyright Copyright (c) 2024 Magebit
 * @author    Magebit
 * @license   GNU General Public License ("GPL") v3.0
 */
declare(strict_types=1);

namespace Magebit\Faq\Api;

interface QuestionManagementInterface
{
    /**
     * Enable question by id
     *
     * @param int $id
     * @return bool
     */
    public function enableQuestion(int $id): bool;

    /**
     * Disable question by id
     *
     * @param int $id
     * @return bool
     */
    public function disableQuestion(int $id): bool;
}

