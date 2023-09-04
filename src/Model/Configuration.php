<?php

namespace Actiview\Honeypot\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Configuration
 *
 * @package Actiview\Honeyput
 */
class Configuration
{
    const XML_PATH_ENABLE = 'system/honeypot/enable';
    const XML_PATH_FIELD_NAME = 'system/honeypot/field_name';
    const XML_PATH_FIELD_CLASS = 'system/honeypot/field_class';
    const XML_PATH_ACTIONS = 'system/honeypot/actions';
    const XML_PATH_FORMS = 'system/honeypot/forms';

    /** @var ScopeConfigInterface */
    protected $scopeConfig;

    /**
     * Configuration constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param string $scopeType
     * @param null $scopeCode
     * @return mixed
     */
    public function isEnabled($scopeType = 'store', $scopeCode = null)
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLE, $scopeType, $scopeCode);
    }

    /**
     * @param string $scopeType
     * @param null $scopeCode
     * @return mixed
     */
    public function getFieldName($scopeType = 'store', $scopeCode = null)
    {
        return $this->scopeConfig->getValue(self::XML_PATH_FIELD_NAME, $scopeType, $scopeCode);
    }

    /**
     * @param string $scopeType
     * @param null $scopeCode
     * @return mixed
     */
    public function getFieldClass($scopeType = 'store', $scopeCode = null)
    {
        return $this->scopeConfig->getValue(self::XML_PATH_FIELD_CLASS, $scopeType, $scopeCode);
    }

    /**
     * @param string $scopeType
     * @param null $scopeCode
     * @return mixed
     */
    public function getActions($scopeType = 'store', $scopeCode = null)
    {
        return $this->trimExplode(
            $this->scopeConfig->getValue(self::XML_PATH_ACTIONS, $scopeType, $scopeCode)
        );
    }

    /**
     * @param string $scopeType
     * @param null $scopeCode
     * @return mixed
     */
    public function getForms($scopeType = 'store', $scopeCode = null)
    {
        return $this->trimExplode(
            $this->scopeConfig->getValue(self::XML_PATH_FORMS, $scopeType, $scopeCode)
        );
    }

    /**
     * @param $value
     * @return array
     */
    private function trimExplode($value)
    {
        return array_map('trim', preg_split(
            '/(\r\n|\n|\r)/',
            $value ?? '',
            -1,
            PREG_SPLIT_NO_EMPTY
        ));
    }
}
