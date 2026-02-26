<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Plan;
use Carbon\Carbon;

class SendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
    Mail::raw('This is a scheduled email from Laravel!', function ($message) {
     $plan = Plan::where('expire_date', '<', Carbon::now()->subDays(30))->get();
      $message->to('jobandhillonn@gmail.com')
        ->subject('Scheduled Email');
    });

    $this->info('Mail sent successfully!');
    }
}
