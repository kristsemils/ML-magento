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
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magebit\Faq\Api\Data\QuestionInterface;

class InlineEdit extends Action
{
    /**
     * Constructor
     *
     * @param Context $context
     * @param QuestionRepositoryInterface $questionRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        private readonly Context $context,
        private readonly QuestionRepositoryInterface $questionRepository,
        private readonly JsonFactory $jsonFactory
    ) {
        parent::__construct($this->context);
    }

    /**
     * Inline edit action
     *
     * @return Json
     */
    public function execute(): Json
    {
        $result = $this->jsonFactory->create();
        $postItems = $this->getRequest()->getParam('items', []);

        if (!is_array($postItems) || empty($postItems)) {
            return $result->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        /**
         * @var QuestionInterface $question
         */
        foreach (array_keys($postItems) as $faqId) {
            try {
                $question = $this->questionRepository->get($faqId);
                $questionData = $postItems[$faqId];

                foreach ($questionData as $key => $value) {
                    $question->setData($key, $value);
                }

                $this->questionRepository->save($question);
            } catch (LocalizedException $e) {
                return $result->setData([
                    'messages' => [$e->getMessage()],
                    'error' => true,
                ]);
            } catch (Exception $e) {
                return $result->setData([
                    'messages' => [__('Something went wrong while saving the FAQ.')],
                    'error' => true,
                ]);
            }
        }
        return $result->setData([
            'messages' => [__('You have successfully saved the FAQ.')],
            'error' => false,
        ]);
    }
}
