<?php

namespace App\Http\Controllers;

use App\Models\QuizMaster;
use App\Http\Requests\StoreQuizMasterRequest;
use App\Http\Requests\UpdateQuizMasterRequest;

class QuizMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreQuizMasterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuizMasterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuizMaster  $quizMaster
     * @return \Illuminate\Http\Response
     */
    public function show(QuizMaster $quizMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuizMaster  $quizMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(QuizMaster $quizMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQuizMasterRequest  $request
     * @param  \App\Models\QuizMaster  $quizMaster
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuizMasterRequest $request, QuizMaster $quizMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuizMaster  $quizMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuizMaster $quizMaster)
    {
        //
    }
}
