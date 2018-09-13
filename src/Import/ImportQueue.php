<?php
/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Support\Import;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Deadan\Support\Eloquent\ActivityAuditorTrait;
use Deadan\Support\Eloquent\UsesUuidTrait;

class ImportQueue extends Model
{
    use ActivityAuditorTrait;
    use UsesUuidTrait;
    use SoftDeletes;
    
    /**
     *
     */
    const STATUS_PENDING = "PENDING";
    
    /**
     *
     */
    const STATUS_PROCESSING = "PROCESSING";
    
    /**
     *
     */
    const STATUS_COMPLETED = "COMPLETED";
    
    /**
     *
     */
    const STATUS_CANCELLED = "CANCELLED";
    
    /**
     * @type string
     */
    protected $table = 'import_queue';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'original_file_path',
        'original_file_name',
        'total_entries',
        'successful',
        'failed',
        'failed_entries_path',
        'status',
        'created_by',
    ];
    
    protected $hidden = ['id', 'type', 'deleted_by', 'updated_by', 'created_by'];
    
    /**
     * @param Builder $builder
     * @param         $id
     *
     * @return $this
     */
    public function scopeByUser(Builder $builder, $id)
    {
        return $builder->where('created_by', $id);
    }
    
    /**
     * @param Builder $builder
     * @param         $type
     *
     * @return $this
     */
    public function scopeByType(Builder $builder, $type)
    {
        return $builder->where('type', $type);
    }
}