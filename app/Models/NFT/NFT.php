<?php

namespace App\Models\NFT;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class NFT extends Model
{
    use SoftDeletes;

    protected $table = 'nfts';

    protected $fillable = [
        'name',
        'description',
        'image_url',
        'permalink',
        'asset_contract',
        'collection_id',
        'owner_id',
        'contract_date',
    ];

    //Get Owner
    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    //Get Collection
    public function collection()
    {
        return $this->belongsTo(NFTCollection::class);
    }
}

