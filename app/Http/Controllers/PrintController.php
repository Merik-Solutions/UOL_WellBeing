<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Note;
use App\Models\Prescription;
use App\Models\Reservation;
use App\Models\UserDoctorPackage;
// use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PDF;

class PrintController extends Controller
{
    public function printPrescription(Prescription $prescription)
    {
        set_time_limit(300);

        $pdf = \PDF::loadHTML(
            view('prescription', compact('prescription'))->render(),
        );
        // $pdf = $pdf->setOption('page-width', '100')->setPaper('b5');

        // $pdf->setOption('enable-javascript', true);
        // $pdf->setOption('enable-external-links', true);
        // $pdf->setOption('enable-internal-links', true);
        // $pdf->setOption('enable-local-file-access', true);

        // return view('prescription', compact('prescription'));
       return $pdf->download("prescription_{$prescription->id}.pdf");
    }
    public function printChat($id)
    {
        set_time_limit(300);
        $chat = Chat::find($id);

        $cm = $chat->media()->get();
        $m = $chat->messages()->get();
        $final = collect($cm->concat($m)); 
        $final = $final->sortByDesc('created_at');
        $data['chat'] = $chat;
        $data['messages'] = $final;
        $data['files'] = $chat->getMedia('files');       
        
        return view('admin.chats.print.chat_print', $data);

    //     $pdf = \PDF::loadHTML(
    //         view('admin.chats.print.chat_print', $data)->render(),
    //     );
    //     // $pdf = $pdf->setOption('page-width', '100')->setPaper('b5');

    //    return $pdf->inline("chat_{$chat->id}.pdf");
    }

    public function printNote($id){
        $data['note'] = Note::find($id);
        return view('admin.clinical_notes.print.print_note', $data);
    }

    public function reservationInvoice($res_id)
    {
        if(!isset($res_id)){
            echo "Please enter reservation id in the url like this: <br>";            
            echo "https://kindahealth.com/admin/en/invoice-pdf/reservation_id <br>";
            echo "Replace reservation_id with actual ID.";
            return false;
        }
        $reservation= Reservation::with([
            'doctor:id,name_en,name_ar,email',
            'Patient:id,name,national_id,email',
            'doctor.category',
            'transaction',
            'promocode' ])->find($res_id);
            $data['reservation'] = $reservation;
            $data['email'] = $reservation->patient->email;
            $data['patient_name'] = $reservation->patient?->name ?? '';
            // set_time_limit(300);
            // $pdf = \PDF::loadHTML(
            //     view('emails.reservation_invoice', $data)->render(),
            // );
            // $pdf = $pdf->setOption('page-width', '100')->setPaper('b4');    
            // return $pdf->inline("kindaHealth_reservation_invoice.pdf");

            // try {
            //     Mail::send('emails.invoice', $data, function($message)use($data,$pdf) {
            //         $message->to($data["email"], $data["patient_name"])
            //         ->subject("KindaHealth Reservation Invoice")
            //         ->attachData($pdf->output(), "kindahealth_invoice.pdf");
            //         });
            //     toast(__('Invoice mailed successfully'), 'success');

            // } catch (\Exception $e) {
            //     Log::info($e->getMessage());
            //     toast(__('Failed to mail invoice.'), 'error');
            // }
        return view('emails.reservation_invoice',$data);
    }

    public function packageInvoice($id)
    {
        if(!isset($id)){
            echo "Please enter package id in the url like this: <br>";            
            echo "https://kindahealth.com/admin/en/package-invoice/package_id <br>";
            echo "Replace package_id with actual ID.";
            return false;
        }
        $package = UserDoctorPackage::with([
            'doctor:id,name_en,name_ar,company_name,email,national_id',
            'patient:id,name,user_id,relation,email,national_id',
            'transaction',
            'promocode'])->find($id);
            
       
            $data['package'] = $package;
            $data['email'] = $package->patient->email;
            $data['patient_name'] = $package->patient?->name ?? '';
            $data['title'] = 'Message Package';
            // set_time_limit(300);
            
            // $pdf = \PDF::loadHTML(
            //     view('emails.package_invoice', $data)->render(),
            // );
            // $pdf = $pdf->setOption('page-width', '100')->setPaper('b4');    
            // return $pdf->inline("kindaHealth_package_invoice.pdf");

            // try {
            //     Mail::send('emails.invoice', $data, function($message)use($data,$pdf) {
            //         $message->to($data["email"], $data["patient_name"])
            //         ->subject("KindaHealth Package Invoice")
            //         ->attachData($pdf->output(), "kindahealth_invoice.pdf");
            //         });
            // } catch (\Exception $e) {
            //     Log::info($e->getMessage());
            // }

        return view('emails.package_invoice',$data);
    }
}
