<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Screening;

class FinishPastScreenings extends Command
{
    protected $signature = 'screenings:finish-past';

    protected $description = 'Zmienia status zakończonych seansów na finished';

    public function handle(): int
    {
        $screenings = Screening::with('movie')
            ->where('status', '!=', 'cancelled')
            ->where('status', '!=', 'finished')
            ->get();

        $count = 0;

        foreach ($screenings as $screening) {

            if (!$screening->movie) {
                continue;
            }

            //sprawdza czy data + czas trawnia < now()
            $endTime = $screening->start_time
                ->copy()
                ->addMinutes($screening->movie->duration);

            if ($endTime->isPast()) {
                $screening->status= 'finished';
                $screening->save();

                $count++;
            }
        }

        $this->info("Zaktualizowano {$count} seansów.");

        return Command::SUCCESS;
    }
}
