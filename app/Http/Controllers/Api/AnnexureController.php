<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Annexure\AnnexureARequest;
use App\Http\Requests\Annexure\AnnexureBRequest;
use App\Http\Requests\Annexure\AnnexureCRequest;
use App\Http\Requests\Annexure\AnnexureDRequest;
use App\Interfaces\AnnexureRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class AnnexureController extends Controller
{
    private AnnexureRepositoryInterface $annexureRepo;

    function __construct(AnnexureRepositoryInterface $annexureRepo)
    {
        //accessing  repository from App\Repositories\AnnexureReposoty.php
        $this->annexureRepo = $annexureRepo;
    }

    /*
        * printing annexure a 
        * to print the annexure a we need reference number from user 
    */
    public function printAnnexureA(AnnexureARequest $request)
    {
        try {
            //calling function from App\Repositories\AnnexureReposoty.php
            $data = $this->annexureRepo->printAnnexureA($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        if ($data) {
            return response($data, Response::HTTP_OK);
        }
        return response()->json(["message" => "No request found or collection is not accepted!", "data" => ""], Response::HTTP_NOT_FOUND);
    }

    /*
        * printing annexure b 
        * to print the annexure a we need reference number from user 
    */
    public function printAnnexureB(AnnexureBRequest $request)
    {
        try {
            //calling function from App\Repositories\AnnexureReposoty.php
            $data = $this->annexureRepo->printAnnexureB($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        if ($data) {
            //returning view for the print annexure which is comming from repo
            return response($data, Response::HTTP_OK);
        }
        return response()->json(["message" => "No request found or collection request is not submitted ", "data" => ""], Response::HTTP_NOT_FOUND);
    }
    public function printAnnexureC(AnnexureCRequest $request)
    {

        try {
            //calling function from App\Repositories\AnnexureReposoty.php
            $data = $this->annexureRepo->printAnnexureC($request);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        if ($data) {
            //returning view for the print annexure which is comming from repo
            return response($data, Response::HTTP_OK);
        }
        return response()->json(["message" => "No request found ", "data" => ""], Response::HTTP_NOT_FOUND);
    }
    public function printAnnexureD(AnnexureDRequest $request)
    {
        try {
            //calling function from App\Repositories\AnnexureReposoty.php
            $data = $this->annexureRepo->printAnnexureD($request);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json(["message" => "Internal Server Error", "data" => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        if ($data) {
            //returning view for the print annexure which is comming from repo
            return response($data, Response::HTTP_OK);
        }
        return response()->json(["message" => "No request found or collection is not repair completed!", "data" => ""], Response::HTTP_NOT_FOUND);
    }
}
