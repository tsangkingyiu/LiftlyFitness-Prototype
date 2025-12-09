<?php

namespace Modules\Frontend\Mail;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $post;
    public $subscriber;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Post $post, $subscriber)
    {
        $this->post = $post;
        $this->subscriber = $subscriber;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $encryptedEmail = encryptDecryptId($this->subscriber->email, 'encrypt');
        return $this->markdown('frontend::frontend.emails.post_notification')
        ->subject(__('frontend::message.new_blog') . ': ' . $this->post->title)
        ->with([
            'post' => $this->post,
            'subscriber' => $this->subscriber,
        ]);
    }
}
