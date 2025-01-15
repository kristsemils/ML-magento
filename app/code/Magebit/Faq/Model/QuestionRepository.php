<?php
/**
 * @copyright Copyright (c) 2024 Magebit
 * @author    Magebit
 * @license   GNU General Public License ("GPL") v3.0
 */
declare(strict_types=1);

namespace Magebit\Faq\Model;

use Exception;
use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Model\ResourceModel\Question as ResourceQuestion;
use Magebit\Faq\Model\ResourceModel\Question\Collection;
use Magebit\Faq\Model\ResourceModel\Question\CollectionFactory as QuestionCollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Message\ManagerInterface;

/**
 * @implements QuestionRepositoryInterface
 */
class QuestionRepository implements QuestionRepositoryInterface
{
    /**
     * @param ResourceQuestion $resource
     * @param QuestionFactory $questionFactory
     * @param QuestionCollectionFactory $collectionFactory
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        private readonly ResourceQuestion $resource,
        private readonly QuestionFactory $questionFactory,
        private readonly QuestionCollectionFactory $collectionFactory,
        private readonly ManagerInterface $messageManager
    ) {}

    /**
     * @param int $id
     * @return Question|QuestionInterface|null
     */
    public function getById(int $id): Question|QuestionInterface|null
    {
        try {
            $question = $this->questionFactory->create();
            $this->resource->load($question, $id);

            if (!$question->getId()) {
                $this->messageManager->addErrorMessage(__('Question with id "%1" does not exist.', $id));
                return null;
            }
            return $question;
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__('Error loading question: %1', $e->getMessage()));
            return null;
        }
    }

    /**
     * @param int $id
     * @return Question|QuestionInterface|null
     */
    public function get(int $id): Question|QuestionInterface|null
    {
        try {
            return $this->getById($id);
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__('Error retrieving question: %1', $e->getMessage()));
            return null;
        }
    }

    /**
     * @param QuestionInterface $question
     * @return QuestionInterface|null
     */
    public function save(QuestionInterface $question): ?QuestionInterface
    {
        try {
            $this->resource->save($question);
            return $question;
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__('Could not save the question: %1', $e->getMessage()));
            return null;
        }
    }

    /**
     * @param QuestionInterface $question
     * @return bool
     */
    public function delete(QuestionInterface $question): bool
    {
        try {
            $this->resource->delete($question);
            return true;
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__('Could not delete the question: %1', $e->getMessage()));
            return false;
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool
    {
        try {
            $question = $this->getById($id);
            if ($question === null) {
                return false;
            }
            return $this->delete($question);
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__('Error deleting question: %1', $e->getMessage()));
            return false;
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return Collection
     */
    public function getList(SearchCriteriaInterface $searchCriteria): Collection
    {
        try {
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
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__('Error retrieving question list: %1', $e->getMessage()));
            return $this->collectionFactory->create();
        }
    }
}
