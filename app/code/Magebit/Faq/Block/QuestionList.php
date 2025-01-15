<?php
/**
 * @copyright Copyright (c) 2024 Magebit
 * @author    Magebit
 * @license   GNU General Public License ("GPL") v3.0
 */
declare(strict_types=1);

namespace Magebit\Faq\Block;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Cms\Model\Template\FilterProvider;
use Exception;

class QuestionList extends Template
{
    /**
     * @param Context $context
     * @param QuestionRepositoryInterface $questionRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param FilterProvider $filterProvider
     * @param array $data
     */
    public function __construct(
        private readonly Context $context,
        private readonly QuestionRepositoryInterface $questionRepository,
        private readonly SearchCriteriaBuilder $searchCriteriaBuilder,
        private readonly SortOrderBuilder $sortOrderBuilder,
        private readonly FilterProvider $filterProvider,
        array $data = []
    ) {
        parent::__construct($this->context, $data);
    }

    /**
     * Get a collection of FAQ questions sorted by position
     *
     * @return QuestionInterface[]
     */
    public function getQuestions(): array
    {
        $sortOrder = $this->sortOrderBuilder
            ->setField('position')
            ->setAscendingDirection()
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('status', 1)
            ->addSortOrder($sortOrder)
            ->create();

        $questionList = $this->questionRepository->getList($searchCriteria);
        return $questionList->getItems();
    }

    /**
     * Filter HTML content
     *
     * @param string $content
     * @return string
     * @throws Exception
     */
    public function filterContent(string $content): string
    {
        return $this->filterProvider->getPageFilter()->filter($content);
    }
}
