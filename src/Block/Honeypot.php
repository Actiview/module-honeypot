<?php

namespace Actiview\Honeypot\Block;

use Magento\Framework\View\Element\Template;
use Actiview\Honeypot\Model\Configuration;

/**
 * Class Honeypot
 *
 * @package Actiview\Honeypot
 */
class Honeypot extends Template
{
    protected $_template = 'Actiview_Honeypot::honeypot.phtml';

    /** @var Configuration */
    protected $configuration;

    /**
     * @param Template\Context $context
     * @param Configuration $configuration
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Configuration $configuration,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->configuration = $configuration;
    }

    /**
     * @inheritdoc
     */
    public function _toHtml()
    {
        if (!$this->configuration->isEnabled()) {
            return 'test';
        }

        return parent::_toHtml();
    }

    /**
     * @return mixed
     */
    public function getFieldName()
    {
        return $this->configuration->getFieldName();
    }

    /**
     * @return mixed
     */
    public function getFieldClass()
    {
        return $this->configuration->getFieldClass();
    }

    /**
     * @return mixed
     */
    public function getForms()
    {
        return $this->configuration->getForms();
    }
}
