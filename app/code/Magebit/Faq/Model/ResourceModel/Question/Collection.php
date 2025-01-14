<?php
/**
 * @copyright Copyright (c) 2024 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit
 * @license   GNU General Public License ("GPL") v3.0
 */

namespace Magebit\Faq\Model\ResourceModel\Question;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magebit\Faq\Model\Question;
use Magebit\Faq\Model\ResourceModel\Question as QuestionResource;

class Collection extends AbstractCollection
{
    /**
     * Initialize collection model and resource model
     */
    protected function _construct(): void
    {
        $this->_init(Question::class, QuestionResource::class);
    }
}
