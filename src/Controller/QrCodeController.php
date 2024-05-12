<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class QrCodeController extends AbstractController
{
    #[Route('/generate_qr_code/{productName}/{productCategory}/{productPrice}/{productSubtitle}', name: 'generate_qr_code')]
    public function generateQrCode($productName, $productCategory, $productPrice, $productSubtitle): Response
    {
        // Concatenate product information into a single string
        $productInfo = "Name: $productName\nCategory: $productCategory\nPrice: $productPrice\nSubtitle: $productSubtitle";

        // Create the QR code using the concatenated product information
        $qrCode = new QrCode($productInfo);
        $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::High);
        $qrCode->setMargin(10);
        $qrCode->setEncoding(new Encoding('UTF-8'));
        $qrCode->setSize(300);

        // Generate the QR code image
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Return the QR code image as a response
        return new Response($result->getString(), 200, [
            'Content-Type' => 'image/png',
        ]);
    }
}
