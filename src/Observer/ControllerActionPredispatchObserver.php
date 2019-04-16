<?php

namespace Actiview\Honeypot\Observer;

use Actiview\Honeypot\Model\Configuration;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\NotFoundException;

/**
 * Class ControllerActionPredispatchObserver
 *
 * @package Actiview\Honeypot
 */
class ControllerActionPredispatchObserver implements ObserverInterface
{
    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * @var ForwardFactory
     */
    protected $forwardFactory;

    /**
     * @param Configuration $configuration
     * @param ForwardFactory $forwardFactory
     */
    public function __construct(
        Configuration $configuration,
        ForwardFactory $forwardFactory
    ) {
        $this->configuration = $configuration;
        $this->forwardFactory = $forwardFactory;
    }

    /**
     * @param Observer $observer
     * @return void|Forward
     */
    public function execute(Observer $observer)
    {
        if (!$this->configuration->isEnabled()) {
            return;
        }

        /** @var RequestInterface $request */
        $request = $observer->getEvent()->getData('request');

        if ($this->shouldValidateRequest($request)
            && !$this->validateRequest($request)
        ) {
            return $this->forwardFactory->create()->forward('noroute');
        }
    }

    /**
     * @param RequestInterface $request
     * @return bool
     */
    private function shouldValidateRequest(RequestInterface $request)
    {
        if (in_array($request->getFullActionName(), $this->configuration->getActions())) {
            return true;
        }

        return false;
    }

    /**
     * Validate that the honeypot field is present in request and that field is empty.
     *
     * @param RequestInterface $request
     * @return bool
     */
    private function validateRequest(RequestInterface $request)
    {
        $field = $this->configuration->getFieldName();
        $params = $request->getParams();
        $notEmpty = new \Magento\Framework\Validator\NotEmpty();

        if (!isset($params[$field])
            || $notEmpty->isValid(trim($request->getParam($field)))
        ) {
            return false;
        }

        return true;
    }
}
