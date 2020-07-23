<?php

namespace App\Http\Controllers;

use App\Call;
use App\Jobs\processCalls;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class callsController
 * @package App\Http\Controllers
 */
class callsController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeCall(Request $request){
        $call = $this->store($request);
        return response()->json($call);
    }

    /**
     * @param Request $request
     * @return Call|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'callerID' => 'required|phone_number',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $call = new Call([
            'callerID' => $request->get('callerID')
        ]);
        $call->save();
        processCalls::dispatch($call)->onQueue('calls');
        return $call;
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request , $id)
    {
//        $request->validate([
//            'first_name'=>'required',
//            'last_name'=>'required',
//            'email'=>'required'
//        ]);

        $call = Call::find($id);
        $call->answered=1;

        $call->save();
        return redirect('/contacts')->with('success', 'Contact updated!');
    }

}
