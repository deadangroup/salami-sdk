<?php
/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <ngugiwjames@gmail.com>
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Support\Eloquent;

use Yajra\Auditable\AuditableTrait;

trait ActivityAuditorTrait
{
    use AuditableTrait;
    use DeleteAuditTrait;
    use DeviceAuditTrait;
}