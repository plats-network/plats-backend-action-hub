<?php

namespace App\View\Components;

use Illuminate\Contracts\Session\Session;
use Illuminate\Support\MessageBag;
use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * Type of message
     *
     * @var string
     */
    public $type;

    /**
     * @var \Illuminate\Contracts\Session\Session
     */
    protected $session;

    /**
     * @param \Illuminate\Contracts\Session\Session $session
     * @param string $type
     */
    public function __construct(Session $session, string $type = 'danger')
    {
        $this->session = $session;
        $this->type = $type;
    }
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('components.alert');
    }

    /**
     * Get message from session
     *
     * @return array|string
     */
    public function messages()
    {
        // Get errors from form validate
        $messages = $this->session->get('errors', new MessageBag());
        if ($messages->has('message') || $messages->count() > 0) {
            $allBag = $messages->all();

            return count($allBag) > 1 ? $allBag : $allBag[0];
        }

        // Change type
        $this->type = 'success';

        // Get message
        return $this->session->get('success', $this->session->get('message'));
    }

    /**
     * Determine if the component should be rendered.
     *
     * @return bool
     */
    public function shouldRender(): bool
    {
        return !empty($this->messages());
    }
}
