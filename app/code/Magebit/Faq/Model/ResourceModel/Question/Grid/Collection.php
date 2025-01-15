<?php
/**
 * @copyright Copyright (c) 2024 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit
 * @license   GNU General Public License ("GPL") v3.0
 */

declare(strict_types=1);

namespace Magebit\Faq\Model\ResourceModel\Question\Grid;

use Magebit\Faq\Model\ResourceModel\Question as ResourceModel;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use Psr\Log\LoggerInterface as Logger;

class Collection extends SearchResult
{
    /**
     * Collection constructor
     *
     * @param EntityFactory $entityFactory
     * @param Logger $logger
     * @param FetchStrategy $fetchStrategy
     * @param EventManager $eventManager
     * @param string $mainTable
     * @param string $resourceModel
     * @throws LocalizedException
     */
    public function __construct(
        private readonly EntityFactory $entityFactory,
        private readonly Logger $logger,
        private readonly FetchStrategy $fetchStrategy,
        private readonly EventManager $eventManager,
        private readonly string $mainTable = 'faq',
        private readonly string $resourceModel = ResourceModel::class
    ) {
        parent::__construct(
            $this->entityFactory,
            $this->logger,
            $this->fetchStrategy,
            $this->eventManager,
            $this->mainTable,
            $this->resourceModel
        );
    }

    /**
     * Set default sorting before loading collection
     *
     * @return $this|Collection
     */
    protected function _beforeLoad(): Collection
    {
        parent::_beforeLoad();
        $this->setOrder('id', 'ASC');
        return $this;
    }
}
