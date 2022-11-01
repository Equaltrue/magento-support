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

namespace Equaltrue\Support\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Language implements OptionSourceInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => 'en', 'label' => __('English')],
            ['value' => 'sv', 'label' => __('Swedish')]
        ];
    }
}
