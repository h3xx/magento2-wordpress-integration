<?php
/**
 * @package FishPig_WordPress
 * @author  Ben Tideswell (ben@fishpig.com)
 * @url     https://fishpig.co.uk/magento/wordpress-integration/
 */
declare(strict_types=1);

namespace FishPig\WordPress\App\Integration\Mode;

class ObjectResolver
{
    /**
     * @var object[]
     */
    private $resolvedObject = [];

    /**
     * @param  \FishPig\WordPress\App\Integration\Mode $appMode
     * @return void
     */
    public function __construct(
        \FishPig\WordPress\App\Integration\Mode $appMode,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        array $objects = [],
        bool $throwExceptionIfObjectNotSet = true
    ) {
        $this->appMode = $appMode;
        $this->objectManager = $objectManager;
        $this->objects = $objects;
        $this->throwExceptionIfObjectNotSet = $throwExceptionIfObjectNotSet;
    }

    /**
     * @return Object|false
     */
    public function resolve()
    {
        $mode = $this->appMode->getMode() ?? 'disabled';

        if (!isset($this->resolvedObject[$mode])) {
            $this->resolvedObject[$mode] = false;
            if (!isset($this->objects[$mode])) {
                if ($this->throwExceptionIfObjectNotSet) {
                    throw new \FishPig\WordPress\App\Exception(
                        'Unable to find object in ' . get_class($this) . '::getObject(' . $mode . ')'
                    );
                }
            } else {
                $this->resolvedObject[$mode] = $this->objectManager->get(
                    $this->objects[$mode]
                );
            }
        }

        return $this->resolvedObject[$mode];
    }

    /**
     * @return Object|false
     */
    public function getObject()
    {
        return $this->resolve();
    }
}
