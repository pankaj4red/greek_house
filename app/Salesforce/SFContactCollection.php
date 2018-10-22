<?php

namespace App\Salesforce;

class SFContactCollection extends SFModelCollection
{
    /**
     * Find Contact based on user email
     *
     * @param string $email
     * @return SFContact|null
     */
    public function findByEmail($email)
    {
        /** @var SFContact $contact */
        foreach ($this as $contact) {
            if (mb_strtolower($contact->Email) == mb_strtolower($email)) {
                return $contact;
            }
        }

        return null;
    }

    /**
     * Find Contact based on Salesforce Id
     *
     * @param string $id
     * @return SFContact|null
     */
    public function findById($id)
    {
        foreach ($this as $contact) {
            /** @var SFContact $contact */
            if ($contact->Id == $id) {
                return $contact;
            }
        }

        return null;
    }
}