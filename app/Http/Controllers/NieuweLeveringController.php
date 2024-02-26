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
        $leverancierId = $this->leverancierModel->getLeverancierByProductId($id);
        $leverancier = $this->leverancierModel->getLeverancierById($leverancierId[0]->leverancierId);

        $data = [
            'title' => 'Nieuwe Levering',
            'leverancierId' => $leverancier[0]->id,
            'naamLeverancier' => $leverancier[0]->Naam,
            'contactPersoon' => $leverancier[0]->ContactPersoon,
            'leverancierNummer' => $leverancier[0]->leverancierNummer,
            'productId' => $id,
            'mobiel' => $leverancier[0]->mobiel,
        ];

        return view('nieuwe-levering', $data);
    }

    public function store(Request $request)
    {
        $formData = $request->validate([
            'id' => null,
            'leverancierId' => 'required',
            'productId' => 'required',
            'datumLevering' => 'required',
            'aantal' => 'required',
            'datumEerstvolgendeLevering' => 'required',
            'isActief' => 1,
            'opmerkingen' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $newLevering = ProductPerLeverancier::create($formData);

        return redirect(route('leveringen/{$id}'));
    }
}
