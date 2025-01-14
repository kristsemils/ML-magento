<?php
namespace Magebit\Faq\Api\Data;

interface QuestionInterface
{
    const ID = 'id';
    const QUESTION = 'question';
    const ANSWER = 'answer';
    const STATUS = 'status';
    const POSITION = 'position';
    const UPDATED_AT = 'updated_at';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get question
     *
     * @return string|null
     */
    public function getQuestion();

    /**
     * Set question
     *
     * @param string $question
     * @return $this
     */
    public function setQuestion($question);

    /**
     * Get answer
     *
     * @return string|null
     */
    public function getAnswer();

    /**
     * Set answer
     *
     * @param string $answer
     * @return $this
     */
    public function setAnswer($answer);

    /**
     * Get status
     *
     * @return int|null
     */
    public function getStatus();

    /**
     * Set status
     *
     * @param int $status
     * @return $this
     */
    public function setStatus($status);

    /**
     * Get position
     *
     * @return int|null
     */
    public function getPosition();

    /**
     * Set position
     *
     * @param int $position
     * @return $this
     */
    public function setPosition($position);

    /**
     * Get updated at
     *
     * @return string|null
     */
    public function getUpdatedAt();
}

