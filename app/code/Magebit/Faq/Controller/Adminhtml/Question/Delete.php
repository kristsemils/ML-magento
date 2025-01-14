<?php
/**
 * @copyright Copyright (c) 2024 Magebit
 * @author    Magebit
 * @license   GNU General Public License ("GPL") v3.0
 */

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magebit\Faq\Model\ResourceModel\Question as QuestionResource;
use Magebit\Faq\Model\QuestionFactory;
use Throwable;

class Delete extends Action implements HttpPostActionInterface
{
    /**
     * @param Context $context
     * @param QuestionResource $resource
     * @param QuestionFactory $questionFactory
     */
    public function __construct(
        private readonly Context $context,
        private readonly QuestionResource $resource,
        private readonly QuestionFactory $questionFactory
    ) {
        parent::__construct($this->context);
    }

    /**
     * Execute action to delete a FAQ question
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $questionId = (int) $this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if (!$questionId) {
            $this->messageManager->addErrorMessage(__('We can\'t find a question to delete'));
            return $resultRedirect->setPath('*/*/');
        }

        $model = $this->questionFactory->create();

        try {
            $this->resource->load($model, $questionId);
            $this->resource->delete($model);

            $this->messageManager->addSuccessMessage(__('The question has been deleted.'));
        } catch (Throwable $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }
        return $resultRedirect->setPath('*/*/');
    }
}
