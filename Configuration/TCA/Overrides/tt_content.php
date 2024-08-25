<?php

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
defined('TYPO3') || die;

(function (): void {
    ExtensionUtility::registerPlugin(
        'pxa_product_manager',
        'ProductList',
        'Product List',
        'EXT:pxa_product_manager/Resources/Public/Icons/Svg/Extension.svg',
        'Product Manager'
    );

    $pluginSignature = 'pxaproductmanager_productlist';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
    ExtensionManagementUtility::addPiFlexFormValue(
        $pluginSignature,
        'FILE:EXT:pxa_product_manager/Configuration/FlexForms/flexform_product_list.xml'
    );

    ExtensionUtility::registerPlugin(
        'pxa_product_manager',
        'ProductShow',
        'Product Show',
        'EXT:pxa_product_manager/Resources/Public/Icons/Svg/Extension.svg',
        'Product Manager'
    );

    $pluginSignature = 'pxaproductmanager_productshow';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
    ExtensionManagementUtility::addPiFlexFormValue(
        $pluginSignature,
        'FILE:EXT:pxa_product_manager/Configuration/FlexForms/flexform_product_show.xml'
    );

    ExtensionUtility::registerPlugin(
        'pxa_product_manager',
        'ProductRender',
        'Product Render',
        'EXT:pxa_product_manager/Resources/Public/Icons/Svg/Extension.svg',
        'Product Manager'
    );

    $pluginSignature = 'pxaproductmanager_productrender';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';

    ExtensionManagementUtility::addPiFlexFormValue(
        $pluginSignature,
        'FILE:EXT:pxa_product_manager/Configuration/FlexForms/flexform_product_render.xml'
    );

    ExtensionUtility::registerPlugin(
        'pxa_product_manager',
        'CustomProductList',
        'Custom Product List',
        'EXT:pxa_product_manager/Resources/Public/Icons/Svg/Extension.svg',
        'Product Manager'
    );

    $pluginSignature = 'pxaproductmanager_customproductlist';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';

    ExtensionManagementUtility::addPiFlexFormValue(
        $pluginSignature,
        'FILE:EXT:pxa_product_manager/Configuration/FlexForms/flexform_product_custom_list.xml'
    );
})();
