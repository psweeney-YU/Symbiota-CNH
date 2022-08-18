<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortalOccurrence extends Model{

	protected $table = 'portaloccurrences';
	protected $primaryKey = 'portalOccurrencesID';
	public $timestamps = false;

	protected $fillable = [ 'occid', 'portalID', 'pubid', 'targetOccid', 'verification', 'refreshtimestamp' ];

	public function portalIndex() {
		return $this->belongsTo(PortalIndex::class, 'portalID', 'portalID');
	}

	public function occurrence() {
		return $this->belongsTo(Occurrence::class, 'occid', 'occid');
	}
}