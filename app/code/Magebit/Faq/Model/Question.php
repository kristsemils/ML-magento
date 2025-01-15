<?php
declare(strict_types=1);

namespace Magebit\Faq\Model;

use Magento\Framework\Model\AbstractModel;
use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Model\ResourceModel\Question as QuestionResource;

class Question extends AbstractModel implements QuestionInterface
{
    protected function _construct(): void
    {
        $this->_init(QuestionResource::class);
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        $id = $this->getData(self::ID);
        return $id !== null ? (int)$id : null;
    }

    /**
     * @param $id
     * @return Question
     */
    public function setId($id): Question
    {
        return $this->setData(self::ID, (int)$id);
    }

    /**
     * Get question text
     *
     * @return string
     */
    public function getQuestion(): string
    {
        return (string)$this->getData(self::QUESTION);
    }

    /**
     * Set question text
     *
     * @param string $question
     * @return Question|QuestionInterface
     */
    public function setQuestion(string $question): Question|QuestionInterface
    {
        return $this->setData(self::QUESTION, $question);
    }

    /**
     * Get answer text
     *
     * @return string
     */
    public function getAnswer(): string
    {
        return (string)$this->getData(self::ANSWER);
    }

    /**
     * Set answer text
     *
     * @param string $answer
     * @return Question|QuestionInterface
     */
    public function setAnswer(string $answer): Question|QuestionInterface
    {
        return $this->setData(self::ANSWER, $answer);
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus(): int
    {
        return (int)$this->getData(self::STATUS);
    }

    /**
     * Set status
     *
     * @param int $status
     * @return Question|QuestionInterface
     */
    public function setStatus(int $status): Question|QuestionInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Get position
     *
     * @return int
     */
    public function getPosition(): int
    {
        return (int)$this->getData(self::POSITION);
    }

    /**
     * Set position
     *
     * @param int $position
     * @return Question|QuestionInterface
     */
    public function setPosition(int $position): Question|QuestionInterface
    {
        return $this->setData(self::POSITION, $position);
    }

    /**
     * Get updated at timestamp
     *
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return (string)$this->getData(self::UPDATED_AT);
    }

    /**
     * Set updated at timestamp
     *
     * @param string $updatedAt
     * @return Question
     */
    public function setUpdatedAt(string $updatedAt): Question
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
