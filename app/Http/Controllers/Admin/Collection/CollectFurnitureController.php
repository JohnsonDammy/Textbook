<?php

namespace App\Http\Controllers\Admin\Collection;

use App\Http\Controllers\Controller;
use App\Http\Requests\Annexure\AnnexureARequest;
use App\Http\Requests\Annexure\AnnexureBRequest;
use App\Http\Requests\Annexure\AnnexureCRequest;
use App\Http\Requests\Annexure\AnnexureDRequest;
use App\Http\Requests\FurnitureCollection\StoreCollectionItems;
use App\Http\Requests\FurnitureCollection\StoreDeliverCollectionRequest;
use App\Http\Requests\FurnitureCollection\StoreRepairCollectionRequest;
use App\Http\Requests\UploadDisposalImages;
use App\Http\Requests\UploadDisposalImagesRequest;
use App\Http\Requests\UploadProofOfReplenishmentRequest;
use App\Interfaces\FurnitureRequest\CollectFurnitureRepositoryInterface;
use App\Interfaces\AnnexureRepositoryInterface;
use App\Interfaces\FileUploadRepositoryInterface;
use App\Interfaces\FurnitureRequest\RepairFurnitureRepositoryInterface;
use App\Models\RequestStatus;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class CollectFurnitureController extends Controller
{
    private CollectFurnitureRepositoryInterface $collectRepository;
    private AnnexureRepositoryInterface $annexureRepository;
    private FileUploadRepositoryInterface $fileUploadRepository;
    private RepairFurnitureRepositoryInterface $repairRepository;

    function __construct(CollectFurnitureRepositoryInterface $repository, AnnexureRepositoryInterface $annexureRepository, FileUploadRepositoryInterface $fileUploadRepository, RepairFurnitureRepositoryInterface $repairRepository)
    {
        $this->collectRepository = $repository;
        $this->annexureRepository = $annexureRepository;
        $this->repairRepository = $repairRepository;
        $this->fileUploadRepository = $fileUploadRepository;

        $this->middleware('permission:collect-furniture-list|collect-furniture-create|repair-furniture-list|deliver-furniture-list', ['only' => ['viewrequest']]);
        $this->middleware('permission:collect-furniture-create', ['only' => ['acceptrequest', 'store', 'annexurea']]);
        $this->middleware('permission:repair-furniture-create', ['only' => ['annexureb', 'annexurecmail', 'uploadproof', 'uploadDisposalImages', 'submitrepair']]);
        $this->middleware('permission:deliver-furniture-create', ['only' => ['annexured', 'submitdeliver']]);
    }

    // view furniture collection request
    public function viewrequest($ref_no)
    {
        $data = $this->collectRepository->getSingleCollectionRequest($ref_no);
        if (!$data) {
            return back()->with("error", "No collection request found with \"$ref_no\"");
        }
        switch ($data->status_id) {
            case RequestStatus::COLLECTION_PENDING:
                return view('furniture.collectionrequest.collectfurniture', ['data' => $data]);
                break;
            case RequestStatus::COLLECTION_ACCEPTED:
                return view('furniture.collectionrequest.collectfurniture', ['data' => $data]);
                break;
            case RequestStatus::REPAIR_PENDING:
                return view('furniture.collectionrequest.repair', ['data' => $data]);
                break;
            case RequestStatus::REPAIR_COMPLETED:
                return view('furniture.collectionrequest.deliver', ['data' => $data]);
                break;
            case RequestStatus::DELIVERY_PENDING:
                return view('furniture.collectionrequest.deliver', ['data' => $data]);
                break;
            case RequestStatus::DELIVERY_CONFIRMED:
                return view('furniture.collectionrequest.processcomplete', ['data' => $data]);
                break;
            default:
                return redirect('/furniture-replacement');
                break;
        }
    }

    // accept furniture collection request
    public function acceptrequest($id)
    {
        $request = $this->collectRepository->acceptCollectFurniture($id);
        if ($request == null) {
            return redirect('/furniture-replacement')->with('error', 'Request already accepted or No request found!');
        }
        return redirect('/furniture-replacement/collect/reference/' . $request->ref_number);
    }

    // store images and confirmed count - furniture collection request
    public function store(StoreCollectionItems $request)
    {
        if (!$request->validator->fails()) {
            try {
                $data = $this->collectRepository->addAcceptCollectFurnitureRequest($request);
            } catch (\Throwable $th) {
                throw $th;
                return back()->with('error', 'Error - Submitting changes failed. ' . $th->getMessage())->withInput();
            }
            if ($data) {
                return redirect('/furniture-replacement')
                    ->with('success', 'The changes have been submitted successfully!');
            }
            dd($data);
            return back()->with('error', 'Submitting changes failed')->withInput();
        }
        // dd($request->validator->errors());
        return redirect()->back()->withErrors($request->validator->errors());
    }

    // download annexure a - pickup slip
    public function annexurea(AnnexureARequest $request)
    {
        try {
            $data = $this->annexureRepository->printAnnexureA($request);
            return $data->download();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // download annexure b - disposal certificate
    public function annexureb(AnnexureBRequest $request)
    {
        try {
            $data = $this->annexureRepository->printAnnexureB($request);
            return $data->download();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // download annexure c - replenish form
    public function annexurecmail(AnnexureCRequest $request)
    {
        try {
            $data = $this->annexureRepository->printAnnexureC($request);
            return $data->download();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // change replenish decision and upload proof
    public function uploadproof(UploadProofOfReplenishmentRequest $request)
    {
        if ($request->validated()) {

            try {
                $data = $this->fileUploadRepository->uploadProofOfReplineshment($request);
                if ($data) {
                    return redirect('/furniture-replacement/collect/reference/' . $request->ref_number);
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        return back();
    }

    public function uploadDisposalImages(UploadDisposalImagesRequest $request)
    {
        try {
            $data = $this->fileUploadRepository->uploadProofOfDisposal($request);
            if ($data) {
                return redirect('/furniture-replacement/collect/reference/' . $request->ref_number);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
        return back();
    }

    // submit repair - furniture collection request
    public function submitrepair(StoreRepairCollectionRequest $request)
    {
        if ($request->validated()) {
            try {
                $data = $this->repairRepository->storerepair($request);
                if ($data) {
                    return response($data, Response::HTTP_CREATED);
                }
            } catch (\Throwable $th) {
                throw $th;
                return response($data, Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            return response($data, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // download annexure d - delivery note
    public function annexured(AnnexureDRequest $request)
    {
        try {
            $data = $this->annexureRepository->printAnnexureD($request);
            return $data->download();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // submit delivery and upload signed delivery note
    public function submitdeliver(StoreDeliverCollectionRequest $request)
    {
        if ($request->validated()) {
            try {
                $data = $this->fileUploadRepository->submitCollectionDelivery($request);
            } catch (\Throwable $th) {
                return back()->with('error', 'Submitting changes failed ' . $th->getMessage())->withInput();
            }
            if ($data) {
                return redirect('/furniture-replacement')
                    ->with('success', 'The changes have been submitted successfully!');
            }
            return back()->with('error', 'Submitting changes failed')->withInput();
        }
    }
}
