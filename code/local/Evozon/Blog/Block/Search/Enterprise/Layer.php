<?php

/**
 * Overriding Enterprise_Search_Block_Catalogsearch_Layer in order to add a new block to filter the 
 * search results by products or posts for the enterprise versions
 *
 * @package     Evozon_Blog
 * @author      Dana Negrescu <dana.negrescu@evozon.com>
 * @copyright   Copyright (c) 2016, Evozon
 * @link        http://www.evozon.com Evozon
 */
class Evozon_Blog_Block_Search_Enterprise_Layer extends Enterprise_Search_Block_Catalogsearch_Layer
{

    /**
     * @var string search filtering block name
     */
    protected $_searchBlockName;

    /**
     * @var string search type (as in products or posts) 
     */
    protected $_searchType;

    /**
     * Internal constructor
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setIsEnabled(Mage::getSingleton('evozon_blog/search')->getConfig()->getSearchStatus());
    }

    /**
     * Initialize blocks names
     */
    protected function _initBlocks()
    {
        parent::_initBlocks();
        $this->_searchBlockName = 'evozon_blog/search_layer_navigation';
    }

    /**
     * Prepare child blocks
     *
     * @return Mage_Catalog_Block_Layer_View
     */
    protected function _prepareLayout()
    {
        $layerSearch = $this->getLayout()->createBlock($this->_searchBlockName)
            ->setLayer($this->getLayer())
            ->setSearchType('products');

        $this->setChild('layer_searchin', $layerSearch);

        return parent::_prepareLayout();
    }

    /**
     * Get layered navigation for filtering search results by products/posts
     *
     * @return string
     */
    public function getSearchInHtml()
    {
        return $this->getChildHtml('layer_searchin');
    }

    /**
     * Get layer object
     *
     * @return Mage_Catalog_Model_Layer
     */
    public function getLayer()
    {
        if ($this->getIsEnabled()) {
            return Mage::getSingleton('evozon_blog/search_layer');
        }

        return parent::getLayer();
    }

    public function setSearchType($type)
    {
        $this->_searchType = $type;
        return $this;
    }

    public function getSearchType()
    {
        return $this->_searchType;
    }

}
