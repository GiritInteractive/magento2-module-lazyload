<?php
/**
 * Girit-Interactive
 * http://www.girit-tech.com
 * +972-3-9177788
 * info@girit.biz
 *
 * @package     Girit_LazyLoad
 * @author      Pniel Cohen <pini@girit.biz>
 * @license     https://opensource.org/licenses/OSL-3.0
 * @copyright   © 2018 Girit-Interactive (https://www.girit-tech.com/). All rights reserved.
 */

namespace Girit\LazyLoad\Block\Catalog\Product;

use Magento\Catalog\Block\Product\ImageFactory;
use Magento\Catalog\Helper\ImageFactory as HelperFactory;

class ImageBuilder extends \Magento\Catalog\Block\Product\ImageBuilder
{

    /**
     * @var \Girit\LazyLoad\Helper\Data
     */
    protected $_giritLazyLoadHelper;

    /**
     * @var string
     */
    protected $lazyload = false;

    /**
     * @var string
     */
    protected $lazyloadClass = "";

    /**
     * @var string
     */
    protected $srcAttribute = "src";

    /**
     * @var string
     */
    protected $srcPlaceholder = "";

    /**
     * @param HelperFactory $helperFactory
     * @param ImageFactory $imageFactory
     * @param \Girit\LazyLoad\Helper\Data $giritLazyLoadHelper
     */
    public function __construct(
        HelperFactory $helperFactory,
        ImageFactory $imageFactory,
        \Girit\LazyLoad\Helper\Data $giritLazyLoadHelper
    ) {
        parent::__construct($helperFactory, $imageFactory);
        $this->_giritLazyLoadHelper = $giritLazyLoadHelper;
    }

    /**
     * Set custom attributes
     *
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        if ($this->_giritLazyLoadHelper->isEnabled()) {
            if (isset($attributes['lazyload'])) {
                $this->setLazyload($attributes['lazyload']);
                unset($attributes['lazyload']);
            } else {
                $this->setLazyload('lazyload');
            }
        }
        return parent::setAttributes($attributes);
    }

    /**
     * Set Lazyload type
     *
     * @param string $lazyload (options: "lazyload"/ "easylazy"/ "owlcarousel"/ false)
     * @return $this
     */
    public function setLazyload($lazyload)
    {
        switch ($lazyload) {
            case 'lazyload':
                $this->lazyload = $this->lazyloadClass = 'lazyload';
                $this->srcAttribute = "data-original";
                $this->srcPlaceholder = 'src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"';
                $this->srcPlaceholder = '';
            break;
            case 'easylazy':
                $this->lazyload = $this->lazyloadClass = 'easylazy';
                $this->srcAttribute = "data-src";
                $this->srcPlaceholder = 'src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"';
            break;
            case 'owlcarousel':
                $this->lazyload = $this->lazyloadClass = 'owl-lazy';
                $this->srcAttribute = "data-src";
                $this->srcPlaceholder = 'src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"';
            break;
            default:
                $this->lazyload = false;
                $this->lazyloadClass = '';
                $this->srcAttribute = "src";
                $this->srcPlaceholder = '';
            break;
        }
        return $this;
    }

    /**
     * Get Lazyload class
     *
     * @return mixed
     */
    protected function getLazyloadClass()
    {
        return $this->lazyloadClass;
    }

    /**
     * Get src attribute
     *
     * @return mixed
     */
    protected function getSrcAttribute()
    {
        return $this->srcAttribute;
    }

    /**
     * Get src placeholder
     *
     * @return mixed
     */
    protected function getSrcPalceholder()
    {
        return $this->srcPlaceholder;
    }

    /**
     * Create image block
     *
     * @return \Magento\Catalog\Block\Product\Image
     */
    public function create()
    {
        if (!$this->_giritLazyLoadHelper->isEnabled()) {
            return parent::create();
        }

        /** @var \Magento\Catalog\Helper\Image $helper */
        $helper = $this->helperFactory->create()
            ->init($this->product, $this->imageId);

        $template = $helper->getFrame()
            ? 'Girit_LazyLoad::catalog/product/image.phtml'
            : 'Girit_LazyLoad::catalog/product/image_with_borders.phtml';

        $imagesize = $helper->getResizedImageInfo();

        $data = [
            'data' => [
                'template' => $template,
                'image_url' => $helper->getUrl(),
                'width' => $helper->getWidth(),
                'height' => $helper->getHeight(),
                'label' => $helper->getLabel(),
                'ratio' =>  $this->getRatio($helper),
                'lazyload_class' =>  $this->getLazyloadClass(),
                'src_attribute' =>  $this->getSrcAttribute(),
                'src_placeholder' =>  $this->getSrcPalceholder(),
                'custom_attributes' => $this->getCustomAttributes(),
                'resized_image_width' => !empty($imagesize[0]) ? $imagesize[0] : $helper->getWidth(),
                'resized_image_height' => !empty($imagesize[1]) ? $imagesize[1] : $helper->getHeight(),
            ],
        ];

        return $this->imageFactory->create($data);
    }
}
