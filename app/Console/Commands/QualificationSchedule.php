<?php

namespace App\Console\Commands;
use App\Mail\QualificationScheduleMailAutoMail;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

use Illuminate\Console\Command;

class QualificationSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'document-qualification:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send document qualification schedule to users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        // 1. Get documents that have a review date in this month
        $documentsThisMonth = \App\DocumentEquipment::whereIn('document_type', [
            'Performance Qualification Report',
            'Operational Qualification Report',
            'Periodic Review',
            'Validation Report'
        ])
        ->whereNotNull('next_review')
        ->whereBetween('next_review', [$startOfMonth, $endOfMonth])
        ->get();

        if ($documentsThisMonth->isEmpty()) {
            $this->info("Tidak ada dokumen yang jatuh tempo bulan ini, email tidak dikirim.");
            return;
        }

        $documentIds = $documentsThisMonth->pluck('id')->toArray();

        // 2. Get PIC mappings for these documents
        $picDocuments = \App\PicDocument::with(['pic', 'ccPic', 'document.equipment', 'document.utility'])
            ->whereIn('document_id', $documentIds)
            ->get();

        if ($picDocuments->isEmpty()) {
            $this->info("Tidak ada PIC yang terkait dengan dokumen yang jatuh tempo.");
            return;
        }

        // 3. Group by main PIC
        $groupedByPic = $picDocuments->groupBy('pic_id');

        // 4. Send email per PIC
        foreach ($groupedByPic as $picId => $picDocs) {
            $mainPic = $picDocs->first()->pic;
            if (!$mainPic || !$mainPic->email) continue;

            $ccEmails = [];
            foreach ($picDocs as $pd) {
                if ($pd->ccPic && $pd->ccPic->email) {
                    $ccEmails[] = $pd->ccPic->email;
                }
            }
            $ccEmails = array_unique($ccEmails);

            // Send email
            $mail = Mail::to($mainPic->email);
            if (!empty($ccEmails)) {
                $mail->cc($ccEmails);
            }
            
            $mail->send(new QualificationScheduleMailAutoMail($mainPic->name, $picDocs));
        }

        $this->info("Notifikasi Qualification bulan ini berhasil dikirim ke " . $groupedByPic->count() . " PIC.");
    }


}
