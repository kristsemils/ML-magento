<?php
/**
 * @copyright Copyright (c) 2024 Magebit
 * @author    Magebit
 * @license   GNU General Public License ("GPL") v3.0
 */
declare(strict_types=1);

namespace Magebit\Faq\Api;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Model\ResourceModel\Question;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magebit\Faq\Model\ResourceModel\Question\Collection;

interface QuestionRepositoryInterface
{
    /**
     * Save question
     *
     * @param QuestionInterface $question
     * @return QuestionInterface|null
     */
    public function save(QuestionInterface $question): ?QuestionInterface;

    /**
     * Get question by ID
     *
     * @param int $id
     * @return Question|QuestionInterface|null
     */
    public function getById(int $id): Question|QuestionInterface|null;

    /**
     * Get list of questions
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return Collection
     */
    public function getList(SearchCriteriaInterface $searchCriteria): Collection;

    /**
     * Delete question
     *
     * @param QuestionInterface $question
     * @return bool
     */
    public function delete(QuestionInterface $question): bool;

    /**
     * Delete question by ID
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;
}

