<?php

namespace App\Http\Controllers\Servant;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Servant\AppController;
use Illuminate\Http\Request;
use App\Models\Edict;
use App\Models\Inscription;
use App\Models\Unit;
use App\Models\RemovalType;

class InscriptionsController extends AppController
{
     /** @var \App\Models\Edict */
    protected $edict;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->redirectToDashboardIfExpired();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     * @return  \Illuminate\View\View | \Illuminate\Http\RedirectResponse.
     */
    public function new()
    {
        $servant = \Auth::guard('servant')->user();
        $inscription = new Inscription();
        $inscription->current_unit_id = $servant->currentUnit()->id;

        return view('servant.edicts.inscription.new', [
            'edict' => $this->edict,
            'servant' => $servant,
            'contracts' => $servant->contracts,
            'units' => Unit::orderBy('name', 'ASC')->get(),
            'removal_types' => RemovalType::all(),
            'inscription' => $inscription
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return  \Illuminate\View\View | \Illuminate\Http\RedirectResponse.
       */
    public function create(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'contract_id'        => 'required',
            'removal_type_id'    => 'required',
            'interested_unit_id' => 'required',
            'reason'             => 'required',
        ]);

        $servant = \Auth::guard('servant')->user();
        $inscription = new Inscription($data);
        $inscription->servant_id = $servant->id;
        $inscription->current_unit_id = $servant->currentUnit()->id;

        if ($validator->fails()) {
            $request->session()->flash('danger', 'Existem dados incorretos! Por favor verifique!');
            return view('servant.edicts.inscription.new', [
                'edict' => $this->edict,
                'servant' => $servant,
                'contracts' => $servant->contracts,
                'units' => Unit::orderBy('name', 'ASC')->get(),
                'removal_types' => RemovalType::all(),
                'inscription' => $inscription
            ])->withErrors($validator);
        }

        $this->edict->inscriptions()->save($inscription);

        return redirect()->route('servant.dashboard')->with('success', 'Inscrição realizada com sucesso!');
    }

    private function redirectToDashboardIfExpired(): void
    {
        $this->middleware(function ($request, $next) {
            $this->edict = Edict::find($request->edict_id);

            if (now()->toShortDateTime() > $this->edict->ended_at->toShortDateTime()) {
                \Session::flash('danger', 'A data limite das inscrições foi atingida!');
                return redirect()->route('servant.dashboard');
            }
            return $next($request);
        });
    }
}
