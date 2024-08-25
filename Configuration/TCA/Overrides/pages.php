<?php

use Pixelant\PxaProductManager\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\ArrayUtility;
defined('TYPO3') || die;

(function (): void {
    $pdDokType = PageRepository::DOKTYPE_PRODUCT_DISPLAY;
    // Add new page type as possible select item:
    ExtensionManagementUtility::addTcaSelectItem(
        'pages',
        'doktype',
        [
            'LLL:EXT:pxa_product_manager/Resources/Private/Language/locallang_be.xlf:be.product_display_page_type',
            $pdDokType,
            'EXT:pxa_product_manager/Resources/Public/Icons/Svg/product.svg',
        ],
        '1',
        'after'
    );

    ArrayUtility::mergeRecursiveWithOverrule(
        $GLOBALS['TCA']['pages'],
        [
            // add icon for new page type:
            'ctrl' => [
                'typeicon_classes' => [
                    $pdDokType => 'apps-pagetree-productdisplay-default',
                    $pdDokType . '-hideinmenu' => 'apps-pagetree-productdisplay-hideinmenu',
                ],
            ],
            // add all page standard fields and tabs to your new page type
            'types' => [
                (string)$pdDokType => [
                    'showitem' => $GLOBALS['TCA']['pages']['types'][\TYPO3\CMS\Core\Domain\Repository\PageRepository::DOKTYPE_DEFAULT]['showitem'],
                ],
            ],
        ]
    );

    // BE layouts
    ExtensionManagementUtility::registerPageTSConfigFile(
        'pxa_product_manager',
        'Configuration/TSconfig/Page/Mod/WebLayout/BackendLayouts.tsconfig',
        'Product Manager BE layouts'
    );
})();
