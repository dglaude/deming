<?php

namespace App\Http\Controllers;

Use \Carbon\Carbon;

use App\Exports\MeasuresExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Measure;
use App\Control;
use App\Domain;
use App\Measurement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MeasureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $measures = Measure::All();
        $domains = Domain::All();

        $domain=$request->get("domain");
        if ($domain<>null) {
            if ($domain=="0") { 
                $request->session()->forget("domain");
                $domain=null;
            }
        }
        else {
            $domain=$request->session()->get("domain");
        }

        if (($domain<>null)) {
            $measures = Measure::where("domain_id", $domain)->get()->sortBy("clause");
            $request->session()->put("domain", $domain);
        }
        else {
            $measures = Measure::All()->sortBy("clause");
        }

        // return
        return view("measures.index")
            ->with("measures", $measures)
            ->with("domains", $domains);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // get the list of domains
        $domains = Domain::All();

        //dd($domains);

        // store it in the response 
        return view("measures.create")->with('domains', $domains);;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate(
            $request, [
            "domain_id" => "required",
            "clause" => "required|min:3|max:30",
            "name" => "required|min:5",
            "objective" => "required"
            ]
        );
    
        $measure = new Measure();

        $measure->domain_id = request("domain_id");
        $measure->clause = request("clause");
        $measure->name = request("name");
        $measure->objective = request("objective");
        $measure->attributes = request("attributes");
        $measure->model = request("model");
        $measure->indicator = request("indicator");
        $measure->action_plan = request("action_plan");
        $measure->owner = request("owner");
        $measure->periodicity = request("periodicity");
        $measure->retention= request("retention");

        $measure->save();

        $request->session()->put("domain", $measure->domain_id);

        return redirect("/measures");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Measure $measure
     * @return \Illuminate\Http\Response
     */
    public function show(Measure $measure)
    {
        return view("measures.show", compact("measure"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Measure $measure
     * @return \Illuminate\Http\Response
     */
    public function edit(Measure $measure)
    {
        // get the list of domains
        $domains = Domain::All();

        return view("measures.edit", compact("measure"))->with('domains', $domains);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Measure             $measure
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Measure $measure)
    {
        $this->validate(
            $request, [
            "domain_id" => "required",
            "clause" => "required|min:3|max:30",
            "name" => "required|min:5",
            "objective" => "required"
            ]
        );

        // update measure
        $measure->domain_id = request("domain_id");
        $measure->name = request("name");
        $measure->clause = request("clause");
        $measure->objective = request("objective");
        $measure->attributes = request("attributes");
        $measure->model = request("model");
        $measure->indicator = request("indicator");
        $measure->action_plan = request("action_plan");
        $measure->owner = request("owner");
        $measure->periodicity = request("periodicity");
        $measure->retention = request("retention");
        $measure->save();

        // update the current control
        $control=Control::where('measure_id', $measure->id)
                            ->where('realisation_date', null)
                            ->get()->first();
        if ($control<>null) {
            $control->clause = $measure->clause;
            $control->name = $measure->name;
            $control->objective = $measure->objective;
            $control->attributes = $measure->attributes;
            $control->model = $measure->model;
            $control->indicator = $measure->indicator;
            $control->action_plan = $measure->action_plan;
            $control->periodicity = $measure->periodicity;
            $control->periodicity = $measure->retention;
            $control->save();
        }

        // retun to view measure
        return redirect("/measures/".$measure->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Measure $measure
     * @return \Illuminate\Http\Response
     */
    public function destroy(Measure $measure)
    {
        //
        $measure->delete();
        return redirect("/measures");
    }


    /**
     * Activate a measure
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function activate(Request $request)
    {
Log::info("activate start");
        $this->validate(
            $request, [
                "id" => "required|integer"
            ]
        );

        $measure = Measure::find($request->id);

    	// Check control is disabled
        $active_control_id = DB::Table("controls")
            ->select("id")
            ->where("measure_id","=",$measure->id)
            ->where('realisation_date', null)
            ->first();
        if ($active_control_id==null) {
            // create a new control        
            $control = new Control();
            $control->measure_id=$measure->id;
            $control->domain_id=$measure->domain_id;
            $control->name=$measure->name;
            $control->clause=$measure->clause;
            $control->objective = $measure->objective;
            $control->attributes = $measure->attributes;
            $control->model = $measure->model;
            $control->indicator = $measure->indicator;
            $control->action_plan = $measure->action_plan;
            $control->owner = $measure->owner;
            $control->periodicity = $measure->periodicity;
            $control->retention = $measure->retention;
            $control->plan_date = Carbon::now()->endOfMonth();
            // Save it
            $control->save();

            // Update link
            $prev_control = Control::where("measure_id","=",$measure->id)
                ->where('next_id',null)
                ->where('id',"<>",$control->id)
                ->first();

            if ($prev_control!=null) {
                $prev_control->next_id=$control->id;
                $prev_control->update();
            }
        }

        // return to the list of measures
Log::info("activate done.");
        return null;
    }


    /**
     * Disable a measure
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function disable(Request $request)
    {
        $this->validate(
            $request, [
                "id" => "required|integer"
            ]
        );

        $control_id = DB::table('controls')
            ->select('id')
            ->where('measure_id', '=', $request->id)
            ->where('realisation_date', null)
            ->get()
            ->first()->id;
        if($control_id!=null) {
            // break link
            DB::update("UPDATE controls SET next_id = null WHERE next_id =" . $control_id);
            // delete control
            DB::delete("DELETE FROM controls WHERE id = " . $control_id);
           }

        // return to the list of measures
        return null;
    }

    /**
     * set Maturity of a control
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function maturity(Request $request)
    {
        $this->validate(
            $request, [
                "id" => "required|integer",
                "value" => "required|integer|min:0|max:5",
            ]
        );

         DB::table('measures')
              ->where('id', $request->id)
              ->update(['maturity' => $request->value]);

        // DB::update("UPDATE  SET maturity = "& $request->value &" WHERE id =" . $request->id);

        return null;
    }

    public function export() 
    {
        return Excel::download(new MeasuresExport, 'measures.xlsx');
    }    

}
