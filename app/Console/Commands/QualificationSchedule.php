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
        $currentMonth = Carbon::now()->format('Y-m');
        $monthlyLink = 'http://qa-kkv.ottoportal.info:8080/documents/scedule?start_month=' . $currentMonth . '&end_month=' . $currentMonth . '&print=1';
        $warningLink = 'http://qa-kkv.ottoportal.info:8080/documents/scedule?priority=warning&print=1';
        $overdueLink = 'http://qa-kkv.ottoportal.info:8080/documents/scedule?priority=overdue&print=1';

        $links = [];

        // Tambahkan link overdue di awal
        $links = [
            'Qualification Overdue' => $overdueLink,
            'Qualification This Month' => $monthlyLink,
            'Qualification 1 Week' => $warningLink,
        ];

        $nonEmptyLinks = [];

        foreach ($links as $name => $url) {
            if ($this->getCount($url) > 0) {
                $nonEmptyLinks[$name] = $url;
            }
        }

        // Jika semua kosong → jangan kirim email
        if (empty($nonEmptyLinks)) {
            $this->info("Semua data kosong, email tidak dikirim.");
            return;
        }

        // Ambil email admin
        $emails = User::where('role', 'admin, technician, supervisor')->pluck('email')->toArray();

        if (!empty($emails)) {
            Mail::to($emails)->send(new QualificationScheduleMailAutoMail($nonEmptyLinks));
            $this->info("Notifikasi Qualification berhasil dikirim dengan " . count($nonEmptyLinks) . " link.");
        }

    }

    private function getCount($url)
    {
        $json = @file_get_contents($url . '&count=1');
        if (!$json) return 0;

        $data = json_decode($json, true);
        return $data['total'] ? $data['total'] : 0;
    }


}
