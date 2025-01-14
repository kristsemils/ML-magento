<?php
/**
 * @copyright Copyright (c) 2024 Magebit
 * @author    Magebit
 * @license   GNU General Public License ("GPL") v3.0
 */

namespace Magebit\Faq\Model;

use Magebit\Faq\Api\QuestionManagementInterface;
use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Question Management class
 *
 * This class implements the QuestionManagementInterface and provides methods
 * to enable and disable FAQ questions.
 */
class QuestionManagement implements QuestionManagementInterface
{
    /**
     * Constructor
     *
     * @param QuestionRepositoryInterface $questionRepository
     */
    public function __construct(
        private readonly QuestionRepositoryInterface $questionRepository
    ){}

    /**
     * Enable a question by its ID
     *
     * @param int $id
     * @return bool
     * @throws NoSuchEntityException
     */
    public function enableQuestion($id): bool
    {
        $question = $this->questionRepository->get($id);
        $question->setStatus(1);
        $this->questionRepository->save($question);
        return true;
    }

    /**
     * Disable a question by its ID
     *
     * @param int $id
     * @return bool
     * @throws NoSuchEntityException
     */
    public function disableQuestion($id): bool
    {
        $question = $this->questionRepository->get($id);
        $question->setStatus(0);
        $this->questionRepository->save($question);
        return true;
    }
}
