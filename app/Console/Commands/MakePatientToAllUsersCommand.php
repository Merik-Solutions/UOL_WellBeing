<?php

namespace App\Console\Commands;

use App\Models\{
    Chat,
    Note,
    Prescription,
    Rating,
    User,
    Reservation,
    UserDoctorPackage,
};

use Illuminate\Console\Command;

class MakePatientToAllUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create patient to all users ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Create Patient For Existing Users \n");
        $this->withProgressBar(User::all(), function (User $user) {
            if ($user->patients->count() == 0) {
                $user->patients()->create($user->toArray());
            }
        });
        $this->info('Done');
        $this->info("Update Reservations For Existing Users \n");

        $this->withProgressBar(Reservation::all(), function (
            Reservation $reservation,
        ) {
            $reservation->update([
                'patient_id' => $reservation->user->patients->first()->id,
            ]);
        });
        $this->info('done');

        $this->info("Update Prescription For Existing Users \n");

        $this->withProgressBar(
            Prescription::where('patient_id', null)->get(),
            function (Prescription $prescription) {
                $prescription->update([
                    'patient_id' => $prescription->user->patients->first()->id,
                ]);
                $prescription->items()->firstOrCreate([
                    'name' => 'panadol',
                    'dose' => '1 tablet',
                    'dose_number' => 3,
                    'days' => 7,
                ]);
            },
        );
        $this->info('done');

        $this->info("Update Note For Existing Users \n");

        $this->withProgressBar(
            Note::where('patient_id', null)->get(),
            function (Note $note) {
                $note->update([
                    'patient_id' => $note->user->patients->first()->id,
                ]);
            },
        );
        $this->info('done');

        $this->info("Update Chat For Existing Users \n");

        $this->withProgressBar(
            Chat::where('patient_id', null)->get(),
            function (Chat $chat) {
                $chat->update([
                    'patient_id' => $chat->user->patients->first()->id,
                ]);
            },
        );

        $this->info('done');

        $this->info("Update Rating For Existing Users \n");
        $this->withProgressBar(
            Rating::where('patient_id', null)->get(),
            function (Rating $rating) {
                $rating->update([
                    'patient_id' => $rating->user->patients->first()->id,
                ]);
            },
        );

        $this->info('done');
        $this->info("Update UserDoctorPackage For Existing Users \n");
        $this->withProgressBar(
            UserDoctorPackage::where('patient_id', null)->get(),
            function (UserDoctorPackage $package) {
                $package->update([
                    'patient_id' => $package->user->patients->first()->id,
                ]);
            },
        );

        $this->info('done');

        return static::SUCCESS;
    }
}
