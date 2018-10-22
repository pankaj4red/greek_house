<?php

namespace App\Http\Controllers;

abstract class ModuleController extends BlockController
{
    /**
     * @param integer  $campaignId
     * @param string[] $parameters
     * @param string[] $subTokens
     * @return $this
     */
    public function configure($campaignId, $parameters, $subTokens = [])
    {
        $this->campaignId = $campaignId;
        $this->parameters = array_merge($parameters, $subTokens, [
            'blockName' => $this->getBlockName(),
            'blockUrl'  => route('customer_module', [$this->getBlockName(), $this->campaignId]),
            'popupUrl'  => route('customer_module_popup', [$this->getBlockName(), $this->campaignId]),
        ]);

        $this->accessTokenManager->addToken($this->getBlockName());
        foreach ($subTokens as $subToken => $value) {
            $this->accessTokenManager->addToken($this->getBlockName(), $subToken, $value);
        }
        $this->accessTokenManager->addToken($this->getBlockName(), 'edit', $this->parameters['edit']);
        $this->accessTokenManager->addToken($this->getBlockName(), 'view', $this->parameters['view']);

        return $this;
    }
}
