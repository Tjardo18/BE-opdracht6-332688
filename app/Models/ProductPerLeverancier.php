<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPerLeverancier extends Model
{
    use HasFactory;

    protected $table = 'productperleverancier';

    protected $fillable = [
        'leverancierId',
        'productId',
        'datumLevering',
        'aantal',
        'datumEerstvolgendeLevering',
        'isActief',
        'opmerkingen',
        'created_at',
        'updated_at',
    ];

    // If you want to use timestamps (created_at and updated_at)
    public $timestamps = true; // default value is false


    public function getLeveringen($id)
    {
        return $this->select(
            'leverancier.id AS Lid',
            'product.naam AS PNaam',
            'magazijn.AantalAanwezig AS AantalAanwezig',
            'magazijn.VerpakkingsEenheid AS VerpakkingsEenheid',
            'productperleverancier.datumLevering AS DatumLevering',
        )
            ->join('leverancier', 'productperleverancier.LeverancierId', '=', 'leverancier.id')
            ->join('product', 'productperleverancier.productId', '=', 'product.id')
            ->join('magazijn', 'product.id', '=', 'magazijn.productId')
            ->where('leverancier.id', $id)
            ->orderBy('AantalAanwezig', 'DESC')
            ->get();
    }
}
