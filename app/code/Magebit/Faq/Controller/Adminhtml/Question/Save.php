<?php
/**
 * @copyright Copyright (c) 2024 Magebit
 * @author    Magebit
 * @license   GNU General Public License ("GPL") v3.0
 */
declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magebit\Faq\Model\QuestionFactory;
use Magebit\Faq\Model\ResourceModel\Question as QuestionResource;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Exception;
use Throwable;

class Save extends Action implements HttpPostActionInterface
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
     * Execute action to save a FAQ question
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $data = $this->getRequest()->getPostValue();

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $model = $this->questionFactory->create();
            if (empty($data['id'])) {
                $data['id'] = null;
            }

            $data['update_time'] = null;
            $model->setData($data);

            try {
                $this->resource->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the Question.'));
                return $resultRedirect->setPath('*/*/');
            } catch (Exception $exception) {
                $this->messageManager->addExceptionMessage($exception);
            } catch (Throwable $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the Question.'));
            }
        }
        return $resultRedirect->setPath('*/*/');
    }
}
