<?php

namespace App\Http\Controllers\Provider\Profile;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;


final class ContactUsController extends Controller
{
    /**
     * Handle the Contact us request.
     */
    public function __invoke(Request $request)
    {
        $data = $request->validate(ContactUs::rule());

        ContactUs::create($data);

        return ResponseHelper::success(__('home.Message sent successfully'));

    }
}
