<?php
declare(strict_types=1);

namespace Magebit\Faq\Api\Data;

interface QuestionInterface
{
    public const ID = 'id';
    public const QUESTION = 'question';
    public const ANSWER = 'answer';
    public const STATUS = 'status';
    public const POSITION = 'position';
    public const UPDATED_AT = 'updated_at';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion(): string;

    /**
     * Set question
     *
     * @param string $question
     * @return $this
     */
    public function setQuestion(string $question): self;

    /**
     * Get answer
     *
     * @return string
     */
    public function getAnswer(): string;

    /**
     * Set answer
     *
     * @param string $answer
     * @return $this
     */
    public function setAnswer(string $answer): self;

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus(): int;

    /**
     * Set status
     *
     * @param int $status
     * @return $this
     */
    public function setStatus(int $status): self;

    /**
     * Get position
     *
     * @return int
     */
    public function getPosition(): int;

    /**
     * Set position
     *
     * @param int $position
     * @return $this
     */
    public function setPosition(int $position): self;

    /**
     * Get updated at
     *
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * Set updated at
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt(string $updatedAt): self;
}
