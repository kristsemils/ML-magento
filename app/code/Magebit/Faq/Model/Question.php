<?php
/**
 * @copyright Copyright (c) 2024 Magebit
 * @author    Magebit
 * @license   GNU General Public License ("GPL") v3.0
 */

namespace Magebit\Faq\Model;

use Magento\Framework\Model\AbstractModel;
use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Model\ResourceModel\Question as QuestionResource;

/**
 * Question model class
 * This class represents a FAQ question in the system and provides methods to get and set its properties.
 */
class Question extends AbstractModel implements QuestionInterface
{
    /**
     * Constants for column names
     */
    const ID = 'id';
    const QUESTION = 'question';
    const ANSWER = 'answer';
    const STATUS = 'status';
    const POSITION = 'position';
    const UPDATED_AT = 'updated_at';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(QuestionResource::class);
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return Question|AbstractModel
     */
    public function setId($id): Question|AbstractModel
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Get question text
     *
     * @return string|null
     */
    public function getQuestion()
    {
        return $this->getData(self::QUESTION);
    }

    /**
     * Set question text
     *
     * @param string $question
     * @return Question|QuestionInterface
     */
    public function setQuestion($question): Question|QuestionInterface
    {
        return $this->setData(self::QUESTION, $question);
    }

    /**
     * Get answer text
     *
     * @return string|null
     */
    public function getAnswer()
    {
        return $this->getData(self::ANSWER);
    }

    /**
     * Set answer text
     *
     * @param string $answer
     * @return Question|QuestionInterface
     */
    public function setAnswer($answer): Question|QuestionInterface
    {
        return $this->setData(self::ANSWER, $answer);
    }

    /**
     * Get status
     *
     * @return int|null
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Set status
     *
     * @param int $status
     * @return Question|QuestionInterface
     */
    public function setStatus($status): Question|QuestionInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Get position
     *
     * @return int|null
     */
    public function getPosition()
    {
        return $this->getData(self::POSITION);
    }

    /**
     * Set position
     *
     * @param int $position
     * @return Question|QuestionInterface
     */
    public function setPosition($position): Question|QuestionInterface
    {
        return $this->setData(self::POSITION, $position);
    }

    /**
     * Get updated at timestamp
     *
     * @return string|null
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * Set updated at timestamp
     *
     * @param string $updatedAt
     * @return Question
     */
    public function setUpdatedAt($updatedAt): Question
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
