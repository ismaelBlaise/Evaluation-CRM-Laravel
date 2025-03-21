<?php

namespace App\Http\Controllers;
use App\Services\Reset\ResetService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ResetController extends Controller
{   
    protected $resetService;

    public function __construct(ResetService $resetService)
    {   
        $this->middleware("can.reset.database");
        $this->resetService = $resetService;
    }
    public function resetDatabase(): RedirectResponse
    {
        $this->resetService->resetDatabase();
        Session()->flash('flash_message_success', __('Base de données réinitialisée avec succès'));
        return redirect()->back();
    }
}
