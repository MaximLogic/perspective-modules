<?php

namespace Perspective\UrlAndImgWidget\Block;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class WidgetBlock extends Template implements BlockInterface
{
    protected $productRepository;
    protected $storeManager;
    protected $_template = "widget.phtml";
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    )
    {
        $this->productRepository = $productRepository;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    public function getProductImageAndUrlBySku($sku): ?array
    {
        $store = $this->storeManager->getStore();
        try {
            $product = $this->productRepository->get($sku);
            $productImageUrl = $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'catalog/product' .$product->getImage();
            $productUrl = $product->getProductUrl();
            return [$productImageUrl, $productUrl];
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            return null;
        }
    }
}
