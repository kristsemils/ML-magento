<?php
/**
 * @copyright Copyright (c) 2024 Magebit
 * @author    Magebit
 * @license   GNU General Public License ("GPL") v3.0
 */

namespace Magebit\Faq\Model;

use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Model\ResourceModel\Question as ResourceQuestion;
use Magebit\Faq\Model\ResourceModel\Question\Collection;
use Magebit\Faq\Model\ResourceModel\Question\CollectionFactory as QuestionCollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Exception;

/**
 * @implements QuestionRepositoryInterface
 */
class QuestionRepository implements QuestionRepositoryInterface
{
    /**
     * @param ResourceQuestion $resource
     * @param QuestionFactory $questionFactory
     * @param QuestionCollectionFactory $collectionFactory
     */
    public function __construct(
        private readonly ResourceQuestion $resource,
        private readonly QuestionFactory $questionFactory,
        private readonly QuestionCollectionFactory $collectionFactory
    ) {}

    /**
     * @param int $id
     * @return Question|QuestionInterface
     * @throws NoSuchEntityException
     */
    public function getById($id): Question|QuestionInterface
    {
        $question = $this->questionFactory->create();
        $this->resource->load($question, $id);
        if (!$question->getId()) {
            throw new NoSuchEntityException(__('Question with id "%1" does not exist.', $id));
        }
        return $question;
    }

    /**
     * @param int $id
     * @return Question|QuestionInterface
     * @throws NoSuchEntityException
     */
    public function get($id): Question|QuestionInterface
    {
        return $this->getById($id);
    }

    /**
     * @param QuestionInterface $question
     * @return QuestionInterface
     * @throws CouldNotSaveException
     */
    public function save(QuestionInterface $question): QuestionInterface
    {
        try {
            $this->resource->save($question);
        } catch (Exception $e) {
            throw new CouldNotSaveException(__('Could not save the question: %1', $e->getMessage()));
        }
        return $question;
    }

    /**
     * @param QuestionInterface $question
     * @return true
     * @throws CouldNotDeleteException
     */
    public function delete(QuestionInterface $question): true
    {
        try {
            $this->resource->delete($question);
        } catch (Exception $e) {
            throw new CouldNotDeleteException(__('Could not delete the question: %1', $e->getMessage()));
        }
        return true;
    }

    /**
     * @param int $id
     * @return true
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById($id): true
    {
        $question = $this->getById($id);
        return $this->delete($question);
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return Collection
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();

        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }

        $sortOrders = $searchCriteria->getSortOrders();
        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }

        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());

        return $collection;
    }
}
