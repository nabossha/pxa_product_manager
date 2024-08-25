<?php

return [
    'ctrl' => [
        'title' => 'Attribute values',
        'label' => 'value',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'type' => 'attribute',
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'searchFields' => 'value,attribute,',
        'hideTable' => true,
        'rootLevel' => -1,
        'iconfile' => 'EXT:pxa_product_manager/Resources/Public/Icons/Svg/tag.svg',
        'security' => [
            'ignoreRootLevelRestriction' => true,
            'ignoreWebMountRestriction' => true,
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => 'attribute, value',
        ],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => ['type' => 'language'],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'group',
                'allowed' => 'tx_pxaproductmanager_domain_model_attributevalue',
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
        'value' => [
            'label' => 'Value',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
        ],
        'attribute' => [
            'label' => 'Attribute',
            'config' => [
                'type' => 'group',
                'allowed' => 'tx_pxaproductmanager_domain_model_attribute',
                'size' => 1,
                'maxitems' => 1,
            ],
        ],
        'product' => [
            'label' => 'product',
            'config' => [
                'type' => 'group',
                'allowed' => 'tx_pxaproductmanager_domain_model_product',
                'size' => 1,
                'maxitems' => 1,
                'minitems' => 0,
            ],
        ],
    ],
];
