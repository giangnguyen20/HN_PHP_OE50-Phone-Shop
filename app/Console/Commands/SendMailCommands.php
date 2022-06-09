<?php

namespace App\Console\Commands;

use App\Mail\SendMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;

class SendMailCommands extends Command
{
    protected $userRepo;
    protected $orderRepo;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weekly-sendMail:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        UserRepositoryInterface $userRepo,
        OrderRepositoryInterface $orderRepo
    ) {
        parent::__construct();
        $this->userRepo = $userRepo;
        $this->orderRepo = $orderRepo;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = $this->userRepo->getAdmins();
        $orders = $this->orderRepo->getTheOrderQuantity();

        foreach ($users as $user) {
            $mailable = new SendMail($user, $orders);
            Mail::to($user)->queue($mailable);
        }

        return true;
    }
}
