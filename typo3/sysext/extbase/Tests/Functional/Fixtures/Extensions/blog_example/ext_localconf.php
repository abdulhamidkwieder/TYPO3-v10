<?php

declare(strict_types=1);

defined('TYPO3') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'BlogExample',
    'Blogs',
    [
        \ExtbaseTeam\BlogExample\Controller\BlogController::class => 'list,testForm,testForward,testForwardTarget,testRelatedObject',
    ],
    []
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'BlogExample',
    'Content',
    [
        \ExtbaseTeam\BlogExample\Controller\ContentController::class => 'list',
    ],
    []
);
