<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
defined('TYPO3') || die;

(function (): void {
    $ll = 'LLL:EXT:pxa_product_manager/Resources/Private/Language/locallang_db.xlf:';

    $columns = [
        'pxapm_type' => [
            'exclude' => false,
            'label' => $ll . 'sys_file_reference.pxapm_type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => $ll . 'sys_file_reference.pxapm_type.0', 'value' => 0],
                    ['label' => $ll . 'sys_file_reference.pxapm_type.1', 'value' => 1],
                    ['label' => $ll . 'sys_file_reference.pxapm_type.2', 'value' => 2],
                ],
            ],
        ],
    ];
//
//    $columnsForAttribute = [
//        'pxa_attribute' => [
//            'label' => $ll . 'sys_file_reference.pxa_attribute',
//            'config' => [
//                'type' => 'select',
//                'renderType' => 'selectSingle',
//                'foreign_table' => 'tx_pxaproductmanager_domain_model_attribute',
//                'items' => [
//                    ['', 0],
//                ],
//                'default' => 0,
//            ],
//        ],
//    ];
//
    ExtensionManagementUtility::addTCAcolumns(
        'sys_file_reference',
        $columns
    );
//
//    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
//        'sys_file_reference',
//        $columnsForAttribute
//    );
//
    ExtensionManagementUtility::addFieldsToPalette(
        'sys_file_reference',
        'pxaProductManagerPalette',
        'pxapm_type'
    );
//
//    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
//        'sys_file_reference',
//        'pxaProductManagerAttributePalette',
//        'pxa_attribute'
//    );
})();
