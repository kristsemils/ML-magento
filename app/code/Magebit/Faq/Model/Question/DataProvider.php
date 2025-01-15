<?php
/**
 * @copyright Copyright (c) 2024 Magebit
 * @author    Magebit
 * @license   GNU General Public License ("GPL") v3.0
 */

declare(strict_types=1);

namespace Magebit\Faq\Model\Question;

use Magebit\Faq\Model\Question;
use Magebit\Faq\Model\QuestionFactory;
use Magebit\Faq\Model\ResourceModel\Question as QuestionResource;
use Magebit\Faq\Model\ResourceModel\Question\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;

class DataProvider extends ModifierPoolDataProvider
{
    /**
     * @var array
     */
    private array $loadedData = [];

    /**
     * DataProvider constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param QuestionResource $resource
     * @param QuestionFactory $questionFactory
     * @param RequestInterface $request
     * @param PoolInterface|null $pool
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        private readonly CollectionFactory $collectionFactory,
        private readonly QuestionResource $resource,
        private readonly QuestionFactory $questionFactory,
        private readonly RequestInterface $request,
        private readonly ?PoolInterface $pool = null,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $this->pool);
        $this->collection = $this->collectionFactory->create();
    }

    /**
     * Get current question
     *
     * @return array
     */
    public function getData(): array
    {
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        foreach ($items as $question) {
            $this->loadedData[$question->getId()] = $question->getData();
        }

        $post = $this->getCurrentQuestion();
        if ($post && $post->getId()) {
            $this->loadedData[$post->getId()] = $post->getData();
        }

        return $this->loadedData;
    }

    /**
     * Get current question
     *
     * @return Question
     */
    private function getCurrentQuestion(): Question
    {
        $questionId = $this->getQuestionId();
        $question = $this->questionFactory->create();
        if (!$questionId) {
            return $question;
        }

        $this->resource->load($question, $questionId);
        return $question;
    }

    /**
     * Get question ID from request
     *
     * @return int
     */
    private function getQuestionId(): int
    {
        return (int) $this->request->getParam($this->getRequestFieldName());
    }
}
