<?php

namespace App\Http\Controllers;

use App\Models\Leverancier;
use App\Models\ProductPerLeverancier;
use Illuminate\Http\Request;

class NieuweLeveringController extends Controller
{
    private $leverancierModel;

    public function __construct(Leverancier $leverancierModel)
    {
        $this->leverancierModel = $leverancierModel;
    }

    public function index($id)
    {
        // Dit is fout, je moet de leverancier ophalen op basis van de id die je meekrijgt
        $leverancier = $this->leverancierModel->getLeverancierById(1);

        $data = [
            'title' => 'Nieuwe Levering',
            'leverancierId' => $leverancier[0]->id,
            'naamLeverancier' => $leverancier[0]->Naam,
            'contactPersoon' => $leverancier[0]->ContactPersoon,
            'leverancierNummer' => $leverancier[0]->leverancierNummer,
            'mobiel' => $leverancier[0]->mobiel,
        ];

        return view('nieuwe-levering', $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'aantal' => 'required',
            'datumEerstvolgendeLevering' => 'required',
        ]);

        $newLevering = ProductPerLeverancier::create($data);

        return redirect(route('leveringen/{$id}'));
    }
}
