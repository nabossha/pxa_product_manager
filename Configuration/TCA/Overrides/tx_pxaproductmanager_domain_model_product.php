<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use Pixelant\PxaProductManager\Utility\TcaUtility;
defined('TYPO3') || die;

(static function () {
    ExtensionManagementUtility::addTCAcolumns(
        'tx_pxaproductmanager_domain_model_product',
        [
           'categories' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_category.categories',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'category',
                'fieldConfiguration' => [
                    'foreign_table_where' => TcaUtility::getCategoriesTCAWhereClause()
                        . 'AND sys_category.sys_language_uid IN (-1, 0)',
                ],
            ]
        ]
    ]);
})();
