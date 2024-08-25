<?php

use Pixelant\PxaProductManager\Domain\Model\Filter;
use Pixelant\PxaProductManager\Domain\Model\Attribute;
defined('TYPO3') || die('Access denied.');

return (function () {
    $ll = 'LLL:EXT:pxa_product_manager/Resources/Private/Language/locallang_db.xlf:';

    return [
        'ctrl' => [
            'title' => $ll . 'tx_pxaproductmanager_domain_model_filter',
            'label' => 'name',
            'label_alt' => 'label',
            'tstamp' => 'tstamp',
            'crdate' => 'crdate',

            'languageField' => 'sys_language_uid',
            'transOrigPointerField' => 'l10n_parent',
            'transOrigDiffSourceField' => 'l10n_diffsource',
            'delete' => 'deleted',
            'enablecolumns' => [
                'disabled' => 'hidden',
            ],

            'type' => 'type',

            'searchFields' => 'name,category,attribute',
            'iconfile' => 'EXT:pxa_product_manager/Resources/Public/Icons/Svg/filter.svg',
        ],
        'types' => [
            '1' => ['showitem' => '--palette--;;core, --palette--;;common, --palette--;;categories,'],
            '2' => ['showitem' => '--palette--;;core, --palette--;;common, --palette--;;attributes,'],
            '3' => ['showitem' => '--palette--;;core, --palette--;;common, --palette--;;attributes,'],
        ],
        'palettes' => [
            'core' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, --linebreak--, hidden'],
            'common' => ['showitem' => 'type, --linebreak--, name, label, gui_type, gui_state'],
            'categories' => ['showitem' => 'conjunction, --linebreak--, category'],
            'attributes' => ['showitem' => 'conjunction, --linebreak--, attribute'],
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
                    'allowed' => 'tx_pxaproductmanager_domain_model_filter',
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

            'type' => [
                'exclude' => true,
                'onChange' => 'reload',
                'label' => $ll . 'tx_pxaproductmanager_domain_model_filter.type',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => [
                        ['label' => 'Categories', 'value' => Filter::TYPE_CATEGORIES],
                        ['label' => 'Attribute', 'value' => Filter::TYPE_ATTRIBUTES],
                        ['label' => 'Attribute min-max (if applicable, require only numeric attribute values)', 'value' => Filter::TYPE_ATTRIBUTES_MINMAX],
                    ],
                    'size' => 1,
                    'minitems' => 1,
                    'maxitems' => 1,
                ],
            ],

            'gui_type' => [
                'exclude' => true,
                'label' => $ll . 'tx_pxaproductmanager_domain_model_filter.gui_type',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => [
                        ['label' => $ll . 'tx_pxaproductmanager_domain_model_filter.gui_type.checkbox', 'value' => 'checkbox'],
                        ['label' => $ll . 'tx_pxaproductmanager_domain_model_filter.gui_type.option', 'value' => 'option'],
                        ['label' => $ll . 'tx_pxaproductmanager_domain_model_filter.gui_type.select', 'value' => 'select'],
                    ],
                    'size' => 1,
                    'minitems' => 1,
                    'maxitems' => 1,
                ],
            ],

            'gui_state' => [
                'exclude' => true,
                'label' => $ll . 'tx_pxaproductmanager_domain_model_filter.gui_state',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => [
                        ['label' => $ll . 'tx_pxaproductmanager_domain_model_filter.gui_state.collapsed', 'value' => 'collapsed'],
                        ['label' => $ll . 'tx_pxaproductmanager_domain_model_filter.gui_state.expanded', 'value' => 'expanded'],
                        ['label' => $ll . 'tx_pxaproductmanager_domain_model_filter.gui_state.plain', 'value' => 'plain'],
                    ],
                    'size' => 1,
                    'minitems' => 1,
                    'maxitems' => 1,
                    'eval' => '',
                ],
            ],
            'name' => [
                'exclude' => true,
                'label' => $ll . 'tx_pxaproductmanager_domain_model_filter.name',
                'config' => [
                    'type' => 'input',
                    'size' => 30,
                    'eval' => 'trim',
                    'required' => true,
                ],
            ],
            'label' => [
                'exclude' => false,
                'label' => $ll . 'tx_pxaproductmanager_domain_model_filter.label',
                'config' => [
                    'type' => 'input',
                    'size' => 30,
                    'eval' => 'trim',
                ],
            ],
            'category' => [
                'exclude' => true,
                'label' => $ll . 'tx_pxaproductmanager_domain_model_filter.category',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectTree',
                    'treeConfig' => [
                        'parentField' => 'parent',
                        'appearance' => [
                            'showHeader' => true,
                            'expandAll' => true,
                            'maxLevels' => 99,
                        ],
                    ],
                    'foreign_table' => 'sys_category',
                    'foreign_table_where' => ' AND (sys_category.sys_language_uid = 0 OR sys_category.l10n_parent = 0) ORDER BY sys_category.sorting',
                    'size' => 20,
                    'minitems' => 1,
                    'maxitems' => 1,
                    'default' => 0,
                ],
            ],
            'attribute' => [
                'exclude' => true,
                'label' => $ll . 'tx_pxaproductmanager_domain_model_filter.attribute',
                'config' => [
                    'type' => 'select',
                    'disableNoMatchingValueElement' => true,
                    'renderType' => 'selectSingle',
                    'foreign_table' => 'tx_pxaproductmanager_domain_model_attribute',
                    'foreign_table_where' => ' AND tx_pxaproductmanager_domain_model_attribute.type IN ('
                        . Attribute::ATTRIBUTE_TYPE_DROPDOWN . ','
                        . Attribute::ATTRIBUTE_TYPE_MULTISELECT . ')' .
                        ' AND (tx_pxaproductmanager_domain_model_attribute.sys_language_uid = 0 OR tx_pxaproductmanager_domain_model_attribute.l10n_parent = 0) ORDER BY tx_pxaproductmanager_domain_model_attribute.sorting',
                    'minitems' => 1,
                    'maxitems' => 1,
                    'default' => 0,
                ],
            ],
            'conjunction' => [
                // hide for range filter
                'displayCond' => 'FIELD:type:!=:3',
                'exclude' => true,
                'label' => $ll . 'tx_pxaproductmanager_domain_model_filter.conjunction',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'default' => 'and',
                    'items' => [
                        ['label' => 'And', 'value' => Filter::CONJUNCTION_AND],
                        ['label' => 'Or', 'value' => Filter::CONJUNCTION_OR],
                    ],
                ],
            ],
        ],
    ];
})();
