<?php

namespace App\Mail;

use App\Models\Order;
use App\Support\OrderInvoicePdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Commande '.$this->order->reference.' payée — facture KIEL INDUSTRIES',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-confirmation',
        );
    }

    /** @return array<int, Attachment> */
    public function attachments(): array
    {
        try {
            $pdf = OrderInvoicePdf::generate($this->order);
        } catch (\Throwable $e) {
            Log::warning('Order confirmation sent without PDF attachment', [
                'order' => $this->order->reference,
                'message' => $e->getMessage(),
            ]);

            return [];
        }

        return [
            Attachment::fromData(fn () => $pdf, 'facture-'.$this->order->reference.'.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
