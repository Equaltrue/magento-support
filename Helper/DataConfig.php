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

namespace Equaltrue\Support\Helper;

use Equaltrue\Core\Helper\SysConfig;
use Equaltrue\Support\Model\Config\StaticData;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class DataConfig extends AbstractHelper
{
    public function __construct(
        Context $context,
        private readonly SysConfig $sysConfig
    ) {
        parent::__construct($context);
    }

    public function isSupportModuleEnable(): bool
    {
        return (bool) $this->sysConfig->getConfig(StaticData::SUPPORT_ENABLE_PATH);
    }

    /**
     * Get Google Captcha Setting
     * 
     * @return mixed
     */
    public function googleCaptchaSetting()
    {
        return $this->sysConfig->getConfig(StaticData::GOOGLE_CAPTCHA_SETTINGS_PATH);
    }
}
