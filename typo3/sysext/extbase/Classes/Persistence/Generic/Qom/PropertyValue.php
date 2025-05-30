<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace TYPO3\CMS\Extbase\Persistence\Generic\Qom;

/**
 * Evaluates to the value (or values, if multi-valued) of a property.
 *
 * If, for a node-tuple, the selector node does not have a property named property,
 * the operand evaluates to null.
 *
 * The query is invalid if:
 *
 * selector is not the name of a selector in the query, or
 * property is not a syntactically valid JCR name.
 *
 * @internal only to be used within Extbase, not part of TYPO3 Core API.
 */
final readonly class PropertyValue implements PropertyValueInterface
{
    public function __construct(protected string $propertyName, protected string $selectorName = '') {}

    public function getSelectorName(): string
    {
        return $this->selectorName;
    }

    public function getPropertyName(): string
    {
        return $this->propertyName;
    }
}
