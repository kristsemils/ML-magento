<?php
/**
 * @copyright Copyright (c) 2024 Magebit
 * @author    Magebit
 * @license   GNU General Public License ("GPL") v3.0
 */

namespace Magebit\Faq\Api;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Api\Data\QuestionSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface QuestionRepositoryInterface
{
    /**
     * Save question
     *
     * @param QuestionInterface $question
     * @return QuestionInterface
     */
    public function save(QuestionInterface $question);

    /**
     * Get question by ID
     *
     * @param int $id
     * @return QuestionInterface
     */
    public function getById($id);

    /**
     * Get list of questions
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return QuestionSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete question
     *
     * @param QuestionInterface $question
     * @return bool
     */
    public function delete(QuestionInterface $question);

    /**
     * Delete question by ID
     *
     * @param int $id
     * @return bool
     */
    public function deleteById($id);
}

