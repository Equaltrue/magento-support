<?php
/**
 * Copyright © Equaltrue. All rights reserved.
 *
 * @category  Support
 * @package   Equaltrue_Support
 * @copyright Copyright (c) Equaltrue
 * @author    Suvankar Paul
 */

declare(strict_types=1);

namespace Equaltrue\Support\Helper\Logger;

use Equaltrue\Core\Helper\Logger\EqLogger;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class ContactLogger extends AbstractHelper
{
    private const FILE             = 'contact.log';
    private const FILE_SPAM        = 'spam.log';
    private const FILE_EXCEPTION   = 'contact-exception.log';
    private const FOLDER           = BP . '/var/log/contact'; // @phpstan-ignore-line

    /**
     * @param EqLogger $eqLogger
     * @param Context $context
     */
    public function __construct(
        private readonly EqLogger $eqLogger,
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * Logger Function
     *
     * @param mixed $message Message mixed data
     * @param string $type Error type
     * @return bool
     */
    public function write(
        mixed $message,
        string $type = "info"
    ): bool {
        $this->eqLogger->write($message, self::FOLDER, self::FILE, $type);
        return true;
    }

    /**
     * Logger Function
     *
     * @param mixed $message Message mixed data
     * @param string $type Error type
     * @return bool
     */
    public function writeSpam(
        mixed $message,
        string $type = "info"
    ): bool {
        $this->eqLogger->write($message, self::FOLDER, self::FILE_SPAM, $type);
        return true;
    }

    /**
     * Logger Write Exception
     *
     * @param mixed $exception
     * @param string $exceptionTitle
     * @return bool
     */
    public function writeException(
        mixed $exception,
        string $exceptionTitle = '',
    ): bool {
        $this->eqLogger->writeException($exception, $exceptionTitle, self::FOLDER, self::FILE_EXCEPTION);
        return true;
    }
}
