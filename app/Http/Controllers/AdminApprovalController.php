<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminApprovalController extends Controller
{
    //
    public function view_approved_data() {
        return view('adminapproval.dokumen-approved');
    }
}
