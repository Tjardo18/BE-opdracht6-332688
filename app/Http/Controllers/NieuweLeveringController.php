<?php

namespace App\Http\Controllers;

use App\Models\Leverancier;
use App\Models\Magazijn;
use App\Models\ProductPerLeverancier;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NieuweLeveringController extends Controller
{
    private $leverancierModel;

    public function __construct(Leverancier $leverancierModel)
    {
        $this->leverancierModel = $leverancierModel;
    }

    public function index($id)
    {
        $leverancierId = $this->leverancierModel->getLeverancierByProductId($id);
        $leverancier = $this->leverancierModel->getLeverancierById($leverancierId[0]->leverancierId);

        $data = [
            'title' => 'Nieuwe Levering',
            'leverancierId' => $leverancierId[0]->leverancierId,
            'naamLeverancier' => $leverancier[0]->Naam,
            'contactPersoon' => $leverancier[0]->ContactPersoon,
            'leverancierNummer' => $leverancier[0]->leverancierNummer,
            'productId' => $id,
            'mobiel' => $leverancier[0]->mobiel,
        ];

        return view('nieuwe-levering', $data);
    }

    public function store()
    {
        ProductPerLeverancier::create([
            'leverancierId' => request('leverancierId'),
            'productId' => request('productId'),
            'datumLevering' => request('datumLevering'),
            'aantal' => request('aantal'),
            'datumEerstvolgendeLevering' => request('datumEerstvolgendeLevering'),
            'isActief' => 1,
            'opmerkingen' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Haal het huidige aantal aanwezig in het magazijn op
        $currentAantal = Magazijn::where('productId', request('productId'))
            ->value('aantalAanwezig');

        // Bereken het nieuwe aantal door het huidige aantal op te tellen bij het aantal uit de request
        $newAantal = $currentAantal + request('aantal');

        // Voer de update uit
        Magazijn::where('productId', request('productId'))
            ->update([
                'aantalAanwezig' => $newAantal,
                'updated_at' => Carbon::now(),
            ]);

        $LId = request('leverancierId');

        return redirect(route('leveringen.index', $LId));
    }
}
