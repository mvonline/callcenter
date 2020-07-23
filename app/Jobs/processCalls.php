<?php

namespace App\Jobs;

use App\Agent;
use App\Call;
use App\Http\Controllers\callsController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

/**
 * Class processCalls
 * @package App\Jobs
 */
class processCalls implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Call
     */
    protected $call;


    /**
     * Create a new job instance.
     *
     * @param Request $request
     * @param Call $call
     */
    public function __construct(Call $call)
    {
        $this->call = $call;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        dd(Agent::orderByRaw("FIELD(position, \"Manager\", \"Supervisor\", \"Agent\")")->get());
        $responder = DB::table('agents')->where('is_free','=',true)->orderByRaw("FIELD(position, \"Agent\", \"Supervisor\",\"Manager\")")->first();
        $this->update_responder($responder->id,false);
        DB::table('calls')->where('id', $this->call->id)->update(['answered' => 1]);
        $this->update_responder($responder->id,true);
    }

    /**
     * @param $id
     * @param $status
     */
    public function update_responder($id, $status){
        DB::table('agents')->where('id', $id)->update(['is_free' => $status]);
    }
}
