<?php
/**
 * @package FishPig_WordPress
 * @author  Ben Tideswell (ben@fishpig.com)
 * @url     https://fishpig.co.uk/magento/wordpress-integration/
 */
declare(strict_types=1);

namespace FishPig\WordPress\Api\Data;

interface MetaDataProviderInterface
{
    /**
     * @param  \FishPig\WordPress\Api\Data\ViewableModelInterface $object
     * @param  string $key
     * @return mixed
     */
    public function getValue(
        \FishPig\WordPress\Api\Data\ViewableModelInterface $object,
        string $key
    );
}
