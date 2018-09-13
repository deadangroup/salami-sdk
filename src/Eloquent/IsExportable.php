<?php
/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Support\Eloquent;

interface IsExportable
{
    /**
     * @return array
     */
    public function exportFields();
}