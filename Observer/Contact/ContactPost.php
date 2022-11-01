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

namespace Equaltrue\Support\Observer\Contact;

use Equaltrue\Core\Helper\SysConfig;
use Equaltrue\Support\Helper\Logger\ContactLogger;
use Equaltrue\Support\Model\Config\StaticData;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Magento\Customer\Model\Session;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ContactPost implements ObserverInterface
{
    /**
     * Constructor
     *
     * @param ContactLogger $contactLogger
     * @param SysConfig $sysConfig
     * @param Session $session
     * @param RequestInterface $request
     */
    public function __construct(
        private readonly ContactLogger $contactLogger,
        private readonly SysConfig $sysConfig,
        private readonly Session $session,
        private readonly RequestInterface $request,
    ) {
    }

    /**
     * Execute Function
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $message = " ----- Contact / Support Requested -----\n";
        try {
            $requestData = $this->request->getParams();
            $customerToken = $this->session->getCustomerContactToken();
            $message .= "--- Request Value ---";
            $this->contactLogger->write($message);
            $this->contactLogger->write($requestData);

            //-- Block of code for invalid request
            if ($customerToken !== "Available") {
                $message .= "Spam Request / Bot Request. \n";
                $this->session->setCustomerContactToken("");
                $this->contactLogger->write($message, 'alert');
                $this->contactLogger->write($requestData);
                if (!array_key_exists("g-recaptcha-response", $requestData)) {
                    $this->contactLogger->writeSpam("Spammer Manipulate but we are more smart .. :)))", 'alert');
                    $this->exitMessage();
                }
            }

            $customerEmail = ($requestData['email']) ?? '';
            if (!$customerEmail) {
                $errorMessage = "Sorry! no customer address given";
                $this->contactLogger->write($errorMessage, 'error');
                $this->exitMessage($errorMessage);
            }

            //-- Filter the Request
            $filterSetting = $this->sysConfig->getConfig(StaticData::FILTER_SETTINGS_PATH);
            if (!is_array($filterSetting)) {
                return;
            }

            $enabled = ($filterSetting['enabled']) ?? false;
            if (!$enabled) {
                return;
            }

            $domains = ($filterSetting['domains']) ?? "";
            $emails = ($filterSetting['emails']) ?? "";

            if (!empty($emails)) {
                $emailList = array_map('trim', explode(',', $emails));
                if (in_array($customerEmail, $emailList)) {
                    $errorMessage = "Out Bot Consider it's as Spam Email...";
                    $this->contactLogger->writeSpam($errorMessage, 'error');
                    $this->exitMessage($errorMessage);
                }
            }

            if (!empty($domains)) {
                $domain = substr(strstr($customerEmail, '@'), 1);
                $domainList = array_map('trim', explode(',', $domains));
                if (in_array($domain, $domainList)) {
                    $errorMessage = "Out Bot Consider it's as Spam Domain...";
                    $this->contactLogger->writeSpam($errorMessage, 'error');
                    $this->exitMessage($errorMessage);
                }
            }
        } catch (Exception $exception) {
            $this->contactLogger->writeException($exception);
        }
    }

    /**
     * Exit Message
     *
     * @param string $message
     */
    #[NoReturn] protected function exitMessage(string $message = "🙂")
    {
        echo "<p style='font-size: 56px;margin-top: 100px;text-align: center;'>$message</p>";
        exit();
    }
}
