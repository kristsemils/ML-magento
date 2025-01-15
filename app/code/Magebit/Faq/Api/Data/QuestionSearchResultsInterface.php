<?php
/**
 * @copyright Copyright (c) 2024 Magebit
 * @author    Magebit
 * @license   GNU General Public License ("GPL") v3.0
 */
declare(strict_types=1);

namespace Magebit\Faq\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface QuestionSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get questions list.
     *
     * @return QuestionInterface[]
     */
    public function getItems(): array;

    /**
     * Set questions list.
     *
     * @param QuestionInterface[] $items
     * @return $this
     */
    public function setItems(array $items): self;
}

