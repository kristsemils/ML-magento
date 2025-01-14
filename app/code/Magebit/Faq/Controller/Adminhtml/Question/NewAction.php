<?php
/**
 * @copyright Copyright (c) 2024 Magebit
 * @author    Magebit
 * @license   GNU General Public License ("GPL") v3.0
 */

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\Controller\ResultInterface;

class NewAction extends Action
{
    /**
     * @param Context $context
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(
        private readonly Context $context,
        private readonly ForwardFactory $resultForwardFactory
    ) {
        parent::__construct($this->context);
    }

    /**
     * Execute action to create a new FAQ question
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }

    /**
     * Check if the user is allowed to access this action
     *
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('Magebit_Faq::faq');
    }
}
