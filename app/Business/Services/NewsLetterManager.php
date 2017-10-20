<?php

namespace App\Business\Services;

use Mailchimp;
use Mailchimp_Error;
use Mailchimp_List_AlreadySubscribed;

class NewsletterManager
{
    protected $mailchimp;
    protected $listId = '425f3ecd67';        // Id of newsletter list

    /**
     * Pull the Mailchimp-instance from the IoC-container.
     * @param Mailchimp $mailchimp
     */
    public function __construct(Mailchimp $mailchimp)
    {
        $this->mailchimp = $mailchimp;
    }

    /**
     * Access the mailchimp lists API
     * for more info check "https://apidocs.mailchimp.com/api/2.0/lists/subscribe.php"
     */
    public function addEmailToList($email)
    {
        try {
            $this->mailchimp
                ->lists
                ->subscribe(
                    $this->listId,
                    ['email' => $email]
                );
            return true;
        } catch (Mailchimp_List_AlreadySubscribed $e) {
            return false;
        } catch (Mailchimp_Error $e) {
            throw new \Exception($e->getMessage());
        }
    }
}