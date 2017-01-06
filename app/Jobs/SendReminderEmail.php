<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Product;
use App\Models\User;
use Mail;
use App\Mail\MailNewProduct;

class SendReminderEmail implements ShouldQueue
{

    use InteractsWithQueue,
        Queueable,
        SerializesModels;

    protected $user;
    protected $product;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Product $product)
    {
        $this->user = $user;
        $this->product = $product;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user->email)->send(new MailNewProduct($this->product));
    }

}
