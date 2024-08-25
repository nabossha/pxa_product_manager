<?php

declare(strict_types=1);

namespace Pixelant\PxaProductManager\FlashMessage;

use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class BackendFlashMessage
{
    /**
     * Add flash message to queue.
     *
     * @param string $message
     * @param string $title
     * @param int $level
     * @throws Exception
     */
    public function flash(string $message, string $title, int $level = AbstractMessage::INFO): void
    {
        /** @var FlashMessage $flashMessage */
        $flashMessage = GeneralUtility::makeInstance(
            FlashMessage::class,
            $message,
            $title,
            $level,
            true
        );

        $flashMessageQueue = GeneralUtility::makeInstance(FlashMessageService::class)->getMessageQueueByIdentifier(
            'core.template.flashMessages'
        );
        $flashMessageQueue->enqueue($flashMessage);
    }
}
