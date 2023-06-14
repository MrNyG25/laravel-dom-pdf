<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;

class PDFController extends Controller
{

    function generatePDF($html, $filename)
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        // Get the PDF content
        $output = $dompdf->output();
        

        // Save the PDF file in the storage
        Storage::disk('public')->put($filename, $output);

        // Save the PDF file
        $dompdf->stream($filename);
    }

    public function downloadPDF(Request $request)
    {
        $html = '<!DOCTYPE html>
        <html>
        <head>
            <title>Flight Ticket</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f5f5f5;
                    margin: 0;
                    padding: 20px;
                }
        
                #ticket {
                    background-color: #fff;
                    border-radius: 5px;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                    padding: 20px;
                    margin: 0 auto;
                    max-width: 500px;
                    text-align: center;
                }
        
                h1 {
                    color: #333;
                    font-size: 24px;
                    margin-bottom: 20px;
                }
        
                p {
                    color: #555;
                    font-size: 16px;
                    margin-bottom: 10px;
                }
        
                strong {
                    font-weight: bold;
                }
            </style>
        </head>
        <body>
            <div id="ticket">
                <h1>Flight Ticket</h1>
                <p><strong>Airline:</strong> XYZ Airlines</p>
                <p><strong>Flight Number:</strong> FL123</p>
                <p><strong>Date:</strong> June 15, 2023</p>
                <p><strong>Departure:</strong> New York (JFK)</p>
                <p><strong>Destination:</strong> London (LHR)</p>
                <p><strong>Passenger:</strong> John Doe</p>
            </div>
        </body>
        </html>';
        $filename = 'example.pdf';

        $this->generatePDF($html, $filename);
    }

    
}
