<?php

use Pixelant\PxaProductManager\Domain\Model\Attribute;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Resource\File;
defined('TYPO3') || die;

return (function () {
    $ll = 'LLL:EXT:pxa_product_manager/Resources/Private/Language/locallang_db.xlf:';
    $llType = 'LLL:EXT:pxa_product_manager/Resources/Private/Language/locallang_db.xlf:tx_pxaproductmanager_domain_model_attribute.type_';

    return [
        'ctrl' => [
            'title' => $ll . 'tx_pxaproductmanager_domain_model_attribute',
            'label' => 'name',
            'tstamp' => 'tstamp',
            'crdate' => 'crdate',
            'sortby' => 'sorting',
            'origUid' => 't3_origuid',
            'languageField' => 'sys_language_uid',
            'transOrigPointerField' => 'l10n_parent',
            'transOrigDiffSourceField' => 'l10n_diffsource',
            'delete' => 'deleted',
            'enablecolumns' => [
                'disabled' => 'hidden',
                'starttime' => 'starttime',
                'endtime' => 'endtime',
            ],

            'type' => 'type',

            'searchFields' => 'name, label, label_checked, label_unchecked',
            'iconfile' => 'EXT:pxa_product_manager/Resources/Public/Icons/Svg/tag.svg',
        ],
        'types' => [
            '1' => ['showitem' => '--palette--;;core, --palette--;;common, --palette--;' . $ll . 'palette.options;options, identifier, default_value, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
            '4' => ['showitem' => '--palette--;;core, --palette--;;common, --palette--;' . $ll . 'palette.options;options, identifier, default_value, options, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
            '9' => ['showitem' => '--palette--;;core, --palette--;;common, --palette--;' . $ll . 'palette.options;options, identifier, default_value, options, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
            '5' => ['showitem' => '--palette--;;core, --palette--;;common, --palette--;' . $ll . 'palette.checkbox_values;checkbox_values, --palette--;' . $ll . 'palette.options;options, identifier, default_value, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
        ],

        'palettes' => [
            'core' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, --linebreak--, hidden'],
            'common' => ['showitem' => 'name, --linebreak--, label, --linebreak--, type'],
            'options' => ['showitem' => 'required, show_in_attribute_listing, --linebreak--, image'],
            'checkbox_values' => ['showitem' => 'label_checked, label_unchecked'],
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
                    'allowed' => 'tx_pxaproductmanager_domain_model_attribute',
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
            'starttime' => [
                'exclude' => true,
                'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
                'config' => [
                    'type' => 'datetime',
                    'default' => 0,
                    'behaviour' => [
                        'allowLanguageSynchronization' => true,
                    ],
                ],
            ],
            'endtime' => [
                'exclude' => true,
                'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
                'config' => [
                    'type' => 'datetime',
                    'default' => 0,
                    'range' => [
                        'upper' => mktime(0, 0, 0, 1, 1, 2038),
                    ],
                    'behaviour' => [
                        'allowLanguageSynchronization' => true,
                    ],
                ],
            ],
            'name' => [
                'exclude' => false,
                'label' => $ll . 'tx_pxaproductmanager_domain_model_attribute.name',
                'config' => [
                    'type' => 'input',
                    'size' => 30,
                    'eval' => 'trim',
                    'required' => true,
                ],
            ],
            'label' => [
                'exclude' => false,
                'label' => $ll . 'tx_pxaproductmanager_domain_model_attribute.label',
                'config' => [
                    'type' => 'input',
                    'size' => 30,
                    'eval' => 'trim',
                ],
            ],
            'type' => [
                'exclude' => false,
                'onChange' => 'reload',
                'label' => $ll . 'tx_pxaproductmanager_domain_model_attribute.type',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => [
                        [
                            'label' => $llType . Attribute::ATTRIBUTE_TYPE_INPUT,
                            'value' => Attribute::ATTRIBUTE_TYPE_INPUT,
                        ],
                        [
                            'label' => $llType . Attribute::ATTRIBUTE_TYPE_TEXT,
                            'value' => Attribute::ATTRIBUTE_TYPE_TEXT,
                        ],
                        [
                            'label' => $llType . Attribute::ATTRIBUTE_TYPE_DATETIME,
                            'value' => Attribute::ATTRIBUTE_TYPE_DATETIME,
                        ],
                        [
                            'label' => $llType . Attribute::ATTRIBUTE_TYPE_DROPDOWN,
                            'value' => Attribute::ATTRIBUTE_TYPE_DROPDOWN,
                        ],
                        [
                            'label' => $llType . Attribute::ATTRIBUTE_TYPE_MULTISELECT,
                            'value' => Attribute::ATTRIBUTE_TYPE_MULTISELECT,
                        ],
                        [
                            'label' => $llType . Attribute::ATTRIBUTE_TYPE_CHECKBOX,
                            'value' => Attribute::ATTRIBUTE_TYPE_CHECKBOX,
                        ],
                        [
                            'label' => $llType . Attribute::ATTRIBUTE_TYPE_LINK,
                            'value' => Attribute::ATTRIBUTE_TYPE_LINK,
                        ],
                        [
                            'label' => $llType . Attribute::ATTRIBUTE_TYPE_IMAGE,
                            'value' => Attribute::ATTRIBUTE_TYPE_IMAGE,
                        ],
                        [
                            'label' => $llType . Attribute::ATTRIBUTE_TYPE_FILE,
                            'value' => Attribute::ATTRIBUTE_TYPE_FILE,
                        ],
                        [
                            'label' => $llType . Attribute::ATTRIBUTE_TYPE_LABEL,
                            'value' => Attribute::ATTRIBUTE_TYPE_LABEL,
                        ],
                    ],
                    'size' => 1,
                    'minitems' => 1,
                    'maxitems' => 1,
                    'disableNoMatchingValueElement' => true,
                    'behaviour' => [
                        'allowLanguageSynchronization' => true,
                    ],
                    'required' => true,
                ],
            ],
            'required' => [
                'exclude' => false,
                'label' => $ll . 'tx_pxaproductmanager_domain_model_attribute.required',
                'config' => [
                    'type' => 'check',
                    'renderType' => 'checkboxToggle',
                    'default' => 0,
                    'behaviour' => [
                        'allowLanguageSynchronization' => true,
                    ],
                ],
            ],
            'show_in_attribute_listing' => [
                'exclude' => false,
                'label' => $ll . 'tx_pxaproductmanager_domain_model_attribute.show_in_attribute_listing',
                'config' => [
                    'type' => 'check',
                    'renderType' => 'checkboxToggle',
                    'default' => 1,
                    'behaviour' => [
                        'allowLanguageSynchronization' => true,
                    ],
                ],
            ],
            'identifier' => [
                'exclude' => true,
                'label' => $ll . 'tx_pxaproductmanager_domain_model_attribute.identifier',
                'l10n_mode' => 'exclude',
                'l10n_display' => 'defaultAsReadonly',
                'config' => [
                    'type' => 'input',
                    'size' => 30,
                    'eval' => 'trim,alphanum,nospace,uniqueInPid',
                    'fieldControl' => [
                        'attributeIdentifierControl' => [
                            'renderType' => 'attributeIdentifierControl',
                        ],
                    ],
                    'behaviour' => [
                        'allowLanguageSynchronization' => true,
                    ],
                ],
            ],
            'default_value' => [
                'exclude' => true,
                'displayCond' => [
                    'AND' => [
                        'FIELD:type:!=:' . Attribute::ATTRIBUTE_TYPE_DROPDOWN,
                        'FIELD:type:!=:' . Attribute::ATTRIBUTE_TYPE_CHECKBOX,
                        'FIELD:type:!=:' . Attribute::ATTRIBUTE_TYPE_MULTISELECT,
                        'FIELD:type:!=:' . Attribute::ATTRIBUTE_TYPE_IMAGE,
                        'FIELD:type:!=:' . Attribute::ATTRIBUTE_TYPE_FILE,
                        'FIELD:type:!=:' . Attribute::ATTRIBUTE_TYPE_LINK,
                        'FIELD:type:!=:' . Attribute::ATTRIBUTE_TYPE_DATETIME,
                    ],
                ],
                'label' => $ll . 'tx_pxaproductmanager_domain_model_attribute.default_value',
                'config' => [
                    'type' => 'input',
                    'size' => 30,
                    'eval' => 'trim',
                ],
            ],
            'label_checked' => [
                'exclude' => true,
                'displayCond' => 'FIELD:type:=:' . Attribute::ATTRIBUTE_TYPE_CHECKBOX,
                'label' => $ll . 'tx_pxaproductmanager_domain_model_attribute.label_checked',
                'config' => [
                    'type' => 'input',
                    'size' => 15,
                    'eval' => 'trim',
                ],
            ],
            'label_unchecked' => [
                'exclude' => true,
                'displayCond' => 'FIELD:type:=:' . Attribute::ATTRIBUTE_TYPE_CHECKBOX,
                'label' => $ll . 'tx_pxaproductmanager_domain_model_attribute.label_unchecked',
                'config' => [
                    'type' => 'input',
                    'size' => 15,
                    'eval' => 'trim',
                ],
            ],
            'options' => [
                'exclude' => false,
                'label' => $ll . 'tx_pxaproductmanager_domain_model_attribute.options',
                'displayCond' => [
                    'OR' => [
                        'FIELD:type:=:' . Attribute::ATTRIBUTE_TYPE_DROPDOWN,
                        'FIELD:type:=:' . Attribute::ATTRIBUTE_TYPE_MULTISELECT,
                    ],
                ],
                'config' => [
                    'type' => 'inline',
                    'foreign_table' => 'tx_pxaproductmanager_domain_model_option',
                    'foreign_field' => 'attribute',
                    'foreign_sortby' => 'sorting',
                    'maxitems' => 9999,
                    'appearance' => [
                        'collapseAll' => true,
                        'levelLinksPosition' => 'bottom',
                        'showSynchronizationLink' => true,
                        'showPossibleLocalizationRecords' => true,
                        'showAllLocalizationLink' => true,
                        'useSortable' => true,
                    ],
                    'behaviour' => [
                        'allowLanguageSynchronization' => true,
                    ],
                ],
            ],
            'image' => [
                'exclude' => 1,
                'label' => $ll . 'tx_pxaproductmanager_domain_model_attribute.image',
                'config' => ExtensionManagementUtility::getFileFieldTCAConfig(
                    'image',
                    [
                        'appearance' => [
                            'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference',
                            'showPossibleLocalizationRecords' => false,
                            'showRemovedLocalizationRecords' => true,
                            'showAllLocalizationLink' => false,
                            'showSynchronizationLink' => false,
                        ],
                        'foreign_match_fields' => [
                            'fieldname' => 'image',
                            'tablenames' => 'tx_pxaproductmanager_domain_model_attribute',
                        ],
                        'maxitems' => 1,
                        // @codingStandardsIgnoreStart
                        'overrideChildTca' => [
                            'types' => [
                                '0' => [
                                    'showitem' => '
                            --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;pxaProductManagerPalette,
                            --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette',
                                ],
                                File::FILETYPE_IMAGE => [
                                    'showitem' => '
                            --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;pxaProductManagerPalette,
                            --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette',
                                ],
                            ],
                        ],
                        // @codingStandardsIgnoreEnd
                        'behaviour' => [
                            'allowLanguageSynchronization' => true,
                        ],
                    ],
                    'jpeg,jpg,svg'
                ),
            ],
        ],
    ];
})();
