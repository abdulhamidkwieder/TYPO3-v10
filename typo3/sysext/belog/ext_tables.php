<?php

declare(strict_types=1);

defined('TYPO3') or die();

// Module Web->Info->Log
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::insertModuleFunction(
    'web_info',
    \TYPO3\CMS\Belog\Module\BackendLogModuleBootstrap::class,
    '',
    'Log'
);

// Module Tools->Log
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
    'Belog',
    'system',
    'log',
    '',
    [
        \TYPO3\CMS\Belog\Controller\BackendLogController::class => 'list,deleteMessage',
    ],
    [
        'access' => 'admin',
        'icon' => 'EXT:belog/Resources/Public/Icons/module-belog.svg',
        'labels' => 'LLL:EXT:belog/Resources/Private/Language/locallang_mod.xlf',
    ]
);
