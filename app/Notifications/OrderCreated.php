<?php

namespace App\Notifications;

use App\Mail\OrderCreated as MailOrderCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Invoice;
use Illuminate\Support\Facades\URL;

class OrderCreated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $invoice;
    public function __construct(Invoice $invoice)
    {
        $this->invoice=$invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        //return (new MailMessage)
          //          ->line('The introduction to the notification.')
            //        ->action('Notification Action', url('/'))
              //      ->line('Thank you for using our application!');

        return (new MailMessage) //(new MailMessage)
          //      //->view("email.order.created");
                ->subject("Order Created | Thank You For Shopping")
               ->greeting("Order Created")
               ->line("We are preparing your order")
               ->action("View Order",URL::signedRoute("mailinvoice",["invoice"=>$this->invoice->id]));

       // return new MailOrderCreated($this->invoice);
             
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
