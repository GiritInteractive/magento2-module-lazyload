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

namespace Girit\LazyLoad\Plugin\Block\Catalog\Category;

/**
 * Class View
 */
class View
{
    /**
     * @var \Girit\LazyLoad\Helper\Data
     */
    protected $_giritLazyLoadHelper;

    /**
     * @param \Girit\LazyLoad\Helper\Data $giritLazyLoadHelper
     */
    public function __construct(
        \Girit\LazyLoad\Helper\Data $giritLazyLoadHelper
    ) {
        $this->_giritLazyLoadHelper = $giritLazyLoadHelper;
    }

    public function afterGetCmsBlockHtml($subject, $html)
    {
        if (!$this->_giritLazyLoadHelper->isEnabled() || !$this->_giritLazyLoadHelper->isAutoReplaceCmsBlocks() || in_array($subject->getCurrentCategory()->getLandingPage(), $this->_giritLazyLoadHelper->getIgnoredCmsBlocksArray())) {
            return $html;
        }

        $_hagImages = false;
        $_hagIframes = false;

        if (stripos($html, "<img ") !== false) {
            $_hagImages = true;
        }

        if (stripos($html, "<iframe ") !== false) {
            $_hagIframes = true;
        }

        if ($_hagImages || $_hagIframes) {
            $simpleHtmlDom = new \simple_html_dom();
            $simpleHtmlDom->load($html);

            if ($_hagImages) {
                foreach ($simpleHtmlDom->find('img') as $element) {
                    if (strpos($element->class, "lazyload") === false && strpos($element->class, "easylazy") === false && strpos($element->class, "owl-lazy") === false) {
                        $element->class = 'lazyload ' . $element->class;
                        $element->{'data-original'} = $element->src;
                        $element->src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC';
                    }
                }
            }

            if ($_hagIframes) {
                foreach ($simpleHtmlDom->find('iframe') as $element) {
                    if (strpos($element->class, "lazyload") === false && strpos($element->class, "easylazy") === false && strpos($element->class, "owl-lazy") === false) {
                        $element->class = 'easylazy ' . $element->class;
                        $element->{'data-src'} = $element->src;
                        $element->src = null;
                    }
                }
            }

            $html = $simpleHtmlDom->save();
        }

        return $html;
    }
}
