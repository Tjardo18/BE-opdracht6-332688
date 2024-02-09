<?php

namespace App\Http\Controllers;

use App\Models\Leverancier;
use App\Models\ProductPerLeverancier;
use Illuminate\Http\Request;

class LeveringController extends Controller
{
    private $leverancierModel;
    private $productPerLeverancierModel;

    public function __construct(Leverancier $leverancierModel, ProductPerLeverancier $productPerLeverancierModel)
    {
        $this->leverancierModel = $leverancierModel;
        $this->productPerLeverancierModel = $productPerLeverancierModel;
    }

    public function index($id)
    {
        $result = $this->productPerLeverancierModel->getLeveringen($id);
        $leverancier = $this->leverancierModel->getLeverancierById($id);

        if ($result->isEmpty()) {
            $th = '';
            $rows = "<h1 style='text-align: center'>Dit bedrijf heeft tot nu toe geen producten geleverd aan Jamin</h1>";
            header("Refresh: 4; url=/leverancier-overzicht");
        } else {
            $th = "<th>Naam product</th>
        <th>Aantal in magazijn</th>
        <th>Verpakkingseenheid</th>
        <th>Laatste levering</th>
        <th>Nieuwe levering</th>";

            $rows = '';
            foreach ($result as $levering) {
                $rows .= "<tr>
                            <td>$levering->PNaam</td>
                            <td>$levering->AantalAanwezig</td>
                            <td>$levering->VerpakkingsEenheid</td>
                            <td>$levering->DatumLevering</td>
                            <td>
                                <a href='/#/$levering->Lid'>
                                    <i class='bx bx-plus-circle' style='color: #e422b0'></i>
                                </a>
                            </td>
                        </tr>";
            }
        }

        $data = [
            'title' => 'Geleverde Producten',
            'naamLeverancier' => $leverancier[0]->Naam,
            'contactPersoon' => $leverancier[0]->ContactPersoon,
            'leverancierNummer' => $leverancier[0]->LeverancierNummer,
            'mobiel' => $leverancier[0]->Mobiel,
            'rows' => $rows,
            'th' => $th,
        ];

        return view('leveringen', $data);
    }
}
