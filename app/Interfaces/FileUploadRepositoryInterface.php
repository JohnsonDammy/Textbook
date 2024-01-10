<?php

namespace App\Interfaces;

interface FileUploadRepositoryInterface
{
    public function uploadProofOfDisposal(object $request);
    public function uploadProofOfReplineshment(object $request);
    public function submitCollectionDelivery(object $request);
}
