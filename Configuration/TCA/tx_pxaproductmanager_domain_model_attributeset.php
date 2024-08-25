<?php

defined('TYPO3') || die('Access denied.');

return (function () {
    $ll = 'LLL:EXT:pxa_product_manager/Resources/Private/Language/locallang_db.xlf:tx_pxaproductmanager_domain_model_attributeset';

    return [
        'ctrl' => [
            'title' => $ll,
            'label' => 'name',
            'tstamp' => 'tstamp',
            'crdate' => 'crdate',
            'sortby' => 'sorting',
            'origUid' => 't3_origuid',
            'transOrigPointerField' => 'l10n_parent',
            'transOrigDiffSourceField' => 'l10n_diffsource',
            'languageField' => 'sys_language_uid',
            'translationSource' => 'l10n_source',
            'delete' => 'deleted',
            'enablecolumns' => [
                'disabled' => 'hidden',
            ],
            'searchFields' => 'name,attributes,',
            'iconfile' => 'EXT:pxa_product_manager/Resources/Public/Icons/Svg/layers.svg',
        ],
        'types' => [
            '1' => [
                'showitem' => '
                    name, label, layout, attributes, product_types,
                    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, --palette--;;lang,
                    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, hidden',
            ],
        ],
        'palettes' => [
            'lang' => [
                'showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource',
            ],
            '1' => [
                'showitem' => '',
            ],
        ],
        'columns' => [
            'sys_language_uid' => [
                'exclude' => true,
                'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
                'config' => ['type' => 'language'],
            ],
            'l10n_parent' => [
                'displayCond' => 'FIELD:sys_language_uid:>:0',
                'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
                'config' => [
                    'type' => 'group',
                    'allowed' => 'tx_pxaproductmanager_domain_model_attributeset',
                    'size' => 1,
                    'maxitems' => 1,
                    'minitems' => 0,
                    'default' => 0,
                ],
            ],
            'l10n_diffsource' => [
                'config' => [
                    'type' => 'passthrough',
                ],
            ],
            'hidden' => [
                'exclude' => true,
                'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
                'config' => [
                    'type' => 'check',
                    'renderType' => 'checkboxToggle',
                    'items' => [
                        [
                            'label' => '',
                            'invertStateDisplay' => true,
                        ],
                    ],
                ],
            ],
            'name' => [
                'label' => $ll . '.name',
                'config' => [
                    'type' => 'input',
                    'size' => 30,
                    'eval' => 'trim',
                    'required' => true,
                ],
            ],
            'label' => [
                'exclude' => false,
                'label' => $ll . '.label',
                'config' => [
                    'type' => 'input',
                    'size' => 30,
                    'eval' => 'trim',
                ],
            ],
            'attributes' => [
                'label' => $ll . '.attributes',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectMultipleSideBySide',
                    'foreign_table' => 'tx_pxaproductmanager_domain_model_attribute',
                    'foreign_table_where' => 'AND tx_pxaproductmanager_domain_model_attribute.pid = ###CURRENT_PID###' .
                        ' AND tx_pxaproductmanager_domain_model_attribute.sys_language_uid <= 0',
                    'MM' => 'tx_pxaproductmanager_attributeset_record_mm',
                    'MM_match_fields' => [
                        'tablenames' => 'tx_pxaproductmanager_domain_model_attribute',
                        'fieldname' => 'attributes',
                    ],
                    'multiple' => 0,
                    'MM_hasUidField' => true,
                    'size' => 10,
                    'autoSizeMax' => 30,
                    'maxitems' => 9999,
                    'fieldControl' => [
                        'editPopup' => [
                            'disabled' => false,
                        ],
                        'addRecord' => [
                            'disabled' => false,
                        ],
                    ],
                    'behaviour' => [
                        'allowLanguageSynchronization' => true,
                    ],
                ],
            ],
            'layout' => [
                'exclude' => true,
                'label' => $ll . '.layout',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => [
                        ['label' => $ll . '.layout.default', 'value' => 'Default'],
                    ],
                    'default' => 'Default',
                    'behaviour' => [
                        'allowLanguageSynchronization' => true,
                    ],
                ],
            ],
            'product_types' => [
                'label' => $ll . '.product_types',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectMultipleSideBySide',
                    'foreign_table' => 'tx_pxaproductmanager_domain_model_producttype',
                    'MM' => 'tx_pxaproductmanager_attributeset_record_mm',
                    'MM_match_fields' => [
                        'tablenames' => 'tx_pxaproductmanager_domain_model_producttype',
                        'fieldname' => 'product_type',
                    ],
                    'multiple' => 0,
                    'MM_hasUidField' => true,
                    'size' => 10,
                    'autoSizeMax' => 30,
                    'maxitems' => 9999,
                    'fieldControl' => [
                        'editPopup' => [
                            'disabled' => false,
                        ],
                        'addRecord' => [
                            'disabled' => false,
                        ],
                    ],
                    'behaviour' => [
                        'allowLanguageSynchronization' => true,
                    ],
                ],
            ],
        ],
    ];
})();
