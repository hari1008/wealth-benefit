<?php

namespace App\Http\Controllers;

use App\Contracts\AdminContract;
use Illuminate\Support\Facades\Auth;

class SubAdminController extends BaseController {

    protected $subadmin;

    public function __construct(AdminContract $admin) {
        parent::__construct();
        $this->admin = $admin;
        $this->middleware('auth', ['except' => [ 'getForgotPassword', 'postForgotPassword','getWelcome','getTermsCondition']]);
        $this->middleware('xss', ['except' => ['postAddTermsCondition','getAddTermsCondition']]);
    }
    
    

    /**
     * @function getUserListing
     * @purpose to get user listing
     * @return type
     *
     */
    public function getMyEcosystem() {
        print_r('Subadmin Panel!!'); die;
        echo '<pre>';
        print_r(Auth::user()->subAdminEcosystem()->first()); die;
        return $this->admin->getUserListing();
    }

}
