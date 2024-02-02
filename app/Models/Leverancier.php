<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Leverancier extends Model
{
    use HasFactory;

    protected $table = 'leverancier';

    protected $fillable = [
        'naam',
        'contactPersoon',
        'leverancierNummer',
        'mobiel',
        'isActief',
        'opmerkingen',
        'created_at',
        'updated_at',
    ];

    // If you want to use timestamps (created_at and updated_at)
    public $timestamps = true; // default value is false


    public function getLeverancier($id)
    {
        return $this->select(
            'leverancier.naam AS LNaam',
            'leverancier.contactPersoon',
            'leverancier.leverancierNummer',
            'leverancier.mobiel',
            'product.naam AS PNaam',
            DB::raw('IFNULL(magazijn.aantalAanwezig, 0) AS AantalAanwezig'),
            'productperleverancier.datumLevering',
            'productperleverancier.aantal',
            'productperleverancier.datumEerstVolgendeLevering AS DatumEVL'
        )
            ->join('productperleverancier', 'leverancier.id', '=', 'productperleverancier.leverancierId')
            ->join('product', 'productperleverancier.productId', '=', 'product.id')
            ->leftJoin('magazijn', 'product.id', '=', 'magazijn.productId')
            ->where('product.id', $id)
            ->orderBy('productperleverancier.datumLevering', 'ASC')
            ->get();
    }
}
