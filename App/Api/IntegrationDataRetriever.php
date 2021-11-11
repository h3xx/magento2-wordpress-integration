<?php
/**
 * @package FishPig_WordPress
 * @author  Ben Tideswell (ben@fishpig.com)
 * @url     https://fishpig.co.uk/magento/wordpress-integration/
 */
declare(strict_types=1);

namespace FishPig\WordPress\App\Api;

class IntegrationDataRetriever
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @param \FishPig\WordPress\App\Api\Rest\Client $apiClient
     */
    public function __construct(
        \FishPig\WordPress\App\Api\Rest\RequestManager $restRequestManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->restRequestManager = $restRequestManager;
        $this->storeManager = $storeManager;
    }

    /**
     * @param $key = null
     * @return mixed
     */
    public function getData($key = null)
    {
        $storeId = (int)$this->storeManager->getStore()->getId();

        if (!isset($this->data[$storeId])) {
            $this->data[$storeId] = $this->restRequestManager->getJson('/fishpig/v1/data');
        }

        if ($key === null) {
            return $this->data[$storeId];
        }

        if (!isset($this->data[$storeId][$key])) {
            throw new \FishPig\WordPress\App\Api\Exception\MissingApiDataException('Unable to get ' . $key . ' from API data.');
        }

        return $this->data[$storeId][$key];
    }
}