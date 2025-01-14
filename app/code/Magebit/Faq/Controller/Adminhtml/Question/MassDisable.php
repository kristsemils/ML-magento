<?php
/**
 * @copyright Copyright (c) 2024 Magebit
 * @author    Magebit
 * @license   GNU General Public License ("GPL") v3.0
 */

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Ui\Component\MassAction\Filter;
use Magebit\Faq\Model\ResourceModel\Question\CollectionFactory;
use Magebit\Faq\Api\QuestionRepositoryInterface;

class MassDisable extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level
     */
    const string ADMIN_RESOURCE = 'Magebit_Faq::faq';

    /**
     * Constructor
     *
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param QuestionRepositoryInterface $questionRepository
     */
    public function __construct(
        private readonly Context $context,
        private readonly Filter $filter,
        private readonly CollectionFactory $collectionFactory,
        private readonly QuestionRepositoryInterface $questionRepository
    ) {
        parent::__construct($this->context);
    }

    /**
     * Execute the mass disable action
     *
     * @return Redirect
     * @throws NotFoundException|LocalizedException
     */
    public function execute(): Redirect
    {
        if (!$this->getRequest()->isPost()) {
            throw new NotFoundException(__('Page not found'));
        }

        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $questionsDisabled = 0;

        foreach ($collection->getItems() as $question) {
            try {
                $question->setStatus(0);
                $this->questionRepository->save($question);
                $questionsDisabled++;
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('Error occurred while disabling the question with ID %1: %2', $question->getId(), $e->getMessage())
                );
            }
        }

        if ($questionsDisabled) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been disabled.', $questionsDisabled)
            );
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
    }
}
