<?php

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use Pixelant\PxaProductManager\Controller\Api\LazyLoadingController;
use Pixelant\PxaProductManager\Controller\Api\LazyAvailableFiltersController;
use Pixelant\PxaProductManager\Controller\ProductShowController;
use Pixelant\PxaProductManager\Controller\LazyProductController;
use Pixelant\PxaProductManager\Controller\ProductRenderController;
use Pixelant\PxaProductManager\Controller\CustomProductController;
use Pixelant\PxaProductManager\Backend\FormEngine\FieldControl\AttributeIdentifierControl;
use Pixelant\PxaProductManager\Backend\FormEngine\FieldWizard\ParentValueFieldWizard;
use Pixelant\PxaProductManager\Backend\FormEngine\FieldWizard\HiddenAttributeTypeValueFieldWizard;
use Pixelant\PxaProductManager\Backend\FormEngine\FieldInformation\InheritedProductFieldInformation;
use Pixelant\PxaProductManager\Backend\FormDataProvider\ProductFormDataProvider;
use TYPO3\CMS\Backend\Form\FormDataProvider\DatabaseRowInitializeNew;
use TYPO3\CMS\Backend\Form\FormDataProvider\TcaSelectItems;
use Pixelant\PxaProductManager\Backend\FormDataProvider\AttributeValueFormDataProvider;
use Pixelant\PxaProductManager\Backend\FormDataProvider\NewAttributeRelationRecordsDataProvider;
use TYPO3\CMS\Backend\Form\FormDataProvider\EvaluateDisplayConditions;
use Pixelant\PxaProductManager\Configuration\Flexform\Registry;
use Pixelant\PxaProductManager\Hook\PageLayoutView;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use Pixelant\PxaProductManager\LinkHandler\LinkHandling;
use Pixelant\PxaProductManager\LinkHandler\LinkHandlingFormData;
use Pixelant\PxaProductManager\Service\LinkBuilders\TypolinkBuilderService;
use Pixelant\PxaProductManager\Hook\PageHookRelatedCategories;

use TYPO3\CMS\Core\Cache\Frontend\VariableFrontend;
use Pixelant\PxaProductManager\Domain\Repository\PageRepository;
defined('TYPO3') || die;

(function () {
    // Configure plugins
    ExtensionUtility::configurePlugin(
        'PxaProductManager',
        'LazyLoading',
        [
            LazyLoadingController::class => 'list',
        ],
        [
            LazyLoadingController::class => 'list',
        ]
    );

    ExtensionUtility::configurePlugin(
        'PxaProductManager',
        'LazyAvailableFilters',
        [
            LazyAvailableFiltersController::class => 'list',
        ],
        [
            LazyAvailableFiltersController::class => 'list',
        ]
    );

    ExtensionUtility::configurePlugin(
        'PxaProductManager',
        'ProductShow',
        [
            ProductShowController::class => 'show'
        ]
    );

    ExtensionUtility::configurePlugin(
        'PxaProductManager',
        'ProductList',
        [
            LazyProductController::class => 'list'
        ]
    );

    ExtensionUtility::configurePlugin(
        'PxaProductManager',
        'ProductRender',
        [
            ProductRenderController::class => 'init'
        ]
    );

    ExtensionUtility::configurePlugin(
        'PxaProductManager',
        'CustomProductList',
        [
            CustomProductController::class => 'list'
        ]
    );

    // Register field control for identifier attribute
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1534315213786] = [
        'nodeName' => 'attributeIdentifierControl',
        'priority' => 30,
        'class' => AttributeIdentifierControl::class
    ];

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1608645557] = [
        'nodeName' => 'productParentValue',
        'priority' => '30',
        'class' => ParentValueFieldWizard::class,
    ];

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1611778775] = [
        'nodeName' => 'hiddenAttributeType',
        'priority' => '30',
        'class' => HiddenAttributeTypeValueFieldWizard::class,
    ];

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1609921375] = [
        'nodeName' => 'inheritedProductField',
        'priority' => '30',
        'class' => InheritedProductFieldInformation::class,
    ];

    // Add attributes fields to Product edit form
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][ProductFormDataProvider::class] = [
        'depends' => [
            DatabaseRowInitializeNew::class,
            TcaSelectItems::class
        ]
    ];

    // Add attributes fields to Product edit form
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][AttributeValueFormDataProvider::class] = [
        'depends' => [
            DatabaseRowInitializeNew::class,
            TcaSelectItems::class
        ]
    ];

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][NewAttributeRelationRecordsDataProvider::class] = [
        'depends' => [
            EvaluateDisplayConditions::class
        ]
    ];

    // Modify data structure of flexform. Hook will dynamically load flexform parts for selected action
    // Register default plugin actions with flexform settings
    GeneralUtility::makeInstance(
        Registry::class
    )->registerDefaultActions();

    // Register hook to show plugin flexform settings preview
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['list_type_Info']['pxaproductmanager_pi1']['pxa_product_manager'] =
        PageLayoutView::class . '->getExtensionSummary';

    // Include page TS
    ExtensionManagementUtility::addPageTSConfig(
        '<INCLUDE_TYPOSCRIPT: source="DIR:EXT:pxa_product_manager/Configuration/TypoScript/PageTS/" extensions="ts">'
    );

    // LinkHandler
    // t3://pxappm?product=[product_id]
    // t3://pxappm?category=[category_id]
    $linkType = 'pxappm';
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['linkHandler'][$linkType]
        = \Pixelant\PxaProductManager\LinkHandler\LinkHandling::class;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['linkHandler'][$linkType]
        = \Pixelant\PxaProductManager\LinkHandler\LinkHandlingFormData::class;
    $GLOBALS['TYPO3_CONF_VARS']['FE']['typolinkBuilder'][$linkType]
        = TypolinkBuilderService::class;

    // Draw header hook
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/db_layout.php']['drawHeaderHook']['pxa_product_manager']
        = \Pixelant\PxaProductManager\Hook\PageHookRelatedCategories::class . '->render';

    // Register TCA post-processing
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['GLOBAL']['extTablesInclusion-PostProcessing']['pxa_product_manager'] =
        \Pixelant\PxaProductManager\TCA\AttributeValueTcaProvider::class . '->getAttributeValueTypes';

    // Allow backend users to drag and drop the new page type:
    $pdDokType = PageRepository::DOKTYPE_PRODUCT_DISPLAY;
    ExtensionManagementUtility::addUserTSConfig(
        'options.pageTree.doktypesToShowInNewPageDragArea := addToList(' . $pdDokType . ')'
    );

    // Add doktype to yoast_seo:s allowedDoktypes.
    if (ExtensionManagementUtility::isLoaded('yoast_seo')) {
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['yoast_seo']['allowedDoktypes']['product_display'] = $pdDokType;
    }

    // Cache framework
    $cacheIdentifier = 'pm_cache_categories';
    if (
        isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheIdentifier])
        && !is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheIdentifier])
    ) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheIdentifier] = [];
    }
    if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheIdentifier]['frontend'])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheIdentifier]['frontend']
            = \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend::class;
    }
    if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheIdentifier]['options'])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheIdentifier]['options']
            = ['defaultLifetime' => 0];
    }
    if (! isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheIdentifier]['groups'])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheIdentifier]['groups']
            = ['pages', 'system'];
    }
})();
