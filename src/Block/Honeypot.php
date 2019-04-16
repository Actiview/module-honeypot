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
     * Get form css selectors
     *
     * @return mixed
     */
    public function getForms()
    {
        return $this->configuration->getForms();
    }
}
