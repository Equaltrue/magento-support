<?php
/**
 * Equaltrue (shuvoenr@gmail.com)
 *
 * This source file is subject to the Equaltrue license
 *
 * @category  Core
 * @package   Equaltrue_Core
 * @copyright Copyright (c) Equaltrue (https://equaltrue.com)
 * @author    Suvankar Paul
 */
declare(strict_types=1);

namespace Equaltrue\Support\ViewModel\Contact;

use Equaltrue\Support\Helper\DataConfig;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class Setting implements ArgumentInterface
{
    /**
     * @param DataConfig $dataConfig
     */
    public function __construct(
        private readonly DataConfig $dataConfig
    ) {
    }

    /**
     * Get google Captcha Setting
     * */
    public function getGoogleCaptchaSetting(): array
    {
        $return = [
            'status'                  => false,
            'google_captcha_language' => 'en',
            'google_captcha_key'      => '',
        ];
        $supportModuleEnable = $this->dataConfig->isSupportModuleEnable();
        if (!$supportModuleEnable) {
            return $return;
        }

        $googleSetting = $this->dataConfig->googleCaptchaSetting();

        $enabled    = $googleSetting['enabled'] ?? false;
        $ccForm     = $googleSetting['captcha_contact_from'] ?? false;
        $gcLanguage = $googleSetting['google_captcha_language'] ?? 'en';
        $fcKey      = $googleSetting['google_captcha_key'] ?? '';

        if (!$enabled || !$ccForm || empty($fcKey)) {
            $return['status'] = false;
            return $return;
        }

        return [
            'status'                  => true,
            'google_captcha_language' => $gcLanguage,
            'google_captcha_key'      => $fcKey,
        ];
    }
}
